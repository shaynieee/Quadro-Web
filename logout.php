<?php
session_start();
include_once("../db.php");
if(isset($_GET['logout'])){
    session_destroy();
    header("location:../QUADRO-WEB/log_in.php");
}
?>