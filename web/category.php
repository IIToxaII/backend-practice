<?php

require __DIR__ . "/../header.php";
use App\db\DBAdapter;
use App\model\Category;

if (empty($_GET['name'])){
    $db = $container->get(DBAdapter::class);
    $sql = "SELECT * FROM category";
    $db->prepareAndExecute($sql, []);
    $db->setFetchAssoc();
    $categoryes = $db->fetchAll();
    echo json_encode($categoryes);
}else{
    $category = $container->make(Category::class);
    $category->getByName($_GET['name']);
    $products = $category->getProductsAsAssoc();
    echo json_encode($products);
}
?>