<?php use App\Utilities\Lang; ?>
<!DOCTYPE html>
<html lang="<?= Lang::get('lang') ?>" dir="<?= Lang::get('dir') ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= Lang::get('index-title') ?></title>
    <script src="<?= assetUrl('js/sweetalert2@11.js') ?>"></script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet" />
    <link href="<?= Lang::get('font'); ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?= assetUrl(Lang::get('maincss')) ?>">
    <link rel="stylesheet" href="<?= assetUrl(Lang::get('resonsecss')) ?>">
</head>

    <!-- 
    Developed by Hero Expert 
    Telegram channel : @HeroExpert_ir 
    -->

<body>
    <header>
        <div class="user-panel">
            <a href="./auth" class="user-panel-btn"><?= Lang::get('panel') ?></a>
        </div>
    </header>
    <main>
        <div id="header-div" class="">
            <h1><?= Lang::get('index-title') ?></h1>
        </div>
        <!-- Url input and shorten button -->
        <div id="content-div">
            <form id="input-div" action="/" method="post">
                <input type="url" name="Url" class="content-row" placeholder="<?= Lang::get('yourlink') ?> . . ." id="input-field" required />
                <div class="buttons">
                    <button type="submit" name="sub-create" class="content-row button shortenURL"><?= Lang::get('short') ?></button>
                    <button type="button" id="clear-btn" class="content-row button"><?= Lang::get('clear') ?></button>
                </div>
            </form>
            <!-- Output and copy -->
            <div id="output-div">
                <div class="content-row" id="new-url-label"><?= Lang::get('yourshort') ?> : </div>
                <div id="new-url" class="content-row"> <a href="<?= $data[0] ?>"><?= $data[0] ?? '' ?></a> </div>
                <button type="button" id="copy-btn" data-clipboard-target="#new-url" class="content-row button">
                    <span class="copy-text"><?= Lang::get('copy') ?></span>
                    <i class="ri-file-copy-line copy-icon"></i>
                </button>
            </div>
        </div>
        <div class="bg-opacity"></div>
    </main>
</body>
<!--App script-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script type="module" src="<?= assetUrl(Lang::get('appjs')) ?>"></script>


</html>