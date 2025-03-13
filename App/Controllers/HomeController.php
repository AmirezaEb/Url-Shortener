<?php

namespace App\Controllers;

use App\Core\Request;
use App\Models\{Url, User, View};
use App\Utilities\{Auth, ExceptionHandler, Lang};
use HeroQR\Core\QRCodeGenerator;

/* Developed by Hero Expert
- Telegram channel: @HeroExpert_ir
- Author: Amirreza Ebrahimi
- Telegram Author: @a_m_b_r
*/
class HomeController
{
    /**
     * Display the homepage.
     *
     * @return void Renders the home view.
     * @throws \Exception
     */
    public function index(): void
    {
        view('home.index');
    }

    /**
     * Handle URL creation and optional QR code generation.
     *
     * @param Request $request The HTTP request containing user input data.
     * @return void Renders the home view or redirects on error.
     */
    public function createUrl(Request $request): void
    {
        try {
            # Check if the request is a POST with the necessary parameters
            if ($request->method() !== 'post' && !$request->has('sub-create') && !$request->param('Url')) {
                # Render the home view for non-POST requests
                view('home.index');
            }

            # Verify user authentication
            $userEmail = Auth::checkLogin();
            if (!$userEmail) {
                throw new \Exception(Lang::get('Er-Login'));
            }

            # Retrieve authenticated user
            $user = User::where('email', $userEmail)->first();

            # Validate the provided URL
            $url = $request->param('Url');
            if (!$this->validateUrl($url)) {
                throw new \Exception(Lang::get('Er-InvalidUrl'));
            }

            # Generate a unique short URL
            $shortUrlData = $this->generateShortUrl();

            # Generate QR code for the short URL
            $qrCodePath = $this->generateQrCode($shortUrlData->url, $shortUrlData->name);

            # Save the URL details to the database
            $savedUrl = Url::create([
                'created_by' => $user->id,
                'url' => htmlspecialchars($url, ENT_QUOTES, 'UTF-8'),
                'shortUrl' => $shortUrlData->name,
                'qrCode' => $qrCodePath,
            ]);

            # Handle potential save errors
            if (!$savedUrl || !file_exists('public/QrCode/' . $shortUrlData->name . '.png')) {
                throw new \Exception(Lang::get('Er-TryAgain'));
            }

            # Prepare data for view
            $data = (object)['ShortUrl' => $shortUrlData->url];

            # Set success message and render the homepage
            ExceptionHandler::setMessage(Lang::get('Ms-Create'));
            view('home.index', $data);
        } catch (\Exception $e) {
            # Handle exceptions and redirect to the homepage with an error message
            ExceptionHandler::setErrorAndRedirect($e->getMessage(), './');
        }
    }

    /**
     * Redirect the user based on the shortened URL.
     *
     * @param Request $request The request containing the shortened URL parameter.
     * @return void Handles the redirect.
     */
    public function redirectUrl(Request $request): void
    {
        try {
            # Retrieve the short URL parameter from the request
            $shortUrl = $request->param('short_url');

            # Find the corresponding URL in the database
            $url = Url::where('shortUrl', $shortUrl)->firstOrFail();

            # Track the view for analytics purposes
            $this->trackView($url, $request);

            # Redirect the user to the original URL
            redirect($url->url);
        } catch (\Exception) {
            # Redirect to the homepage on error
            redirect('./');
        }
    }

    /**
     * Generate a unique shortened URL.
     *
     * @return object An object containing the shortened URL and its identifier.
     */
    private function generateShortUrl(): object
    {
        do {
            # Generate a new short URL identifier
            $shortUrlName = shortCreate();

            # Check if the short URL already exists in the database
            $exists = Url::where('shortUrl', $_ENV['APP_HOST'] . $shortUrlName)->exists();
        } while ($exists);

        # Return the generated short URL and its identifier
        return (object)[
            'url' => $_ENV['APP_HOST'] . $shortUrlName,
            'name' => $shortUrlName
        ];
    }

    /**
     * Generate a QR code image for a given URL.
     *
     * @param string $url The URL text to encode in the QR code.
     * @param string $name The file name for the QR code image.
     * @return string|bool The URL of the QR code image on success, false on failure.
     */
    private function generateQrCode(string $url, string $name): string|bool
    {
        $savePath = BASEPATH . 'public/QrCode/' . $name;

        try {
            # Generate and save the QR code image
            $qrCode = new QRCodeGenerator();
            $qrCode->setData($url)
                ->setMargin(15)
                ->generate('png', [
                    'Shape' => 'S1',
                    'Cursor' => 'C3',
                    'Marker' => 'M3'
                ])
                ->saveTo($savePath);

            return $_ENV['APP_HOST'] . 'public/QrCode/' . $name . '.png';
        } catch (\Exception) {
            # Return false if QR code generation fails
            return false;
        }
    }

    /**
     * Track unique views for a given URL to prevent duplicate view counts.
     *
     * @param Url $url The URL model instance.
     * @param Request $request The HTTP request containing client information.
     * @return void Increments view count if the view is unique.
     */
    private function trackView(Url $url, Request $request): void
    {
        # Retrieve client IP address and User Agent for uniqueness check
        $ipAddress = $request->ip();
        $userAgent = $request->agent();

        # Check if a view from the same IP and User Agent already exists
        $viewExists = View::where('url_id', $url->id)
            ->where('ip_address', $ipAddress)
            ->where('user_agent', $userAgent)
            ->exists();

        if (!$viewExists) {
            # Log the unique view in the database
            View::create([
                'url_id' => $url->id,
                'ip_address' => $ipAddress,
                'user_agent' => $userAgent,
            ]);

            # Increment the URL's view count
            $url->increment('views');
        }
    }

    /**
     * Validate the format and security of a URL.
     *
     * @param string $url The URL to be validated.
     * @return bool        True if the URL is valid, false otherwise.
     */
    private function validateUrl(string $url): bool
    {
        # Decode the URL to prevent double-encoded data.
        $url = urldecode($url);

        # Use filter_var to validate URL structure and ensure security.
        return filter_var($url, FILTER_VALIDATE_URL) &&
            preg_match("/^(https?:\/\/(?:www\.)?[a-zA-Z0-9\-\.]+(?:\.[a-zA-Z]{2,})+(?:\/[a-zA-Z0-9\-._~:\/?#[\]@!$&'()*+,;=]*)?)$|^(ftp:\/\/(?:www\.)?[a-zA-Z0-9\-\.]+(?:\.[a-zA-Z]{2,})+(?:\/[a-zA-Z0-9\-._~:\/?#[\]@!$&'()*+,;=]*)?)$|^(tel:\/\/[0-9\+\-\(\) ]+)$|^(file:\/\/[a-zA-Z0-9\-\_\/\.\:]+)$/", $url) &&
            stripos($url, 'javascript:') === false &&
            stripos($url, '<script>') === false &&
            strlen($url) <= 2048;
    }
}
