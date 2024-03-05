<?php

session_start();

if(isset($_SESSION['mo_no'])){
    unset($_SESSION['mo_no']);
}

header("Location: index.php");
die;

?>