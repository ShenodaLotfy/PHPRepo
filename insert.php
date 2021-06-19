<?php
include_once("database_connection.php");
try {
  $fileName = $_FILES['image']['name'];
  $lowerFileName = strtolower($fileName);
  $tempPath = $_FILES['image']['tmp_name'];
  $exploded = explode(".", $fileName);
  $currentExtension = strtolower(end($exploded));

  $fileExtensionsAllowed = array("jpg", "png", "jif", "raw", "svg");
  if (in_array($currentExtension, $fileExtensionsAllowed)) {
    move_uploaded_file($tempPath, "images/" . $fileName);
    $prod_image = $fileName;
  } else {
    // error occured  
  }

  $prod_name = $_POST['prod_name'];
  $prop_brand = $_POST['prod_brand'];
  $prod_expiry_date = $_POST['prod_expiry'];
  $prod_availabilty = $_POST['prod_availability'];
  $query = $connection->prepare("INSERT INTO products (prod_name, prop_brand, prod_expiry_date, prod_availabilty, delete_status,prod_image)
  VALUES (?,?,?,?,?,?)");
  $query->execute([$prod_name, $prop_brand, $prod_expiry_date, $prod_availabilty, "0", $prod_image]);
  header("location:index.php");
} catch (PDOException $exc) {
  echo "Error: " . $exc->getMessage();
}
