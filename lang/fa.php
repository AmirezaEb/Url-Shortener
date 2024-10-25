<?php

/**
 * Persian [fa] Language Configuration File
 * 
 * This file defines the configuration for the Persian language, including
 * general settings such as directionality, font, and stylesheets, as well
 * as localized strings for the user interface.
 */

return [
    # General Configuration for Persian [fa] Language
    'lang' => 'fa', # Language code
    'dir' => 'rtl', # Text direction (right-to-left)
    'font' => 'https:#fonts.cdnfonts.com/css/lalezar', # Persian-specific font URL
    'maincss' => 'css/fa/main.css', # Main stylesheet for Persian layout
    'resonsecss' => 'css/fa/responsive.css', # Responsive stylesheet for Persian layout
    'emailcss' => 'css/fa/email.css', # Email-related stylesheet for Persian layout
    'appjs' => 'js/fa/app.js', # Main JavaScript file for Persian layout
    'indexjs' => 'js/fa/index.js', # Index page JavaScript for Persian layout
    'direction-1' => 'right', # Primary text alignment direction
    'direction-2' => 'left', # Secondary text alignment direction
    'position-alarm' => 'top-end', # Default position for notifications (e.g., SweetAlert)

    # Localization for the Index View
    'index-title' => 'کوتاه کننده لینک', # Title for the index page
    'clear' => 'پاک کردن', # Button text for clearing input
    'copy' => 'کپی', # Button text for copying the shortened URL
    'short' => 'تبدیل لینک', # Button text for generating a shortened URL
    'panel' => 'پنل کاربری', # Label for user control panel
    'yourshort' => 'لینک کوتاه شما', # Placeholder for displaying shortened URL
    'yourlink' => 'لینک مورد نظر را وارد کنید', # Placeholder for entering the URL

    # Localization for the Login View
    'login-title' => 'ورود | عضویت', # Title for the login page
    'signin' => 'ورود به سایت', # Button text for signing in
    'sendcode' => 'ارسال کد', # Button text for sending verification code
    'pemail' => 'لطفا ایمیل معتبر وارد نمایید!', # Error message for invalid email input
    'inputemail' => 'ایمیل خود را وارد کنید...', # Placeholder for email input field

    # Localization for the Verify View
    'verify-title' => 'احراز هویت', # Title for the email verification page
    'verify' => 'احراز هویت ایمیل', # Button text for verifying email
    'sub' => 'تأیید', # Button text for form submission
    'pverify' => 'لطفاً کد تأیید معتبر را وارد کنید!', # Error message for invalid verification code
    'inputverify' => 'لطفا کد تایید را وارد نمایید', # Placeholder for verification code input

    # Localization for the User Panel View
    'panel-h1' => 'کارشناس قهرمان', # Header text for the user panel
    'panel-title' => 'پنل کاربری', # Title for the user panel page
    'dash' => 'داشبورد', # Label for the dashboard section
    'stats' => 'آمار', # Label for the statistics section
    'profile' => 'پروفایل [بزودی...]', # Placeholder for upcoming profile feature
    'settings' => 'تنظیمات [بزودی...]', # Placeholder for upcoming settings feature
    'desturl' => 'لینک مقصد', # Label for the destination URL
    'view' => 'بازدید', # Label for the number of views
    'qr' => 'QR بارکد', # Label for QR code functionality
    'edit' => 'ویرایش', # Button text for editing the URL
    'delete' => 'حذف', # Button text for deleting the URL
    'shorturl' => 'لینک کوتاه', # Label for displaying the shortened URL

    # Localization for the Edit URL Panel View
    'edit-title' => 'ویرایش لینک', # Title for the edit URL page
    'edit-h2' => 'ویرایش لینک مقصد', # Header text for the edit URL form
    'edit-input' => 'لینک مقصد را وارد کنید...', # Placeholder for the destination URL input

    # Localization for Sending Email Notifications
    'emailMs' => 'رمز عبور یکبار مصرف شما: ', # Email message for sending a one-time password
    'emailTitle' => 'کارشناس قهرمان', # Email subject/title
    'welcome' => 'سلام دوست گرامی', # Email greeting

    # Error Messages for Display
    'Er-InvalidEmail' => 'ایمیل وارد شده معتبر نمی باشد', # Error message for invalid email
    'Er-TryAgain' => 'خطایی رخ داد، لطفا مجدد تلاش کنید', # Generic error message
    'Er-Expired' => 'انقضای کد شما به پایان رسیده لطفا مجدد تلاش کنید', # Error message for expired verification code
    'Er-InvalidCode' => 'کد وارد شده اشتباه است لطفا مجدد تلاش کنید', # Error message for incorrect verification code
    'Er-TryAgin' => 'لطفا مجددا تلاش کنید...', # Retry message for errors

    # Success Messages for Display
    'Ms-LoginSuccess' => 'کاربر محترم، به حساب کاربری خود خوش آمدید', # Success message for login
    'Ms-EditSuccess' => 'لینک شما با موفقیت ویرایش شد', # Success message for URL update
    'Ms-DeleteSuccess' => 'لینک شما با موفقیت حذف شد', # Success message for URL deletion
    'Ms-LogOut' => 'شما با موفقیت از حساب کاربری خود خارج شدید', # Success message for logout
];

?>