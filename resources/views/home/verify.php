<?php
use App\Utilities\Lang;
use App\Utilities\Session;
?>

<!DOCTYPE html>
<html lang="<?= Lang::get('lang') ?>" dir="<?= Lang::get('dir') ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= Lang::get('verify-title') ?></title>
    <script src="<?= assetUrl('js/sweetalert2@11.js') ?>"></script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet" />
    <link href="<?= Lang::get('font') ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?= assetUrl(Lang::get('maincss')) ?>">
    <link rel="stylesheet" href="<?= assetUrl(Lang::get('resonsecss')) ?>">
</head>

<body>
    <main>

        <div class="verify-div" id="verify-div">
            <h2 class="verify-header"><?= Lang::get('verify') ?></h2>
            <form action="/auth" method="post" class="verify-form">
                <div class="verify-val-div">
                    <i class="ri-error-warning-line verify-valid-icon d-none"></i>
                    <input type="text" class="verify-input" name="verifyCode" id="verify-input" placeholder="<?= Lang::get('inputverify') ?>" />
                    <p class="verify-validation-text d-none"><?= Lang::get('pverify') ?></p>
                    <span class="verify-validation-span d-none"></span>
                </div>
                <button name="action" value="register" class="verify-submit-btn"><?= Lang::get('sub') ?></button>
            </form>
        </div>

        <div class="bg-blur"></div>
    </main>

    <!--App script-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="<?= assetUrl('js/clipboard.min.js') ?>"></script>
    <script src="<?= assetUrl(Lang::get('indexjs')) ?>"></script>
</body>

</html>
<?php
if (Session::has('error') && !Session::empty('error')) {
    echo alarm('error', Session::get('error'), '22em',Lang::get('position-alarm'));
    Session::delete('error');
} elseif (Session::has('message') && !Session::empty('message')) {
    echo alarm('success', Session::get('message'), '22em', Lang::get('position-alarm'));
    Session::delete('message');
}
?>