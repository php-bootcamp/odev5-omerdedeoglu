<!DOCTYPE HTML>
<html>

<head>
    <title>Create a Record</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />


</head>

<body>
    <div class="container">

        <div class="page-header">
            <h1>Create Product</h1>
        </div>
        <!-- Insert process -->
        <?php
        // include database connection
        include 'config/database.php';
        $categoryStmt = $con->query('SELECT * FROM categories')->fetchAll();
        if ($_POST) {

            try {

                // insert query
                $query = "INSERT INTO products SET uniqid=:uniqid, name=:name, price=:price, description=:description, content=:content, category=:category";

                // prepare query for execution
                $stmt = $con->prepare($query);

                // posted values
                $uniqid = uniqid($prefix = "", $more_entropy = false);
                $name = htmlspecialchars(strip_tags($_POST['name']));
                $price = htmlspecialchars(strip_tags($_POST['price']));
                $description = htmlspecialchars(strip_tags($_POST['description']));
                $content = htmlspecialchars(strip_tags($_POST['content']));
                $category = htmlspecialchars(strip_tags($_POST['categories']));

                // bind the parameters
                $stmt->bindParam(':uniqid', $uniqid);
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':price', $price);
                $stmt->bindParam(':description', $description);
                $stmt->bindParam(':content', $content);
                $stmt->bindParam(':category', $category);


                // Execute the query
                if ($stmt->execute()) {
                    echo "<div class='alert alert-success'>Record was saved.</div>";
                } else {
                    echo "<div class='alert alert-danger'>Unable to save record.</div>";
                }
            }

            // show error
            catch (PDOException $exception) {
                die('ERROR: ' . $exception->getMessage());
            }
        }
        ?>

        <!-- html form here where the product information will be entered -->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <table class='table table-hover table-responsive table-bordered col-lg-12'>
                <tr>
                    <td>Name</td>
                    <td><input type='text' name='name' class='form-control' /></td>
                </tr>

                <tr>
                    <td>Price</td>
                    <td><input type='text' name='price' class='form-control' /></td>
                </tr>

                <tr>
                    <td>Description</td>
                    <td><textarea name='description' class='form-control'></textarea></td>
                </tr>

                <tr>
                    <td>Content</td>
                    <td><textarea name='content' class='form-control'></textarea></td>
                </tr>

                <tr>
                    <td>Category</td>
                    <td>
                        <select name="categories">
                            <?php if (!$categoryStmt) { ?>
                                <option value="" disabled selected>There is no category</option>
                            <?php } else { ?>

                                <?php foreach ($categoryStmt as $value) {
                                    $optionValue = $value['name'];
                                ?>
                                    <option value="<?= $optionValue ?>"> <?= $value['name'] ?> </option>
                            <?php }
                            }
                            ?>

                        </select>
                    </td>
                </tr>

                <tr>
                    <td></td>
                    <td>
                        <input type='submit' value='Save' class='btn btn-primary' />
                        <a href='index.php' class='btn btn-danger'>Back to read products</a>
                    </td>
                </tr>
            </table>
        </form>

    </div> <!-- end .container -->


    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</body>

</html>