<?php

if (isset($_POST['buttonImport']) && !empty($_FILES)) {
    include 'config/database.php';

    $productStmt = $con->query("SELECT * FROM products")->fetchAll();
    $categoryStmt = $con->query('SELECT * FROM categories')->fetchAll();
    // This function convert to Array from stdobject
    function objectToArray($d)
    {
        if (is_object($d)) {
            $d = get_object_vars($d);
        }

        if (is_array($d)) {

            return array_map(__FUNCTION__, $d);
        } else {

            return $d;
        }
    }

    copy($_FILES['jsonFile']['tmp_name'], 'jsonFiles/' . $_FILES['jsonFile']['name']);
    $data = file_get_contents('jsonFiles/' . $_FILES['jsonFile']['name']);
    $products = json_decode($data);
    $newArray = objectToArray($products);

    foreach ($newArray as $product) {
        $stmtAllPro = ('SELECT * FROM products WHERE uniqid=:uniqid  LIMIT 0,1');
        $stmt = $con->prepare($stmtAllPro);
        $stmt->bindParam('uniqid', $product['uniqid']);
        $stmt->execute();
        $result = $stmt;

        if (!$result) {
            $updateProduction = $con->query("UPDATE products SET name=:name, price=:price, description=:description, content=:content, category=:category WHERE uniqid=:uniqid LIMIT 0,1");
            $stmt = $con->prepare($updateProduction);
            $stmt->bindParam('uniqid', $product['uniqid']);


            $name = $product['name'];
            $price = $product['price'];
            $description = $product['description'];
            $content = $product['content'];
            $category = $product['category']['name'];

            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':price', $price);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':content', $content);
            $stmt->bindParam(':category', $category);

            $stmt->execute();
        } else {
            $query = "INSERT INTO products SET uniqid=:uniqid, name=:name, price=:price, description=:description, content=:content, category=:category";
            $stmt = $con->prepare($query);

            $uniqid = uniqid($prefix = "", $more_entropy = false);
            $name = $product['name'];
            $price = $product['price'];
            $description = $product['description'];
            $content = $product['content'];
            $category = $product['category']['name'];

            $stmt->bindParam(':uniqid', $uniqid);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':price', $price);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':content', $content);
            $stmt->bindParam(':category', $category);

            $stmt->execute();
        }

        $stmtAllCat = $con->query('SELECT * FROM categories WHERE uniqid=:uniqid');
        $stmt = $con->prepare($stmtAllCat);
        $stmt->bindParam('uniqid', $product['category']['uniqid']);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $updateCategory = $con->query("SELECT name =:name FROM categories WHERE uniqid =:uniqid LIMIT 0,1");
            $stmt = $con->prepare($updateCategory);

            $stmt->bindParam(':name', $product['category']['name']);

            $stmt->execute();
        } else {
            $query = "INSERT INTO categories SET uniqid=:uniqid, name=:name";
            $stmt = $con->prepare($query);

            $uniqid = uniqid($prefix = "", $more_entropy = false);
            $name = $product['name'];

            $stmt->bindParam(':uniqid', $uniqid);
            $stmt->bindParam(':name', $name);

            $stmt->execute();
        }
    }
}
