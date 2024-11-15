<?php

namespace App\Controllers;

use App\Utilities\ExceptionHandler;
use chillerlan\QRCode\QROptions;
use chillerlan\QRCode\QRCode;
use App\Utilities\Auth;
use App\Utilities\Lang;
use App\Core\Request;
use App\Models\User;
use App\Models\View;
use App\Models\Url;
use Exception;

class HomeController
{
    /**
     * Display the homepage.
     *
     * @param Request $request The incoming HTTP request.
     * @return void Renders the home view.
     */
    public function index(Request $request): void
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
                throw new Exception(Lang::get('Er-Login'));
            }

            # Retrieve authenticated user
            $user = User::where('email', $userEmail)->first();

            # Validate the provided URL
            $url = $request->param('Url');
            if (!validateUrl($url)) {
                throw new Exception(Lang::get('Er-InvalidUrl'));
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
            if (!$savedUrl || !$qrCodePath) {
                throw new Exception(Lang::get('Er-TryAgain'));
            }

            # Prepare data for view
            $data = (object)['ShortUrl' => $shortUrlData->url];

            # Set success message and render the homepage
            ExceptionHandler::setMessage(Lang::get('Ms-Create'));
            view('home.index', $data);
        } catch (Exception $e) {
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
        } catch (Exception $e) {
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
     * @param string $text The URL text to encode in the QR code.
     * @param string $name The file name for the QR code image.
     * @return string|bool The URL of the QR code image on success, false on failure.
     */
    private function generateQrCode(string $text, string $name): string|bool
    {
        try {
            # Configure QR code generation options
            $options = new QROptions([
                'version' => 5,
                'outputType' => QRCode::OUTPUT_IMAGE_PNG,
                'eccLevel' => QRCode::ECC_L,
                'scale' => 10,
                'imageBase64' => false,
                'quietzoneSize' => 4,
                'addQuietzone' => true,
            ]);

            # Generate and save the QR code image
            $qrCode = new QRCode($options);
            $savePath = BASEPATH . 'public/QrCode/' . $name . '.png';
            file_put_contents($savePath, $qrCode->render($text));

            return $_ENV['APP_HOST'] . 'public/QrCode/' . $name . '.png';
        } catch (Exception $e) {
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
}
