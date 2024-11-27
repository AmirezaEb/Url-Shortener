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
     * @return void
     */
    public function index(Request $request): void
    {
        # Render the home view
        view('home.index');
    }

    /**
     * Handle URL creation and optional QR code generation.
     *
     * @param Request $request The HTTP request containing user input data.
     * @return void
     */
    public function createUrl(Request $request): void
    {
        try {
            # Validate the incoming request
            $this->validateCreateUrlRequest($request);

            # Get the authenticated user
            $user = $this->getAuthenticatedUser();

            # Validate and sanitize the provided URL
            $url = $this->validateAndSanitizeUrl($request->param('Url'));

            # Generate a unique short URL
            $shortUrlData = $this->generateShortUrl();

            # Generate a QR code for the short URL
            $qrCodePath = $this->generateQrCode($shortUrlData->url, $shortUrlData->name);

            # Save the URL data in the database
            $this->saveUrl($user, $url, $shortUrlData, $qrCodePath);

            # Set success message and render the homepage
            ExceptionHandler::setMessage(Lang::get('Ms-Create'));
            view('home.index', (object)['ShortUrl' => $shortUrlData->url]);
        } catch (Exception $e) {
            # Handle exceptions and redirect with an error message
            ExceptionHandler::setErrorAndRedirect($e->getMessage(), './');
        }
    }

    /**
     * Redirect the user based on the shortened URL.
     *
     * @param Request $request The request containing the shortened URL parameter.
     * @return void
     */
    public function redirectUrl(Request $request): void
    {
        try {
            # Retrieve the short URL from the request
            $shortUrl = $request->param('short_url');

            # Find the original URL in the database
            $url = Url::where('shortUrl', $shortUrl)->firstOrFail();

            # Track the unique view for analytics
            $this->trackView($url, $request);

            # Redirect to the original URL
            redirect($url->url);
        } catch (Exception $e) {
            # Redirect to the homepage on error
            redirect('./');
        }
    }

    /**
     * Validate the URL creation request.
     *
     * @param Request $request The HTTP request.
     * @return void
     * @throws Exception If validation fails.
     */
    private function validateCreateUrlRequest(Request $request): void
    {
        # Ensure the request is POST with required parameters
        if ($request->method() !== 'post' || !$request->has('sub-create') || !$request->param('Url')) {
            view('home.index');
            exit;
        }

        # Verify user authentication
        if (!Auth::checkLogin()) {
            throw new Exception(Lang::get('Er-Login'));
        }
    }

    /**
     * Get the authenticated user from the session.
     *
     * @return User The authenticated user.
     * @throws Exception If user is not authenticated.
     */
    private function getAuthenticatedUser(): User
    {
        # Retrieve user email from authentication
        $userEmail = Auth::checkLogin();

        # Find the user by email in the database
        return User::where('email', $userEmail)->firstOrFail();
    }

    /**
     * Validate and sanitize the provided URL.
     *
     * @param string $url The URL to validate.
     * @return string The sanitized URL.
     * @throws Exception If the URL is invalid.
     */
    private function validateAndSanitizeUrl(string $url): string
    {
        # Check if the URL is valid
        if (!validateUrl($url)) {
            throw new Exception(Lang::get('Er-InvalidUrl'));
        }

        # Sanitize the URL to prevent XSS
        return htmlspecialchars($url, ENT_QUOTES, 'UTF-8');
    }

    /**
     * Save the generated URL details to the database.
     *
     * @param User $user The authenticated user.
     * @param string $url The original URL.
     * @param object $shortUrlData The short URL data.
     * @param string $qrCodePath The path to the generated QR code.
     * @return void
     * @throws Exception If saving fails.
     */
    private function saveUrl(User $user, string $url, object $shortUrlData, string $qrCodePath): void
    {
        # Save the URL data in the database
        $savedUrl = Url::create([
            'created_by' => $user->id,
            'url' => $url,
            'shortUrl' => $shortUrlData->name,
            'qrCode' => $qrCodePath,
        ]);

        # Check if saving was successful
        if (!$savedUrl || !$qrCodePath) {
            throw new Exception(Lang::get('Er-TryAgain'));
        }
    }

    /**
     * Generate a unique shortened URL.
     *
     * @return object An object containing the short URL and its identifier.
     */
    private function generateShortUrl(): object
    {
        do {
            # Generate a unique short identifier
            $shortUrlName = shortCreate();
        } while (Url::where('shortUrl', $shortUrlName)->exists());

        # Return the generated short URL and its identifier
        return (object)[
            'url' => $_ENV['APP_HOST'] . $shortUrlName,
            'name' => $shortUrlName,
        ];
    }

    /**
     * Generate a QR code for the given URL.
     *
     * @param string $text The text to encode in the QR code.
     * @param string $name The file name for the QR code.
     * @return string The path to the generated QR code.
     */
    private function generateQrCode(string $text, string $name): string
    {
        # Configure QR code options
        $options = new QROptions([
            'version' => 5,
            'outputType' => QRCode::OUTPUT_IMAGE_PNG,
            'eccLevel' => QRCode::ECC_L,
            'scale' => 10,
            'quietzoneSize' => 4,
        ]);

        # Generate and save the QR code
        $qrCode = new QRCode($options);
        $savePath = BASEPATH . 'public/QrCode/' . $name . '.png';

        file_put_contents($savePath, $qrCode->render($text));
        return $_ENV['APP_HOST'] . 'public/QrCode/' . $name . '.png';
    }

    /**
     * Track unique views for a given URL.
     *
     * @param Url $url The URL model.
     * @param Request $request The HTTP request.
     * @return void
     */
    private function trackView(Url $url, Request $request): void
    {
        # Get client IP and User Agent
        $ipAddress = $request->ip();
        $userAgent = $request->agent();

        # Check if the view is unique
        if (!View::where('url_id', $url->id)
            ->where('ip_address', $ipAddress)
            ->where('user_agent', $userAgent)
            ->exists()) {

            # Log the unique view
            View::create([
                'url_id' => $url->id,
                'ip_address' => $ipAddress,
                'user_agent' => $userAgent,
            ]);

            # Increment view count for the URL
            $url->increment('views');
        }
    }
}
