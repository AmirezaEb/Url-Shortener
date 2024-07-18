<?php

@include '../config/config.php';
@include 'helper.php';

/* 
Developed by Hero Expert
Telegram channel : @HeroExpert_ir
*/

if (isset($_POST['submits'])) {
    $Url = htmlspecialchars($_POST['Url']);
    $shortUrl = URL . "?url=" . shortUrlCreate();
    $receiveShortUrlCount = receiveShortUrlCount($shortUrl);
    $receiveUrlCount = receiveUrlCount($Url);
    if ($receiveShorUrlCount == 1) {
        $shortUrl = URL . "?url=" . shortUrlCreate();
    }
    if ($receiveUrlCount == 1) {
        $receiveUrl = receiveUrl($Url);
        redirect('../' . substr($receiveUrl, strlen(URL), strlen($receiveUrl)) . '&message=success');
    } else {
        saveUrl($Url, $shortUrl);
        redirect('../' . substr($shortUrl, strlen(URL), strlen($shortUrl)) . '&message=success');
    }
}
?>