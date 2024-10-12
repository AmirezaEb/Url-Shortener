<?php

function siteUrl($route = '') : string
{
    return $_ENV['HOST'] . $route;
}

# Loading CSS And JS Files
function assetUrl(string $file): string
{
    $assetsPath = $_ENV['HOST'] . "resources/assets/{$file}";
    return $assetsPath;
}

# Display Pages
function view(string $view, array $data = []): void
{
    extract($data);
    $viewPath = BASEPATH . "resources/views/" . str_replace('.', '/', $view) . ".php";
    include $viewPath;
}
