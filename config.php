<?php

// Is registration open?
$registrationisopen = true;

// Website Settings
$adminusername = "admin";
$adminpassword = "admin";
$baseurl = "http://localhost/CiihuyCom/workshop/PHPEasyRSVP/";
$websitetitle = "CS PHP Easy RSVP";

// Mailing Settings
$emailhost = "mail.ciihuy.com";
$emailusername = "emailsendertest@ciihuy.com"; // Change it to yours
$emailpassword = "123123123";

include("mailing.php");

// Database Connection Settings
$registrationtable = "phpeasyrsvp_registration";
$feedbacktable = "phpeasyrsvp_feedback";

$host = "localhost";
$dbuser = "root";
$dbpassword = "";
$databasename = "mydatabase";
$connection = mysqli_connect($host, $dbuser, $dbpassword, $databasename);
$connection->set_charset("utf8");

// Creating database table for registration
mysqli_query($connection, "CREATE TABLE IF NOT EXISTS $registrationtable (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
datereg VARCHAR(30) NOT NULL,
attending VARCHAR(10) NOT NULL,
title VARCHAR(10) NOT NULL,
fullname VARCHAR(30) NOT NULL,
org VARCHAR(30) NOT NULL,
des VARCHAR(30) NOT NULL,
email VARCHAR(30) NOT NULL,
awarded VARCHAR(30) NOT NULL,
deleted INT(30) NOT NULL
)");

// Creating databse table for feedback
mysqli_query($connection, "CREATE TABLE IF NOT EXISTS $feedbacktable (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
fb1 VARCHAR(200) NOT NULL,
fb2 VARCHAR(200) NOT NULL,
fb3 VARCHAR(200) NOT NULL,
fb4 VARCHAR(200) NOT NULL,
fb5 VARCHAR(200) NOT NULL,
fb6 VARCHAR(200) NOT NULL,
fb7 VARCHAR(200) NOT NULL,
fb8 VARCHAR(200) NOT NULL,
fb9 VARCHAR(200) NOT NULL,
fb10 VARCHAR(200) NOT NULL,
fb11 VARCHAR(200) NOT NULL,
fb12 VARCHAR(200) NOT NULL,
fb13 VARCHAR(200) NOT NULL,
fb14 VARCHAR(200) NOT NULL
)");

?>