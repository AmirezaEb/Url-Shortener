<?php use App\Utilities\Lang; ?>

<!DOCTYPE html>
<html lang="<?= Lang::get('lang') ?>" dir="<?= Lang::get('dir') ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= assetUrl(Lang::get('GDLibrary')) ?>">
    <title><?= Lang::get('GD-title') ?></title>
</head>

<body>
    <div class="container">
        <h1><?= Lang::get('GD-h1') ?></h1>
        <p><?= Lang::get('GD-p1') ?></p>
        <p><?= Lang::get('GD-p2') ?></p>
        <a href="https://www.php.net/manual/en/book.image.php" class="button" target="_blank"><?=Lang::get('GD-a')?></a>
    </div>
</body>

</html>