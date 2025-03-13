<?php

/**
 * English Language Configuration File
 * 
 * This file defines the configuration for the English language, including
 * general settings such as directionality, font, and stylesheets, as well
 * as localized strings for the user interface.
 */

return [
    # General Configuration for English [en] Language
    'lang' => 'en', # Language code
    'dir' => 'ltr', # Text direction (left-to-right)
    'font' => 'https://fonts.cdnfonts.com/css/going-to-school', # Font URL for English text
    'maincss' => 'css/en/main.css', # Main stylesheet for English layout
    'resonsecss' => 'css/en/responsive.css', # Responsive stylesheet for English layout
    'emailcss' => 'css/en/email.css', # Email-related stylesheet for English layout
    'appjs' => 'js/en/app.js', # Main JavaScript file for English layout
    'GDLibrary' => 'css/en/GDLibrary.css',
    'indexjs' => 'js/en/index.js', # Index page JavaScript for English layout
    'direction-1' => 'left', # Primary text alignment direction
    'direction-2' => 'right', # Secondary text alignment direction
    'position-alarm' => 'top-start', # Default position for notifications (e.g., SweetAlert)

    # Localization for the Index View
    'index-title' => 'Url Shortener', # Title for the index page
    'clear' => 'Clear', # Button text for clearing input
    'copy' => 'Copy', # Button text for copying the shortened URL
    'short' => 'Shorten Url', # Button text for generating a shortened URL
    'panel' => 'User Panel', # Label for user control panel
    'yourshort' => 'Your Short Url', # Placeholder for displaying shortened URL
    'yourlink' => 'Enter Url Here', # Placeholder for entering the URL

    # Localization for the Login View
    'login-title' => 'Sign In | Sign Up', # Title for the login page
    'signin' => 'Sign In', # Button text for signing in
    'sendcode' => 'Send Code', # Button text for sending verification code
    'pemail' => 'Please Enter Valid Email!', # Error message for invalid email input
    'inputemail' => 'Enter Your Email...', # Placeholder for email input field

    # Localization for the Verify View
    'verify-title' => 'Verify Email', # Title for the email verification page
    'verify' => 'Verify your Email', # Button text for verifying email
    'sub' => 'Submit', # Button text for form submission
    'pverify' => 'Please Enter Valid Verify Code!', # Error message for invalid verification code
    'inputverify' => 'Enter Your Code', # Placeholder for verification code input

    # Localization for the User Panel View
    'panel-h1' => 'Hero Expert', # Header text for the user panel
    'panel-title' => 'User Panel', # Title for the user panel page
    'dash' => 'Dashboard', # Label for the dashboard section
    'stats' => 'Stats', # Label for the statistics section
    'profile' => 'Profile [Soon...]', # Placeholder for upcoming profile feature
    'settings' => 'Settings [Soon...]', # Placeholder for upcoming settings feature
    'comingsoon' => 'Comming Soon!', # Label for the comming soon feature
    'copied' => 'Copied!', # Label for the copied feature
    'desturl' => 'Dest URL', # Label for the destination URL
    'view' => 'Views', # Label for the number of views
    'qr' => 'QR Code', # Label for QR code functionality
    'edit' => 'Edit', # Button text for editing the URL
    'delete' => 'Delete', # Button text for deleting the URL
    'shorturl' => 'Short URL', # Label for displaying the shortened URL

    # Localization for the erroe GDLibrary View
    'GD-title' => 'GD Activation Error',
    'GD-h1' => 'GD Library Error',
    'GD-p1' => 'The GD Library is not enabled on your server. To use this feature, you need to enable GD in your <code>php.ini</code> file.',
    'GD-p2' => 'Please restart the server after enabling GD.',
    'GD-a' => 'How to Enable GD',

    # Localization for the Edit URL Panel View
    'edit-title' => 'Edit Url', # Title for the edit URL page
    'edit-h2' => 'Edit Destination URL', # Header text for the edit URL form
    'edit-input' => 'Enter Your Destination Url...', # Placeholder for the destination URL input
    'pedit' => 'Please Enter Valid URL!', # Error message for invalid Edit URL input

    # Localization for Sending Email Notifications
    'emailMs' => 'Your Email Authentication Code : ', # Email message for sending a new password
    'emailTitle' => 'Hero Expert', # Email subject/title
    'welcome' => 'Welcome', # Email greeting

    # Error Messages for Display
    'Er-InvalidEmail' => 'The Email You Entered Is Not Valid', # Error message for invalid email
    'Er-TryAgain' => 'An Error Has Occurred, Please Try Again', # Generic error message
    'Er-Expired' => 'The Code Has Expired, Please Try Again', # Error message for expired verification code
    'Er-InvalidCode' => 'The Code You Entered Is Incorrect, Please Try Again', # Error message for incorrect verification code
    'Er-TryAgin' => 'Please Try Again...', # Retry message for errors
    'Er-Login' => 'Please Log In To Your Account To Create a Short Link', # Login error message
    'Er-InvalidUrl' => 'The URL You Entered Is Not Valid...', # Error message for invalid URL

    # Success Messages for Display
    'Ms-LoginSuccess' => 'Dear User, Welcome To Your Account', # Success message for login
    'Ms-EditSuccess' => 'The Link Has Been Successfully Updated', # Success message for URL update
    'Ms-DeleteSuccess' => 'The Link Has Been Successfully Deleted', # Success message for URL deletion
    'Ms-LogOut' => 'You Have Successfully Logged Out Of Your Account', # Success message for logout
    'Ms-Create' => 'Your ShortUrl Has Been Successfully Created', # Success message for Create Shor Url
    'Ms-Copied' => 'Copied!' # Success message for Copying Url
];
