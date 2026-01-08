<?php


session_start();


include '../config/database.php';
include '../models/Contract.php';


if($_SESSION['user_role'] !== 'admin')
{
    header('Location: contracts.php');
    exit();
}
if(isset($_GET['id'])) 
{
    $id = $_GET['id'];

    $contract = new Contract();
    $contract->setId($id);
    $contract->delete();
    header('Location: contracts.php');
    exit();
}

