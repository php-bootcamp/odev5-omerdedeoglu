<!DOCTYPE HTML>
<html>

<head>
    <title>Update a Record</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />

</head>

<body>

    <!-- container -->
    <div class="container">

        <div class="page-header">
            <h1>Update Product</h1>
        </div>

        <?php

        $uniqid = isset($_GET['uniqid']) ? $_GET['uniqid'] : die('ERROR: Record UniqID not found.');

        //include database connection
        include 'config/database.php';
        $categoryStmt = $con->query('SELECT * FROM categories')->fetchAll();
        // read current record's data
        try {
            // prepare select query
            $query = "SELECT uniqid, name, price ,description, content, category FROM products WHERE uniqid = ? LIMIT 0,1";
            $stmt = $con->prepare($query);

            // this is the first question mark
            $stmt->bindParam(1, $uniqid);

            // execute query
            $stmt->execute();

            // store retrieved row to a variable
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // values to fill up our form
            $name = $row['name'];
            $price = $row['price'];
            $description = $row['description'];
            $content = $row['content'];
            $category = $row['category'];
        }

        // show error
        catch (PDOException $exception) {
            die('ERROR: ' . $exception->getMessage());
        }
        ?>

        <?php

        // check if form was submitted
        if ($_POST) {

            try {
                // update query
                $query = "UPDATE products 
                    SET name=:name, price=:price, description=:description, content=:content, category=:category
                    WHERE uniqid = :uniqid";

                // prepare query for excecution
                $stmt = $con->prepare($query);

                // posted values
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
                    echo "<div class='alert alert-success'>Record was updated.</div>";
                } else {
                    echo "<div class='alert alert-danger'>Unable to update record. Please try again.</div>";
                }
            }

            // show errors
            catch (PDOException $exception) {
                die('ERROR: ' . $exception->getMessage());
            }
        }
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?uniqid={$uniqid}"); ?>" method="post">
            <table class='table table-hover table-responsive table-bordered'>
                <tr>
                    <td>Name</td>
                    <td><input type='text' name='name' value="<?php echo htmlspecialchars($name, ENT_QUOTES);  ?>" class='form-control' /></td>
                </tr>
                <tr>
                    <td>Price</td>
                    <td><input type='text' name='price' value="<?php echo htmlspecialchars($price, ENT_QUOTES);  ?>" class='form-control' /></td>
                </tr>
                <tr>
                    <td>Description</td>
                    <td><textarea name='description' class='form-control'><?php echo htmlspecialchars($description, ENT_QUOTES);  ?></textarea></td>
                </tr>
                <tr>
                    <td>Content</td>
                    <td><textarea name='content' class='form-control'><?php echo htmlspecialchars($content, ENT_QUOTES);  ?></textarea></td>
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
                        <input type='submit' value='Save Changes' class='btn btn-primary' />
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