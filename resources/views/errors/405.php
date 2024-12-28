<?php

use App\Utilities\Lang;
?>
<!DOCTYPE html>
<html lang="<?= Lang::get('lang') ?>" dir="<?= Lang::get('dir') ?>">

<head>
  <meta charset="UTF-8">
  <title>405 Method Not Allowed</title>
  <link rel="stylesheet" href="<?= assetUrl(Lang::get('maincss')) ?>">
  <link rel="stylesheet" href="<?= assetUrl(Lang::get('resonsecss')) ?>">
</head>

<body>

  <main>
    <div class="NotPageContainer">
      <div>
        <div class="notTitle">
          <h2 class="num-style">4</h2>

          <!-- cog of zero -->
          <div class="cog-wheel">
            <div class="cog">
              <div class="top"></div>
              <div class="down"></div>
              <div class="left-top"></div>
              <div class="left-down"></div>
              <div class="right-top"></div>
              <div class="right-down"></div>
              <div class="left"></div>
              <div class="right"></div>
            </div>
          </div>
          <h2 class="num-style">5</h2>
        </div>

        <div class="notPageDetails">
          <h2 class="notPageDetails__error"><?= Lang::get('header405') ?></h2>
          <p class="notPageDetails__desc"><?= Lang::get('desc405ErrorBody') ?></p>
          <p class="notPageDetails__desc"><?= Lang::get('footer405ErrorBody') ?></p>
        </div>

        <div class="notPageButtonDiv">
          <a href="<?= $_ENV['APP_HOST'] ?>" class="notPageButton button"><?= Lang::get('errors-button') ?></a>
        </div>
      </div>
    </div>
    <div class="bg-blur"></div>
  </main>

  <script src="<?= assetUrl('js/gsap.min.js') ?>"></script>
  <script src="<?= assetUrl(Lang::get('indexjs')) ?>"></script>
</body>

</html>