<?php
session_start();
include '../config/db.php';

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $user_id = $_SESSION['user_id'];

    // pastikan transaksi milik user yang login
    $query = "DELETE FROM transaksi WHERE id='$id' AND user_id='$user_id'";
    if(mysqli_query($conn, $query)){
        header("Location: ../dashboard.php");
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
