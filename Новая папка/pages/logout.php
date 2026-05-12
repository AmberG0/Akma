<?php
require_once '../inc/functions.php'; 
session_destroy();
redirect('login.php');
?>