<?php 
use App\Utilities\Lang; 
use App\Utilities\Session; 
?>

<!DOCTYPE html>
<html lang="<?= Lang::get('lang'); ?>" dir="<?= Lang::get('dir') ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= Lang::get('edit-title') ?></title>

    <!-- Remixicon for icons -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet" />

    <!-- Dynamic font based on language settings -->
    <link href="<?= Lang::get('font') ?>" rel="stylesheet">

    <!-- Main and responsive CSS -->
    <link rel="stylesheet" href="<?= assetUrl(Lang::get('maincss')) ?>">
    <link rel="stylesheet" href="<?= assetUrl(Lang::get('resonsecss')) ?>">

    <!-- SweetAlert2 for handling alert messages -->
    <script src="<?= assetUrl('js/sweetalert2@11.js') ?>"></script>
</head>

<body>
    <main>
        <!-- URL Edit Form Container -->
        <div class="editDest-div" id="editDest-div">
            <h2 class="editDest-header"><?= Lang::get('edit-h2') ?></h2>
            
            <!-- Edit URL Form -->
            <form action="./<?= $data->url->id ?>" method="post" class="editDest-form">
                <!-- URL Input Field -->
                <input type="text" class="editDest-input" name="editURL" 
                       value="<?= htmlspecialchars($data->url->url, ENT_QUOTES, 'UTF-8') ?>" 
                       id="editDest-input" placeholder="<?= Lang::get('edit-input') ?>" />
                
                <!-- Submit Button -->
                <button class="editDest-submit-btn"><?= Lang::get('sub') ?></button>
            </form>
        </div>

        <!-- Background Blur Effect -->
        <div class="bg-blur"></div>
    </main>

    <!-- Clipboard.js for copy functionality -->
    <script src="<?= assetUrl('js/clipboard.min.js') ?>"></script>

    <!-- Custom page JavaScript -->
    <script src="<?= assetUrl(Lang::get('indexjs')) ?>"></script>
</body>

</html>

<?php
# Display session-based alert messages
if (Session::has('error') && !Session::empty('error')) {
    # Display error alert if an error message exists in the session
    echo alarm('error', Session::get('error'), '22em', Lang::get('position-alarm'));
    Session::delete('error'); // Clear the error message from session
} elseif (Session::has('message') && !Session::empty('message')) {
    # Display success alert if a success message exists in the session
    echo alarm('success', Session::get('message'), '22em', Lang::get('position-alarm'));
    Session::delete('message'); // Clear the success message from session
}
?>