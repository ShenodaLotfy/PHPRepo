<?php
include_once("database_connection.php");
include_once("Product.php");
$id = $_GET["id"];
$query = $connection->prepare("delete from products where id = ?");
$query->execute([$id]);
header("location: softDeletedHistory.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <script></script>
</body>

</html>