<!DOCTYPE HTML>
<html>

<head>
    <title>Home Page</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />

    <style>
        .m-r-1em {
            margin-right: 1em;
        }

        .m-b-1em {
            margin-bottom: 1em;
        }

        .m-l-1em {
            margin-left: 1em;
        }

        .mt0 {
            margin-top: 0;
        }
    </style>

</head>

<body>

    <!-- container -->
    <div class="container">

        <div class="page-header">
            <h1>Read Products</h1>
        </div>
        <?php
        // include database connection
        include 'config/database.php';

        // delete message prompt
        $action = isset($_GET['action']) ? $_GET['action'] : "";

        // redirected from delete.php
        if ($action == 'deleted') {
            echo "<div class='alert alert-success'>Record was deleted.</div>";
        }

        // select all data
        $query = "SELECT uniqid, name, price, description, content, category FROM products ORDER BY uniqid DESC";
        $stmt = $con->prepare($query);
        $stmt->execute();

        // how to get number of rows returned
        $num = $stmt->rowCount();

        // link to create record forms
        echo "<a href='createProduct.php' class='btn btn-primary m-b-1em'>Create New Product</a>";
        echo "<a href='createCategory.php' class='btn btn-primary m-b-1em pull-right'>Create New Category</a>";

        //check if more than 0 record found
        if ($num > 0) {
            echo "<table class='table table-hover table-responsive table-bordered'>"; //start table

            //creating table heading
            echo "<tr>";
            echo "<th>Name</th>";
            echo "<th>Price</th>";
            echo "<th>Description</th>";
            echo "<th>Content</th>";
            echo "<th>Category</th>";
            echo "<th>Action</th>";
            echo "</tr>";

            // table body creating here by the loop
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                // instead of  $row['firstname']
                extract($row);

                // creating new table row per record
                echo "<tr>";
                echo "<td>{$name}</td>";
                echo "<td>{$price}</td>";
                echo "<td>{$description}</td>";
                echo "<td>{$content}</td>";
                echo "<td>{$category}</td>";
                echo "<td>";

                echo "<a href='update.php?uniqid={$uniqid}' class='btn btn-primary m-r-1em'>Edit</a>";

                echo "<a href='delete.php?uniqid={$uniqid}'  class='btn btn-danger'>Delete</a>";
                echo "</td>";
                echo "</tr>";
            }
            // end table
            echo "</table>";
        }
        // if no records found
        else {
            echo "<div class='alert alert-danger'>No records found.</div>";
        }
        ?>

        <a href='exportJson.php' class='btn btn-primary m-b-1em pull-right'>Export Json file</a>
        <form action="importJson.php" method="post" enctype="multipart/form-data">
            <strong style="color:red; font-size:large">Add a JSON File</strong><input type="file" name="jsonFile">
            <br>
            <input type="submit" class="btn btn-primary" value="Import" name="buttonImport">
        </form>

    </div> <!-- end .container -->

    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>


</body>

</html>