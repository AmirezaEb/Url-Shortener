<?php

namespace App\Utilities;

class Url
{
    # Create A Short Url
    public static function shortCreate()
    {
        $length = rand(3, rand(5, 10));
        $characters = 'aA0bBcC1dDeE2fFgG3hHiI4jJkK5lLmM6nNoO7pPqQ8rRsS9tTuUvVwWxXyYzZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    # Redirect The User
    public static function redirect(string $Url) :void
    {
        if (!headers_sent()) {
            header("Location: $Url");
        } else {
            echo "<script type='text/javascript'>window.location.href='$Url'</script>";
            echo "<noscript><meta http-equiv='refresh' content='0;url=$Url'/></noscript>";
        }
        exit;
    }

    public static function getNow(): string
    {
        return (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    }
}
