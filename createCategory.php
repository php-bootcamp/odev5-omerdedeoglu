<!DOCTYPE HTML>
<html>

<head>
    <title>Create a Record</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />


</head>

<body>
    <div class="container">

        <div class="page-header">
            <h1>Create Category</h1>
        </div>
        <!-- Insert process -->
        <?php
        if ($_POST) {
            if (!empty($_POST['name'])) {
                // include database connection
                include 'config/database.php';
                $value = $_POST['name'];
                $isExist = $con->query("SELECT * FROM categories WHERE name='{$value}'")->fetch();
                if (!$isExist) {
                    try {
                        $query = "INSERT INTO categories SET uniqid=:uniqid, name=:name";
                        $stmt = $con->prepare($query);

                        $uniqid = uniqid($prefix = "", $more_entropy = false);
                        $name = htmlspecialchars(strip_tags($_POST['name']));

                        $stmt->bindParam(':uniqid', $uniqid);
                        $stmt->bindParam(':name', $name);

                        if ($stmt->execute()) {
                            echo "<div class='alert alert-success'>Record was saved.</div>";
                        } else {
                            echo "<div class='alert alert-danger'>Unable to save record.</div>";
                        }
                    } catch (PDOException $exception) {
                        die('ERROR: ' . $exception->getMessage());
                    }
                } else {
                    echo "<div class='alert alert-danger'>Entered name is existing</div>";
                }
            } else {
                echo "<div class='alert alert-danger'>You must enter a name</div>";
            }
        }
        ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <table class='table table-hover table-responsive table-bordered col-lg-12'>
                <tr>
                    <td>Name</td>
                    <td><input type='text' name='name' class='form-control' /></td>
                </tr>
                <td></td>
                <td>
                    <input type='submit' value='Save' class='btn btn-primary' />
                    <a href='index.php' class='btn btn-danger'>Back to read products</a>
                </td>
                </tr>
            </table>
        </form>


        <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</body>

</html>