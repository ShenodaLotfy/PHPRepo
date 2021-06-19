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

    a.delete {
        color: gray !important;
    }

    a.delete:hover {
        color: white !important;
    }
</style>

<body>
    <?php

    $host = 'mysql-35292-0.cloudclusters.net';
    $db   = 'vendor';
    $user = 'admin';
    $pass = 'poc8706m';
    $port = "35328";
    $charset = 'utf8mb4';

    $options = [
        \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
        \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
        \PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    $dsn = "mysql:host=$host;dbname=$db;charset=$charset;port=$port";
    try {
        $connection = new \PDO($dsn, $user, $pass, $options);
    } catch (\PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }

    include_once("Product.php");
    $query = $connection->prepare("select * from products where delete_status = 0");
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_CLASS, "Product");
    ?>


    <div class="container">
        <div class="navigation">
            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="softDeletedHistory.php">Show Deleted Records</a></li>
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
                                <img style="max-width: 200px;width: auto;height: 100px" src="images/<?= ($product->prod_image) ?> ">
                            </td>
                            <td style="vertical-align: middle;">
                                <a href="view.php?id=<?= $product->id ?>" title="View Product">
                                    <i class="fas fa-eye"></i>
                                </a>
                                |
                                <a href="editForm.php?id=<?= $product->id ?>" title="Edit Product">
                                    <i class="fas fa-edit"></i>
                                </a>
                                |
                                <a class="delete" name="<?= $product->id ?>" title="Delete Product">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                                <div id="<?= $product->id ?>" style="display: none">
                                    <span>Are you sure you want to delete this product?</span>
                                    <div class="confirmation">
                                        <div><a id="Confirm" href="softDelete.php?id=<?= $product->id ?>">Confirm</a></div>
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
            echo "<h3>There's no records inserted yet...</h3>";
        }
        ?>

        <form method="post" enctype="multipart/form-data" action="insert.php">
            <div class="form-row ">
                <div class="col-md-5 mb-3">
                    <label for="productName">Product Name</label>
                    <input type="text" name="prod_name" class="form-control " id="productName" placeholder="Product Name" required>
                    <!-- <div class="valid-feedback">
                        Looks good!
                    </div> -->
                </div>
                <div class="col-md-5 mb-3">
                    <label for="productBrand">Product Brand</label>
                    <input type="text" name="prod_brand" class="form-control " id="productBrand" placeholder="Last name" required>
                    <!-- <div class="valid-feedback">
                        Looks good!
                    </div> -->
                </div>

            </div>
            <div class="form-row">
                <div class="col-md-5 mb-3">
                    <label for="productExpiry">Product Expiry Date</label>
                    <input type="date" name="prod_expiry" class="form-control" id="productExpiry" required>
                    <!-- <div class="invalid-feedback">
                        Please provide a valid date.
                    </div> -->
                </div>
                <div class="col-md-5 mb-3">
                    <label for="availabily">Availabily</label>
                    <div class="col md-3 mb-3" style="height: auto; display:flex; flex-direction: column; justify-content: space-between">
                        <div style="display: flex; align-items: center">
                            <input name="prod_availability" value="1" style="display:inline;width: 5%; height: 15px; margin:0 5px" type="radio" class="form-control is-invalid" id="availabily" required>
                            <labe for="">InStock</labe>
                        </div>
                        <div style="display: flex; align-items: center">
                            <input name="prod_availability" value="0" style="display:inline; width: 5%; height: 15px; margin:0 5px" type="radio" class="form-control is-invalid" id="availabily" required>
                            <label for="">Out Of Stock</label>
                        </div>
                    </div>

                    <!-- <div class="invalid-feedback">
                        Please provide a valid state.
                    </div> -->
                </div>
            </div>
            <div class="form-row">
                <div class="custom-file col md-6 mb-3">
                    <input type="file" name="image" class="custom-file-input" id="image" required>
                    <label style="width: 50%; margin-left: 20px" class="custom-file-label fileLable" for="image">Choose file...</label>
                    <!-- <div class="invalid-feedback">Example invalid custom file feedback</div> -->
                </div>
            </div>


            <button class="btn btn-primary" type="submit">Add Product</button>
        </form>
    </div>

    <script>
        var file = document.querySelector(".custom-file-input");
        file.addEventListener("change", function() {
            if (file.value != "") {
                document.querySelector(".fileLable").innerHTML = file.value;
            }
        })

        var allDelete = document.querySelectorAll(".delete");
        console.log(allDelete);
        for (var i = 0; i < allDelete.length; i++) {
            console.log(allDelete[1]);
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