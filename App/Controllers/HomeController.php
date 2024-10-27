<?php

namespace App\Controllers;

use App\Core\Request;
use App\Models\Url;
use App\Models\User;
use App\Utilities\Auth;
use App\Utilities\ExceptionHandler;
use App\Utilities\Lang;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use Exception;

class HomeController
{
    /**
     * Show the homepage.
     *
     * @param Request $request The incoming HTTP request.
     * @return void Renders the home view.
     */
    public function index(Request $request)
    {
        view('home.index');
    }

    /**
     * Handle URL creation with optional QR code generation.
     *
     * @param Request $request The HTTP request containing user input data.
     * @return void Renders the home view or redirects upon error.
     */
    public function createUrl(Request $request)
    {
        if ($request->method() === 'post' && $request->has('sub-create') && $request->param('Url')) {
            try {
                # Check if the user is authenticated.
                $cookie = Auth::checkLogin();
                if (!$cookie) {
                    throw new Exception(Lang::get('Er-Login'));
                }

                # Retrieve authenticated user details.
                $user = User::where('email', $cookie)->first();

                # Validate the provided URL.
                $url = $request->param('Url');
                if (!validateUrl($url)) {
                    throw new Exception(Lang::get('Er-InvalidUrl'));
                }

                # Generate a unique short URL.
                $shortUrlData = $this->generateShortUrl();

                # create Qr Code url
                $createQrCode = $this->generateQrCode($shortUrlData->url, $shortUrlData->name);

                # Save URL and QR code information to the database.
                $saveUrl = Url::create([
                    'created_by' => $user->id,
                    'url' => htmlspecialchars($url, ENT_QUOTES, 'UTF-8'),
                    'shortUrl' => $shortUrlData->name,
                    'qrCode' => $createQrCode,
                ]);

                if (!$saveUrl || !$createQrCode) {
                    throw new Exception(Lang::get('Er-TryAgain'));
                }

                # Data to be displayed in the view.
                $data = (object)[
                    'ShortUrl' => $shortUrlData->url,
                ];

                # Set success message and display the home view with data.
                ExceptionHandler::setMessage(Lang::get('Ms-Create'));
                return view('home.index', $data);
            } catch (Exception $e) {
                # Handle any exceptions and redirect to the homepage with an error.
                ExceptionHandler::setErrorAndRedirect($e->getMessage(), './');
            }
        } else {
            # Display the home view if the request method is not POST.
            view('home.index');
        }
    }

    /**
     * Redirect the user based on a shortened URL.
     *
     * @param Request $request The request containing the shortened URL parameter.
     * @return void Handles the redirect.
     */
    public function redirectUrl(Request $request)
    {
        # Placeholder function for URL redirection logic.
        var_dump($request);
    }

    /**
     * Generate a unique shortened URL.
     *
     * @return object An object containing the shortened URL and its name.
     */
    private function generateShortUrl(): object
    {
        do {
            # Generate a potential short URL.
            $shortUrl = shortCreate();

            # Check if the short URL already exists in the database.
            $exists = Url::where('shortUrl', $_ENV['APP_HOST'] . $shortUrl)->exists();
        } while ($exists);

        # Return the unique short URL and its name.
        return (object)[
            'url' => $_ENV['APP_HOST'] . $shortUrl,
            'name' => $shortUrl
        ];
    }

    /**
     * Generate a QR code image file for a given URL.
     *
     * @param string $text The URL text to encode in the QR code.
     * @param string $name The file name for the saved QR code image.
     * @return string|bool The path to the QR code image on success, false on failure.
     */
    private function generateQrCode(string $text, string $name): string|bool
    {
        try {
            # Set up QR code generation options.
            $options = new QROptions([
                'version' => 5,
                'outputType' => QRCode::OUTPUT_IMAGE_PNG,
                'eccLevel' => QRCode::ECC_L,
                'scale' => 10,
                'imageBase64' => false,
                'quietzoneSize' => 4,
                'addQuietzone' => true,
            ]);

            # Generate and save the QR code image.
            $qrCode = new QRCode($options);
            $savePath = BASEPATH . 'public/QrCode/' . $name . '.png';
            file_put_contents($savePath, $qrCode->render($text));

            return $_ENV['APP_HOST'] . 'public/QrCode/' . $name . '.png';
        } catch (Exception $e) {
            # Return false if QR code generation fails.
            return false;
        }
    }
}
