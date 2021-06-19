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

    body {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        height: 1000px !important;
        background-color: white !important;
    }

    div ul {
        display: none;
    }
</style>

<body>
    <?php
    try {
        include_once("database_connection.php");
        include_once("view.php");
        include_once("Product.php");
        $id = $_GET["id"];
        $query = $connection->prepare("select * from products where id = ? ");
        $query->execute([$id]);
        $result = $query->fetchAll(PDO::FETCH_CLASS, "Product");
    } catch (Exception $exc) {
        echo "error " . $exc->getMessage();
    }

    ?>

    <?php if ($result != null) { ?>
        <div class="container">
            <div class="navigation">
                <ul>
                    <li><a href="index.php">Home</a></li>
                </ul>
            </div>

            <form method="post" enctype="multipart/form-data" action="edit.php">
                <input type="hidden" name="id" value="<?= $id ?>">
                <div class="form-row ">
                    <div class="col-md-5 mb-3">
                        <label for="productName">Product Name</label>
                        <input value="<?= $result[0]->prod_name ?>" type="text" name="prod_name" class="form-control " id="productName" placeholder="Product Name" required>
                        <!-- <div class="valid-feedback">
                        Looks good!
                    </div> -->
                    </div>
                    <div class="col-md-5 mb-3">
                        <label for="productBrand">Product Brand</label>
                        <input value="<?= $result[0]->prop_brand ?>" type="text" name="prod_brand" class="form-control " id="productBrand" placeholder="Last name" required>
                        <!-- <div class="valid-feedback">
                        Looks good!
                    </div> -->
                    </div>

                </div>
                <div class="form-row">
                    <div class="col-md-5 mb-3">
                        <label for="productExpiry">Product Expiry Date</label>
                        <input value="<?= $result[0]->prod_expiry_date ?>" type="date" name="prod_expiry" class="form-control" id="productExpiry" required>
                        <!-- <div class="invalid-feedback">
                        Please provide a valid date.
                    </div> -->
                    </div>
                    <div class="col-md-5 mb-3">
                        <label for="availabily">Availabily</label>
                        <div class="col md-3 mb-3" style="height: auto; display:flex; flex-direction: column; justify-content: space-between">
                            <div style="display: flex; align-items: center">
                                <input <?= ($result[0]->prod_availabilty === "1") ? 'checked' : '' ?> name="prod_availability" value="1" style="display:inline;width: 5%; height: 15px; margin:0 5px" type="radio" class="form-control is-invalid" id="availabily" required>
                                <labe for="">InStock</labe>
                            </div>
                            <div style="display: flex; align-items: center">
                                <input <?= ($result[0]->prod_availabilty === "1") ? '' : 'checked' ?> name="prod_availability" value="0" style="display:inline; width: 5%; height: 15px; margin:0 5px" type="radio" class="form-control is-invalid" id="availabily" required>
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
                        <label style="width: 50%; margin-left: 20px" class="custom-file-label fileLable" for="image"><?= $result[0]->prod_image ?></label>
                        <!-- <div class="invalid-feedback">Example invalid custom file feedback</div> -->
                    </div>
                </div>


                <button class="btn btn-primary" type="submit">Edit Product</button>
                <a class="btn btn-primary" href="view.php?id=<?= $result[0]->id ?>">Cancel</a>
            </form>
        </div>
    <?php }  ?>

    <script>
        var file = document.querySelector(".custom-file-input");
        file.addEventListener("change", function() {
            if (file.value != "") {
                document.querySelector(".fileLable").innerHTML = file.value;
            }
        })
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</body>

</html>