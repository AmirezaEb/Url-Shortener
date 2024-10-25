<?php

namespace App\Services;

use App\Utilities\Lang;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Email
{
    private $mailer;      # PHPMailer instance
    private $telegram;    # Telegram URL
    private $github;      # GitHub URL
    private $linkedin;    # LinkedIn URL

    /**
     * Email constructor initializes the mailer with SMTP settings
     */
    public function __construct()
    {
        # Load social media links from environment variables
        $this->telegram = $_ENV['TELEGRAM'];
        $this->github = $_ENV['GITHUB'];
        $this->linkedin = $_ENV['LINKEDIN'];

        # Initialize PHPMailer and configure SMTP settings
        $this->mailer = new PHPMailer(true);
        $this->mailer->isSMTP();
        $this->mailer->SMTPDebug = 0; # Disable debug output
        $this->mailer->SMTPAuth = true; # Enable SMTP authentication
        $this->mailer->SMTPSecure = $_ENV['EMAIL_SECURE']; # Use TLS/SSL
        $this->mailer->Port = $_ENV['EMAIL_PORT']; # SMTP port
        $this->mailer->Host = $_ENV['EMAIL_HOST']; # SMTP server address
        $this->mailer->Username = $_ENV['EMAIL_USERNAME']; # SMTP username
        $this->mailer->Password = $_ENV['EMAIL_PASSWORD']; # SMTP password
        $this->mailer->From = filter_var($_ENV['EMAIL_USERNAME'], FILTER_VALIDATE_EMAIL) ?? ''; # Sender's email
        $this->mailer->FromName = "DO NOT REPLY"; # Sender's name
    }

    /**
     * Sends an email with the given OTP to the specified recipient
     *
     * @param string $to Recipient's email address
     * @param string $OTP One-Time Password to be included in the email
     * @return bool Returns true if the email is sent successfully, otherwise false
     */
    public function send(string $to, string $OTP): bool
    {
        try {
            # Add recipient
            $this->mailer->addAddress($to);

            # Set email format to HTML
            $this->mailer->isHTML(true);
            $this->mailer->Subject = "New Password"; // Email subject

            # Construct the HTML body of the email
            $this->mailer->Body = $this->buildEmailBody($OTP);
            $this->mailer->AltBody = ""; # Alternative body for non-HTML clients

            # Send the email
            $this->mailer->send();
            return true; # Email sent successfully
        } catch (Exception $e) {
            # Log the error or handle it as needed
            # echo 'Email could not be sent. Mailer Error: ' . $this->mailer->ErrorInfo; # Uncomment for debugging
            return false; # Email sending failed
        }
    }

    /**
     * Builds the HTML body for the email
     *
     * @param string $OTP The One-Time Password to include in the email
     * @return string The constructed HTML email body
     */
    private function buildEmailBody(string $OTP): string
    {
        return "<html>
            <head>
                <title>HTML Email</title>
                <link rel='stylesheet' href='" . assetUrl(Lang::get('emailcss')) . "'>
            </head>
            <body>
                <div class='div-container'>
                    <div class='header'>
                        <p class='p-2'>" . Lang::get('emailTitle') . "</p>
                    </div>
                    <p>
                        <img class='resetLogo' src='" . siteUrl('resources/assets/img/icon/reset-image.png') . "'>
                    </p>
                    <p class='p2'>" . Lang::get('welcome') . "</p>
                    <h3>" . Lang::get('emailMs') . "<b class='password'>$OTP</b></h3>
                    <p class='p-5'>
                        <a class='icon-link' href='" . $this->telegram . "'><img src='" . siteUrl('resources/assets/img/icon/telegram-image.png') . "' class='icon-telegram'></a>
                        <a class='icon-link' href='" . $this->github . "'><img src='" . siteUrl('resources/assets/img/icon/github-image.png') . "' class='icon'></a>
                        <a class='icon-link' href='" . $this->linkedin . "'><img src='" . siteUrl('resources/assets/img/icon/linkedin-image.png') . "' class='icon'></a>
                    </p>
                </div>
            </body>
        </html>";
    }
}
