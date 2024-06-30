<?php

/* 
Developed by Hero Expert
Telegram channel : HeroExpert_ir
*/

#----- Constants -----#

const URL = 'https://HeroExpert.ir/UrlShortner-Persian/'; # File Location Url

#----- DataBase -----#

$userName = 'root'; # DataBase Username
$dbName = 'heroexpert'; # DataBase Name
$passWord = ''; # DataBase password

try {
    $connect = new PDO('mysql:host=localhost;dbname=' . $dbName, $userName, $passWord);
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    #echo "Connecting Successfully";
} catch (Exception $e) {
    #echo "Connect Failed : " . $e->getMessage();
}
?>