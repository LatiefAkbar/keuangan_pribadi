<?php 
session_start();

if(!$_SESSION['user_id']){
    header(header: "Location: http://localhost/keuangan_pribadi/index.php");
    exit;
}