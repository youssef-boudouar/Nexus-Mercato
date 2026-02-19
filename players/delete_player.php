<?php

session_start();


include '../config/database.php';
include '../models/Player.php';


if($_SESSION['user_role'] !== 'admin')
{
    header('Location: players.php');
    exit();
}
if(isset($_GET['id'])) 
{
    $id = $_GET['id'];

    $player = new Player();
    $player->setId($id);
    $player->delete();
    header('Location: players.php');
    exit();
}