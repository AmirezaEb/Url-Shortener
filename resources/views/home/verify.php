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

    <!-- SweetAlert2 for alert messages -->
    <script src="<?= assetUrl('js/sweetalert2@11.js') ?>"></script>

    <!-- Remixicon for icons -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet" />

    <!-- Dynamic font loading based on selected language -->
    <link href="<?= Lang::get('font') ?>" rel="stylesheet">

    <!-- Main and responsive CSS -->
    <link rel="stylesheet" href="<?= assetUrl(Lang::get('maincss')) ?>">
    <link rel="stylesheet" href="<?= assetUrl(Lang::get('resonsecss')) ?>">
</head>

<body>
    <main>

        <!-- Verification form container -->
        <div class="verify-div" id="verify-div">
            <h2 class="verify-header"><?= Lang::get('verify') ?></h2>

            <!-- Verification form -->
            <form action="/auth" method="post" class="verify-form">
                <div class="verify-val-div">
                    <!-- Error icon for validation (hidden by default) -->
                    <i class="ri-error-warning-line verify-valid-icon d-none"></i>

                    <!-- Verification code input -->
                    <input type="text" class="verify-input" name="verifyCode" id="verify-input" placeholder="<?= Lang::get('inputverify') ?>" />

                    <!-- Validation message (hidden by default) -->
                    <p class="verify-validation-text d-none"><?= Lang::get('pverify') ?></p>
                    <span class="verify-validation-span d-none"></span>
                </div>

                <!-- Submit button for verification -->
                <button name="action" value="register" class="verify-submit-btn"><?= Lang::get('sub') ?></button>
            </form>
        </div>

        <!-- Background blur effect -->
        <div class="bg-blur"></div>
    </main>

    <!-- Bootstrap JavaScript for interactive components -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

    <!-- Clipboard.js for copy-to-clipboard functionality (if needed) -->
    <script src="<?= assetUrl('js/clipboard.min.js') ?>"></script>

    <!-- Custom JavaScript specific to this page -->
    <script src="<?= assetUrl(Lang::get('indexjs')) ?>"></script>
</body>

</html>

<?php
# Handle session-based error or success messages using SweetAlert
if (Session::has('error') && !Session::empty('error')) {
    # Show error message using a custom alarm function
    echo alarm('error', Session::get('error'), '22em', Lang::get('position-alarm'));
    Session::delete('error'); # Clear error from session after displaying
} elseif (Session::has('message') && !Session::empty('message')) {
    # Show success message using a custom alarm function
    echo alarm('success', Session::get('message'), '22em', Lang::get('position-alarm'));
    Session::delete('message'); # Clear success from session after displaying
}
?>