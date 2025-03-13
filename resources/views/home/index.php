<?php
use App\Utilities\Auth;
use App\Utilities\Lang;
use App\Utilities\Session; 
?>

<!DOCTYPE html>
<html lang="<?= Lang::get('lang') ?>" dir="<?= Lang::get('dir') ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= Lang::get('index-title') ?></title>
    
    <!-- SweetAlert2 for alerts -->
    <script src="<?= assetUrl('js/sweetalert2@11.js') ?>"></script>
    
    <!-- RemixIcon CDN for icons -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet" />
    
    <!-- Dynamic font loading based on the language -->
    <link href="<?= Lang::get('font') ?>" rel="stylesheet">
    
    <!-- Main and responsive CSS -->
    <link rel="stylesheet" href="<?= assetUrl(Lang::get('maincss')) ?>">
    <link rel="stylesheet" href="<?= assetUrl(Lang::get('resonsecss')) ?>">
</head>

<body>
    <header>
        <div class="user-panel">
            <!-- Link to the user panel -->
            <a href="./auth" class="user-panel-btn"><?= (Auth::checkLogin()) ? Lang::get('panel') : Lang::get('login-title') ?></a>
        </div>
    </header>

    <main>
        <div id="header-div">
            <h1><?= Lang::get('index-title') ?></h1>
        </div>
        <!-- URL input form for shortening URLs -->
        <div id="content-div">
            <form id="input-div" action="./" method="post">
                <i class="ri-error-warning-line verify-valid-icon-Url d-none"></i>
                <!-- URL Input Field -->
                <input type="url" name="Url" class="input-field" placeholder="<?= Lang::get('yourlink') ?> . . ." id="input-field" />
                <!-- Validation message (hidden by default) -->
                <p class="verify-validation-text-Url d-none"><?= Lang::get('pedit') ?></p>
                <span class="verify-validation-span-Url d-none"></span>
                <div class="buttons">
                    <!-- Shorten URL button -->
                    <button type="submit" name="sub-create" class="content-row button shortenURL sub-create"><?= Lang::get('short') ?></button
                    <!-- Clear input field button -->
                    <button type="button" id="clear-btn" class="content-row button"><?= Lang::get('clear') ?></button>
                </div>
            </form>

            <!-- Output section for displaying the shortened URL -->
            <div id="output-div">
                <div class="content-row" id="new-url-label"><?= Lang::get('yourshort') ?> : </div>
                <div id="new-url" class="content-row">
                    <a href="<?= htmlspecialchars($data->ShortUrl ?? '') ?>"><?= htmlspecialchars($data->ShortUrl ?? '')?></a>
                </div>

                <!-- Copy button for the shortened URL -->
                <button type="button" id="copy-btn" data-clipboard-target="#new-url" class="content-row button">
                    <span class="copy-text"><?= Lang::get('copy') ?></span>
                    <i class="ri-file-copy-line copy-icon"></i>
                </button>
            </div>
        </div>
        
        <div class="bg-opacity"></div>
    </main>
</body>

<!-- App scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="<?= assetUrl('js/clipboard.min.js') ?>"></script>
<script type="module" src="<?= assetUrl(Lang::get('appjs')) ?>"></script>
<script src="<?= assetUrl(Lang::get('indexjs')) ?>"></script>

</html>

<?php

# Display an error or success message using SweetAlert if session data exists
if (Session::has('error') && !Session::empty('error')) {
    echo alarm('error', Session::get('error'), '22em', Lang::get('position-alarm'));
    Session::delete('error');
} elseif (Session::has('message') && !Session::empty('message')) {
    echo alarm('success', Session::get('message'), '22em', Lang::get('position-alarm'));
    Session::delete('message');
}
?>