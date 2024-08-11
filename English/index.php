<?php

@include 'config/config.php';
@include 'controller/helper.php';

$shortUrl = '';
$type = true;

if (isset($_GET['url'])) {
    $shortUrl = URL . '?url=' . $_GET['url'];
    if (!isset($_GET['message'])) {
        $type = false;
        $redirectUrl = receiveShortUrl($shortUrl);
        if ($redirectUrl == false) {
            $type = true;
            redirect(URL . "?message=NotFound");
        }
    }
}
if ($type == false) {
    redirect($redirectUrl);
} else {
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Url Shortener</title>
        <script src="assets/js/sweetalert2@11.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet" />
        <link href="https://fonts.cdnfonts.com/css/going-to-school" rel="stylesheet">
        <link rel="stylesheet" href="assets/css/main.css">
        <link rel="stylesheet" href="assets/css/responsive.css">
    </head>

    <!-- 
    Developed by Hero Expert 
    Telegram channel : @HeroExpert_ir 
    -->

    <body>
        <header>
            <div class="user-panel">
                <a href="login.html" class="user-panel-btn">user panel</a>
            </div>
        </header>
        <main>
            <!-- Error Handler -->
            <?php if (isset($_GET['message']) && $_GET['message'] == 'success') {
                echo alarm('success', 'Your Short Url Has Been SuccessFully Created');
            }
            if (isset($_GET['message']) && $_GET['message'] == 'NotFound') {
                echo alarm('error', 'Not Found This Page!');
            } ?>


            <div id="header-div" class="">
                <h1>Url Shortener</h1>
            </div>
            <!-- Url input and shorten button -->
            <div id="content-div">
                <form id="input-div" action="controller/createUrl.php" method="post">
                    <input type="url" name="Url" class="content-row" placeholder="Enter Url Here . . ." id="input-field" required />
                    <div class="buttons">
                        <button type="submit" name="submits" class="content-row button shortenURL">Shorten Url</button>
                        <button type="button" id="clear-btn" class="content-row button">Clear</button>
                    </div>
                </form>
                <!-- Output and copy -->
                <div id="output-div">
                    <div class="content-row" id="new-url-label">Your Short Url: </div>
                    <div id="new-url" class="content-row"> <a href="<?= $shortUrl ?>"><?= $shortUrl ?></a> </div>
                    <button type="button" id="copy-btn" data-clipboard-target="#new-url" class="content-row button">
                        <span class="copy-text">Copy</span>
                        <i class="ri-file-copy-line copy-icon"></i>
                    </button>
                </div>
            </div>
            <div class="bg-opacity"></div>
        </main>
    </body>
<?php } ?>
<!--App script-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script type="module" src="assets/js/app.js"></script>


    </html>