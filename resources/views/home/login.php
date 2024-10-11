<?php use App\Utilities\Lang; ?>

<!DOCTYPE html>
<html lang="<?= Lang::get('lang') ?>" dir="<?= Lang::get('dir') ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= Lang::get('login-title') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet" />
    <link href="<?= Lang::get('font'); ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?= assetUrl(Lang::get('maincss')) ?>">
    <link rel="stylesheet" href="<?= assetUrl(Lang::get('resonsecss')) ?>">
</head>

<body>
    <main>
        <div class="email-div" id="email-div">
            <h2 class="email-header"><?= Lang::get('signin') ?></h2>
            <form action="/auth" method="post" class="email-form">
                <div class="email-val-div">
                    <i class="ri-error-warning-line email-valid-icon d-none"></i>
                    <input type="text" class="email-input" name="email" id="email-input" placeholder="<?= Lang::get('inputemail')?>" />
                    <p class="email-validation-text d-none"><?= Lang::get('pemail')?></p>
                    <span class="email-validation-span d-none"></span>
                </div>
                <button name="sub-email" class="email-submit-btn"><?= Lang::get('sendcode'); ?></button>
            </form>
        </div>
        <div class="bg-blur"></div>
    </main>

    <!--App script-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="<?=assetUrl('js/clipboard.min.js') ?>"></script>
    <script src="<?= assetUrl(Lang::get('indexjs')) ?>"></script>
</body>

</html> 
