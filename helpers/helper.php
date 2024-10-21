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

function generateQrCode(string $text, string $name): bool
{
    $options = new chillerlan\QRCode\QROptions([
        'version' => 5,
        'outputType' => chillerlan\QRCode\QRCode::OUTPUT_IMAGE_PNG,
        'eccLevel' => chillerlan\QRCode\QRCode::ECC_L,
        'scale' => 10,
        'imageBase64' => false,
        'quietzoneSiza' => 4,
        'addQuietzone' => true,
    ]);

    $qrCode = new chillerlan\QRCode\QRCode($options);
    $saveQr = file_put_contents(BASEPATH . 'public/QrCode/' . $name . '.png', $qrCode->render($text));

    if (!$saveQr) {
        return false;
    }
    return true;
}
