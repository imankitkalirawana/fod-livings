<?php
require_once "config.php";

session_start();

$param_id = $_SESSION["id"];
$param_username = $_SESSION["username"];
$stmp = $link->prepare("SELECT * from users where id=?");
$stmp->bind_param("i", $param_id);
$stmp->execute();
$result = $stmp->get_result();
$row = $result->fetch_assoc();

$param_name = $row['first_name'];
$param_email = $row['email'];
$param_image = $row['image'];
$param_user_type = $row['usertype'];

// echo $param_user_type;
