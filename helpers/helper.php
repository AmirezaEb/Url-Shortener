<?php

function siteUrl($route = ''): string
{
    return $_ENV['APP_HOST'] . $route;
}

function assetUrl(string $file): string
{
    $assetsPath = $_ENV['APP_HOST'] . "resources/assets/{$file}";
    return $assetsPath;
}

function view(string $view, array|object $data = []): void
{
    is_array($data) ? extract($data) : $data;
    $viewPath = BASEPATH . "resources/views/" . str_replace('.', '/', $view) . ".php";
    include $viewPath;
}

function alarm(string $mode, string $message, string $size, string $position): string
{
    $alarm = "<script>
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
    return $alarm;
}
