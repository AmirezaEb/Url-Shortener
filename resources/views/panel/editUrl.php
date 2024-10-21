<?php use App\Utilities\Lang; use App\Utilities\Session; ?>

<!DOCTYPE html>
<html lang="<?= Lang::get('lang'); ?>" dir="<?= Lang::get('dir') ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= Lang::get('edit-title') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet" />
    <link href="<?= Lang::get('font') ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?= assetUrl(Lang::get('maincss')) ?>">
    <link rel="stylesheet" href="<?= assetUrl(Lang::get('resonsecss')) ?>">
    <script src="<?= assetUrl('js/sweetalert2@11.js') ?>"></script>
</head>

<body>
    <main>
        <div class="editDest-div" id="editDest-div">
            <h2 class="editDest-header"><?= Lang::get('edit-h2') ?></h2>
            <form action="./<?= $data->url->id ?>" method="post" class="editDest-form">
                <input type="text" class="editDest-input" name="editURL" value="<?= $data->url->url ?>" id="editDest-input" placeholder="<?= Lang::get('edit-input') ?>" />
                <button class="editDest-submit-btn"><?= Lang::get('sub') ?></button>
            </form>
        </div>

        <div class="bg-blur"></div>
    </main>
    <script src="<?= assetUrl('js/clipboard.min.js') ?>"></script>
    <script src="<?= assetUrl(Lang::get('indexjs')) ?>"></script>
</body>

</html>

<?php
if (Session::has('error') && !Session::empty('error')) {
    echo alarm('error', Session::get('error'), '22em', Lang::get('position-alarm'));
    Session::delete('error');
} elseif (Session::has('message') && !Session::empty('message')) {
    echo alarm('success', Session::get('message'), '22em', Lang::get('position-alarm'));
    Session::delete('message');
}
?>