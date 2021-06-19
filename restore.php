<?php
include_once("database_connection.php");
include_once("Product.php");
$id = $_GET["id"];
$query = $connection->prepare("update products set delete_status = 0 where id = ?");
$query->execute([$id]);
header("location: softDeletedHistory.php");
