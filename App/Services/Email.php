<?php

namespace App\Services;

use App\Utilities\Lang;
use PHPMailer\PHPMailer\{Exception, PHPMailer};

/* Developed by Hero Expert
- Telegram channel: @HeroExpert_ir
- Author: Amirreza Ebrahimi
- Telegram Author: @a_m_b_r
*/
class Email
{
    private PHPMailer $mailer;      # PHPMailer instance
    private string $telegram;    # Telegram URL
    private string $github;      # GitHub URL
    private string $linkedin;    # LinkedIn URL

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
        $this->mailer->SMTPSecure = ($_ENV['EMAIL_SECURE'] == 'TLS') ? PHPMailer::ENCRYPTION_STARTTLS : PHPMailer::ENCRYPTION_SMTPS; # Use TLS/SSL
        $this->mailer->Port = (int)$_ENV['EMAIL_PORT']; # SMTP port
        $this->mailer->Host = $_ENV['EMAIL_HOST']; # SMTP server address
        $this->mailer->Username = $_ENV['EMAIL_USERNAME']; # SMTP username
        $this->mailer->Password = $_ENV['EMAIL_PASSWORD']; # SMTP password
        $this->mailer->From = filter_var($_ENV['EMAIL_USERNAME'], FILTER_VALIDATE_EMAIL) ?? 'info8@HeroExpert.ir'; # Sender's email
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
        } catch (Exception) {
            # Log the error or handle it as needed
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
                 <style>
                 * { direction: rtl; text-align: center; } body { overflow: hidden; display: flex; justify-content: center; align-items: center; } .div-container { max-width: 480px; background-color: #fff; width: 360px; margin: 3rem auto; border-top: 4px solid #713dea; border-bottom: 4px solid #713dea; border-radius: 1rem; } .header { text-align: center; } b { display: block; width: 50%; text-align: center; padding: 1rem; margin: 1rem auto; background-color: #713dea; font-size: 1.2rem; border-radius: .5rem; color: #fff; } .p-2 { color: #713dea; } .logo-a { direction: ltr; position: absolute !important; left: 15px; top: 15px; } .logo { width: 75px; height: 40px; } p { margin: 1rem 0; text-align: center; width: 100%; } .resetLogo { max-height: 180px; color: #333; } .p-5 { display: flex; text-align: center !important; padding: 0 100px; width: 100%; margin: 0; } .icon-link { margin: 16px 4px; display: inline; } .icon { margin: 0 8px; display: inline; width: 25px; height: 25px; max-height: 25px; max-width: 25px; } .icon-telegram { width: 31px; height: 31px; margin: 0 8px; display: inline; max-height: 35px; max-width: 35px; } 
                 </style>
            </head>
            <body>
                <div class='div-container'>
                    <div class='header'>
                        <p class='p-2'>" . Lang::get('emailTitle') . "</p>
                    </div>
                    <p>
                        <img class='resetLogo' src='" . assetUrl('img/icon/reset-image.png') . "'>
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
