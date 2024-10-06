<?php

function siteUrl($route = '')
{
    return $_ENV['HOST'] . $route;
}

# Loading CSS And JS Files
function assetUrl(string $file): string
{
    $assetsPath = $_ENV['HOST'] . "/resources/assets/{$file}";
    return $assetsPath;
}

# Display Pages
function view(string $view, array $data = []): void
{
    $viewPath = BASEPATH . "/resources/views/" . str_replace('.', '/', $view) . ".php";

    if (!file_exists($viewPath)) {
        include BASEPATH . "/resources/views/errors/404.php";
    } else {
        include $viewPath;
    }
}
