<?php
include 'config/database.php';

$proTable = $con->query("SELECT * FROM products");
$cateTable = $con->query("SELECT * FROM categories")->fetchAll(PDO::FETCH_KEY_PAIR);

$categoryIDs = array();
$length = count($cateTable);
$i = 0;


foreach ($cateTable as $name => $uniqid) {
    $categoryIDs[$uniqid] = [$name, $uniqid];
}


while ($row = $proTable->fetch(PDO::FETCH_ASSOC)) {
    extract($row);
    $export[] = [
        'uniqid' => $uniqid,
        'name' => $name,
        'price' => $price,
        'description' => $description,
        'content' => $content,
        'category' => [
            'uniqid' => $categoryIDs[$category][0],
            'category' => $category,
        ]
    ];
}


header("Content-Type: application/json");
//header("Content-Disposition: attachment; filename=products.json");
echo json_encode($export, JSON_PRETTY_PRINT);
header("refresh:10; url=index.php");
// This page will redirect you index.php to After 10 secound later!</h1>";
