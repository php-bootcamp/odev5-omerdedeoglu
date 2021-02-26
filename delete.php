<?php
include 'config/database.php';

try {

    // isset() is a PHP function used to verify if a value is there or not
    $uniqid = isset($_GET['uniqid']) ? $_GET['uniqid'] : die('ERROR: Record UniqID not found.');

    // delete query
    $query = "DELETE FROM products WHERE uniqid = ?";
    $stmt = $con->prepare($query);
    $stmt->bindParam(1, $uniqid);

    if ($stmt->execute()) {
        header('Location: index.php?action=deleted');
    } else {
        die('Unable to delete record.');
    }
}

// show error
catch (PDOException $exception) {
    die('ERROR: ' . $exception->getMessage());
}
