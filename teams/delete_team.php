<?php


session_start();


include '../config/database.php';
include '../models/Team.php';


if($_SESSION['user_role'] !== 'admin')
{
    header('Location: teams.php');
    exit();
}
if(isset($_GET['id'])) 
{
    $id = $_GET['id'];

    $team = new Team();
    $team->setId($id);
    $team->delete();
    header('Location: teams.php');
    exit();
}

