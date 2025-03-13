<?php

/* Developed by Hero Expert
- Telegram channel: @HeroExpert_ir
- Author: Amirreza Ebrahimi
- Telegram Author: @a_m_b_r
*/

/**
 * Generate the full URL for the site.
 *
 * @param string $route Optional route to append to the base URL.
 * @return string Full URL.
 */
function siteUrl(string $route = ''): string
{
    return rtrim($_ENV['APP_HOST'], '/') . '/' . ltrim($route, '/');
}

/**
 * Generate the full URL for an asset file.
 *
 * @param string $file Name of the asset file.
 * @return string Full URL to the asset.
 */
function assetUrl(string $file): string
{
    # Construct the full path to the asset file
    return rtrim($_ENV['APP_HOST'], '/') . '/resources/assets/' . ltrim($file, '/');
}

/**
 * Include a view file and pass data to it.
 *
 * @param string $view The name of the view file.
 * @param array|object $data Optional data to extract into the view scope.
 * @return void
 * @throws \Exception
 */
function view(string $view, array|object $data = []): void
{
    if (is_array($data)) {
        extract($data); # Extract data to variables if it's an array
    }

    # Construct the view file path
    $viewPath = BASEPATH . 'resources/views/' . str_replace('.', '/', $view) . '.php';

    # Include the view file
    if (file_exists($viewPath)) {
        include $viewPath;
        exit;
    } else {
        throw new Exception("View file not found: $viewPath");
    }
}

/**
 * Generate a SweetAlert notification script.
 *
 * @param string $mode The type of alert (success, error, etc.).
 * @param string $message The message to display.
 * @param string $size The size of the alert.
 * @param string $position The position of the alert on the screen.
 * @return string The generated script.
 */
function alarm(string $mode, string $message, string $size, string $position): string
{
    # Generate SweetAlert script for notifications
    return "<script>
    Swal.fire({
        title: '$message',
        icon: '$mode',
        toast: true,
        width: '$size',
        position: '$position',
        showConfirmButton: false,
        timer: 3500,
        background: '#ffffff',
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;
        }
    })
    </script>";
}


/**
 * Generate a random short string.
 *
 * @return string A random string for shortening links.
 * @throws \Random\RandomException
 */
function shortCreate(): string
{
    $length = rand(3, 10); # Generate a random length between 3 and 10
    $characters = 'aA0bBcC1dDeE2fFgG3hHiI4jJkK5lLmM6nNoO7pPqQ8rRsS9tTuUvVwWxXyYzZ-';
    $charactersLength = strlen($characters);
    $randomString = '';

    # Build the random string
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[random_int(0, $charactersLength - 1)];
    }

    return $randomString; # Return the generated random string
}

/**
 * Redirect the user to a specified URL.
 *
 * @param string $url The URL to redirect to.
 * @return void
 */
function redirect(string $url): void
{
    if (!headers_sent()) {
        header("Location: $url");
    } else {
        # Fallback for when headers have already been sent
        echo "<script type='text/javascript'>window.location.href='$url'</script>";
        echo "<noscript><meta http-equiv='refresh' content='0;url=$url'/></noscript>";
    }
    exit; # Terminate the script after redirection
}

/**
 * Get the current full URL.
 *
 * @return string The current URL.
 */
function getNow(): string
{
    # Construct the full URL based on the request
    return (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
}

/**
 * Validate the email format and length.
 *
 * @param string $email The email to validate.
 * @return bool True if valid, false otherwise.
 */
function validateEmail(string $email): bool
{
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return false;
    }
    list($localPart, $domain) = explode('@', $email);
    return !(strlen($localPart) > 64 || strlen($domain) > 253);
}
