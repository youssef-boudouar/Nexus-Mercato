<?php


session_start();


include '../config/database.php';
include '../models/Transfer.php';


if($_SESSION['user_role'] !== 'admin')
{
    header('Location: transfers.php');
    exit();
}
if(isset($_GET['id'])) 
{
    $id = $_GET['id'];

    $transfer = new Transfer();
    $transfer->delete($id);
    header('Location: transfers.php');
    exit();
}

