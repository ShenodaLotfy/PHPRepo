<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <title>Home</title>
    <script src="fontawesome-free-5.15.3-web/js/all.min.js"></script>
</head>

<style>
    .container {
        width: 80%;
        margin: 20px auto
    }

    ul {
        list-style: none;
        margin: 0;
        padding: 0;
        margin-bottom: 50px;
    }

    ul li {
        display: inline-block;
        margin-right: 15px;
    }

    .col-md-5 {
        margin: 0 15px;
    }

    tbody a {
        color: gray;
        font-size: 1.3rem;
        transition: .4s;
    }

    tbody a:hover {
        color: white;
        font-size: 1.4rem;
    }

    .confirmation>div {
        display: inline-block;
        margin: 5px 0
    }

    .confirmation a {
        text-decoration: none;
        color: white;
        border: 1px solid white;
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

    a.deleteButton {
        color: gray !important;
    }

    a.deleteButton:hover {
        color: white !important;
    }
</style>

<body>
    <?php
    include_once("database_connection.php");
    include_once("Product.php");
    $query = $connection->prepare("select * from products where delete_status = 1");
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_CLASS, "Product");
    ?>


    <div class="container">
        <div class="navigation">
            <ul>
                <li><a href="index.php">Home</a></li>
            </ul>
        </div>

        <?php
        if (count($result) > 0) { ?>
            <table class="table table-hover table-striped table-dark" style="text-align: center;">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Brand</th>
                        <th scope="col">Expiry Date</th>
                        <th scope="col">Availabily</th>
                        <th scope="col">Pircture</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($result as $product) :  ?>
                        <tr>
                            <th style="vertical-align: middle;" scope="row"><?php echo $product->id ?></th>
                            <td style="vertical-align: middle;"><?php echo $product->prod_name ?></td>
                            <td style="vertical-align: middle;"><?php echo $product->prop_brand ?></td>
                            <td style="vertical-align: middle;"><?php echo $product->prod_expiry_date ?></td>
                            <td style="vertical-align: middle;"><?php echo ($product->prod_availabilty) ? "In Stock" : "Out Of Stock" ?></td>
                            <td style="vertical-align: middle; width: 150px;height: 100px">
                                <img style="width: auto;height: 100px" src="images/<?= ($product->prod_image) ?> ">
                            </td>
                            <td style="vertical-align: middle;">
                                <a href="view.php?id=<?= $product->id ?>" title="View Product">
                                    <i class="fas fa-eye"></i>
                                </a>
                                |
                                <a href="restore.php?id=<?= $product->id ?>" title="Restore Product">
                                    <i class="fas fa-trash-restore-alt"></i>
                                </a>
                                |
                                <a class="deleteButton" name="<?= $product->id ?>" title="Delete Product">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                                <div id="<?= $product->id ?>" style="display: none">
                                    <span>Becareful, its a permanent delete!...</span>
                                    <div class="confirmation">
                                        <div><a id="Confirm" href="hardDelete.php?id=<?= $product->id ?>">Confirm</a></div>
                                        <div><a id="Cancel" name="<?= $product->id ?>">Cancel</a></div>
                                    </div>

                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                </tbody>
            </table>
        <?php
        } else {
            echo "<h3>There's no deleted records!...</h3>";
        }
        ?>


    </div>

    <script>
        var allDelete = document.querySelectorAll(".deleteButton");
        for (var i = 0; i < allDelete.length; i++) {
            allDelete[i].addEventListener("click", function(e) {
                var string = this.name;
                document.getElementById(string).style.display = "block";
            })
        }

        var cancelButton = document.querySelectorAll("#Cancel");
        for (var i = 0; i < cancelButton.length; i++) {
            cancelButton[i].addEventListener("click", function() {
                document.getElementById(this.name).style.display = "none";
            })
        }
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</body>

</html>