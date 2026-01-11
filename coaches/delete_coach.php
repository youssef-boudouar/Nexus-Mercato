<?php

session_start();


include '../config/database.php';
include '../models/Coach.php';


if($_SESSION['user_role'] !== 'admin')
{
    header('Location: coaches.php');
    exit();
}
if(isset($_GET['id'])) 
{
    $id = $_GET['id'];

    $coach = new Coach();
    $coach->setId($id);
    $coach->delete();
    header('Location: coaches.php');
    exit();
}