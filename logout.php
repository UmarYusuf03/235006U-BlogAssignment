<?php
//Include configuration file
require_once './config.php';
//After logged out - destroy the session
session_destroy();
//Redirect to Index file
header('Location: ./index.php');
exit;
