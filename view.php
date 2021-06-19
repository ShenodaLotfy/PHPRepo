<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
    * {
        padding: 0;
        margin: 0;
        box-sizing: border-box;
    }

    body {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        height: 100vh;
        background: rgba(0, 0, 0, .1);
    }


    .product {
        width: 300px;
        height: 300px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        box-shadow: 5px 10px 15px rgba(0, 0, 0, .3), 3px 5px 9px rgba(0, 0, 0, .3);
        background: white;
        transition: .5s;
    }

    .product:hover {
        width: 320px;
        height: 310px;
        cursor: pointer;
    }

    .product>div {
        margin: 10px;
    }

    ul {
        list-style: none;
        margin: 0;
        padding: 0
    }

    ul li {
        display: inline-block;
        padding: 10px;
        border-radius: 10px;
        margin-left: 20px;
        transition: .5s;
    }

    ul li a {
        text-decoration: none;
        font-size: 18px;
        font-weight: bold;
        color: white;
    }

    ul li.edit,
    li.viewall {
        background: #007bff;
    }

    ul li.delete {
        background: Red;
    }

    ul li.viewall {
        margin-top: 20px;
        display: block;
    }

    ul li.edit:hover,
    ul li.delete:hover,
    ul li.viewall:hover {
        background: black
    }

    .confirmation>div {
        display: inline-block;
        margin: 5px 0
    }

    .confirmation a {
        text-decoration: none;
        color: black !important;
        border: 1px solid black !important;
        padding: 3px 8px;
        margin: 5px 0;
        font-size: 14px;
        transition: .3s;
    }

    .confirmation a:hover {
        text-decoration: none;
        padding: 3px 15px;
        font-size: 14px;
        cursor: pointer;
    }

    a.delete {
        color: gray !important;
    }

    a.delete:hover {
        color: white !important;
    }
</style>

<?php
try {
    include_once("database_connection.php");
    include_once("Product.php");
    $id = $_GET["id"];
    $query = $connection->prepare("select * from products where id = ?");
    $query->execute([$id]);
    $result = $query->fetchAll(PDO::FETCH_CLASS, "Product");
} catch (Exception $exc) {
    echo "Error " . $exc->getMessage();
}
?>

<?php if (count($result) > 0) { ?>

    <body>
        <div class="product">
            <div class="img">
                <img style="max-width: 200px;" width="auto" height="100px" src="images/<?= $result[0]->prod_image ?>" alt="">
            </div>
            <div class="brand">
                <h5>Category: <?= $result[0]->prod_name ?></h5>
            </div>
            <div class="availability">
                <h5>Brand: <?= $result[0]->prop_brand ?></h5>
            </div>

        </div>
        <div style="margin-top: 20px;">
            <ul>
                <li class="edit"><a href="editForm.php?id=<?= $result[0]->id ?>">Edit</a></li>
                <li class="delete"><a>Delete</a></li>
                <div id="<?= $result[0]->id ?>" style="display: none">
                    <span>Are you sure you want to delete this product?</span>
                    <div class="confirmation">
                        <div><a id="Confirm" href="softDelete.php?id=<?= $result[0]->id ?>">Confirm</a></div>
                        <div><a id="Cancel" name="<?= $result[0]->id ?>">Cancel</a></div>
                    </div>

                </div>
                <li class="viewall"><a href="index.php">View All Products</a></li>
            </ul>
        </div>

        <script>
            var deleteBut = document.querySelector(".delete");
            deleteBut.addEventListener("click", function() {
                document.getElementById("<?= $result[0]->id ?>").style.display = "block";
            })

            var cancelButton = document.querySelectorAll("#Cancel");
            for (var i = 0; i < cancelButton.length; i++) {
                cancelButton[i].addEventListener("click", function() {
                    document.getElementById(this.name).style.display = "none";
                })
            }
        </script>
    <?php } else {
    echo "<h3> Product not found! </h3>";
}
    ?>





    </body>

</html>