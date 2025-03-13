<?php
use App\Utilities\Lang;
use App\Utilities\Session;
?>

<!DOCTYPE html>
<html lang="<?= Lang::get('lang') ?>" dir="<?= Lang::get('dir') ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= Lang::get('login-title') ?></title>

    <!-- Remixicon for icons -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet" />

    <!-- SweetAlert2 for alert messages -->
    <script src="<?= assetUrl('js/sweetalert2@11.js') ?>"></script>

    <!-- Load dynamic font based on the selected language -->
    <link href="<?= Lang::get('font'); ?>" rel="stylesheet">

    <!-- Main and responsive CSS -->
    <link rel="stylesheet" href="<?= assetUrl(Lang::get('maincss')) ?>">
    <link rel="stylesheet" href="<?= assetUrl(Lang::get('resonsecss')) ?>">
</head>

<body>
    <main>
        <!-- Login form container -->
        <div class="email-div" id="email-div">
            <h2 class="email-header"><?= Lang::get('signin') ?></h2>

            <!-- Login form -->
            <form action="/auth" method="post" class="email-form">
                <div class="email-val-div">
                    <!-- Error icon for email validation (hidden by default) -->
                    <i class="ri-error-warning-line email-valid-icon d-none"></i>

                    <!-- Email input field -->
                    <input type="text" class="email-input" name="email" id="email-input" placeholder="<?= Lang::get('inputemail') ?>" />

                    <!-- Validation message (hidden by default) -->
                    <p class="email-validation-text d-none"><?= Lang::get('pemail') ?></p>
                    <span class="email-validation-span d-none"></span>
                </div>

                <!-- Submit button -->
                <button name="action" class="email-submit-btn" value="login"><?= Lang::get('sendcode') ?></button>
            </form>
        </div>

        <!-- Background blur effect -->
        <div class="bg-blur"></div>
    </main>

    <!-- Bootstrap JavaScript for interactive components -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <!-- Clipboard.js for copy-to-clipboard functionality -->
    <script src="<?= assetUrl('js/clipboard.min.js') ?>"></script>

    <!-- Custom JavaScript specific to the login page -->
    <script src="<?= assetUrl(Lang::get('indexjs')) ?>"></script>
</body>

</html>

<?php
# Handle and display session-based error or success messages using SweetAlert
if (Session::has('error') && !Session::empty('error')) {
    # Show error message using alarm() function
    echo alarm('error', Session::get('error'), '22em', Lang::get('position-alarm'));
    Session::delete('error'); # Clear the error message from session after displaying
} elseif (Session::has('message') && !Session::empty('message')) {
    # Show success message using alarm() function
    echo alarm('success', Session::get('message'), '22em', Lang::get('position-alarm'));
    Session::delete('message'); # Clear the success message from session after displaying
}
?>