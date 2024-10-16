<?php

namespace App\Services;

use App\Utilities\Lang;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Email
{
    private $mailer;
    private $telegram;
    private $github;
    private $linkedin;

    public function __construct()
    {
        $this->telegram = $_ENV['TELEGRAM'];
        $this->github = $_ENV['GITHUB'];
        $this->linkedin = $_ENV['LINKEDIN'];
        $this->mailer = new PHPMailer(true);
        $this->mailer->isSMTP();
        $this->mailer->SMTPDebug = 0;
        $this->mailer->SMTPAuth = true;
        $this->mailer->SMTPSecure = $_ENV['EMAIL_SECURE'];
        $this->mailer->Port = $_ENV['EMAIL_PORT'];
        $this->mailer->Host = $_ENV['EMAIL_HOST'];
        $this->mailer->Username = $_ENV['EMAIL_USERNAME'];
        $this->mailer->Password = $_ENV['EMAIL_PASSWORD'];
        $this->mailer->From = filter_var($_ENV['EMAIL_USERNAME'], FILTER_VALIDATE_EMAIL) ?? '';
        $this->mailer->FromName = "DO NOT REPLY";
    }

    public function send(string $to, string $OTP): bool
    {
        try {
            $this->mailer->addAddress($to);
            $this->mailer->isHTML(true);
            $this->mailer->Subject = "NewPassword";
            $this->mailer->Body = "<html> <head> <title>HTML email</title> <link rel='stylesheet' href='" . assetUrl(Lang::get('emailcss')) . "'> </head> <body> <div class='div-container'> <div class='header'> <p class='p-2'>" . Lang::get('emailTitle') . "</p> </div> <p> <img class='resetLogo' src='" . siteUrl('resources/assets/img/reset-image.png') . "'> </p> <p class='p2'>" . Lang::get('welcome') . "</p> <h3>" . Lang::get('emailMs') . "<b class='password'>$OTP</b></h3> <p class='p-5'> <a class='icon-link' href='" . $this->telegram . "'><img src='" . siteUrl('resources/assets/img/telegram-image.png') . "' class='icon-telegram'></a> <a class='icon-link' href='" . $this->github . "'><img src='" . siteUrl('resources/assets/img/github-image.png') . "' class='icon'></a> <a class='icon-link' href='" . $this->linkedin . "'><img src='" .  siteUrl('resources/assets/img/linkedin-image.png') . "' class='icon'></a> </p> </div> </body> </html>";
            $this->mailer->AltBody = "";
            $this->mailer->send();

            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
