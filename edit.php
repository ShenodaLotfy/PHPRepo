<?php
try {
    include_once("database_connection.php");
    include_once("Product.php");
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

    $id = $_POST["id"];
    $prod_name = $_POST['prod_name'];
    $prop_brand = $_POST['prod_brand'];
    $prod_expiry_date = $_POST['prod_expiry'];
    $prod_availabilty = $_POST['prod_availability'];

    $query = $connection->prepare("update products set prod_name = ?, prop_brand=?, 
                                prod_expiry_date=?, prod_availabilty=?, prod_image=? where id = ?");
    $query->execute([$prod_name, $prop_brand, $prod_expiry_date, $prod_availabilty, $prod_image, $id]);
    header("location: index.php");
} catch (Exception $exc) {
    echo "error " . $exc;
}
