<?php

namespace App\model;

use App\db\DBAdapter;

class Category extends baseModel
{
    protected function getId()
    {
        return $this->category_id;
    }

    protected function update(): bool
    {
        $sqlUpdate = "UPDATE category SET name=? WHERE category_id=?";
        $db = $this->getDbAdapter();
        return $db->prepareAndExecute($sqlUpdate, [$this->name, $this->getId()]);
    }

    protected function insert(): bool
    {
        $sqlInsert = "INSERT INTO category (name) VALUES (?)";
        $db = $this->getDbAdapter();
        return $db->prepareAndExecute($sqlInsert, [$this->name]);
    }

    public function delete(): bool
    {
        $sqlDelete = "DELETE FROM category WHERE category_id=? LIMIT 1";
        $db = $this->getDbAdapter();
        return $db->prepareAndExecute($sqlDelete, [$this->getId()]);
    }

    private function getProducts() : DBAdapter
    {
        $sql = "SELECT product.name, product.price FROM product JOIN product_category ON 
                  product.product_id=product_category.product_id WHERE product_category.category_id=?";
        $db = $this->getDbAdapter();
        $db->prepareAndExecute($sql, [$this->category_id]);
        return $db;
    }

    public function getProductsAsAssoc() : array
    {
        $db = $this->getProducts();
        $db->setFetchAssoc();
        return $db->fetchAll();
    }

    public function getProductsAsObjects() : array
    {
        $db = $this->getProducts();
        $products = [];
        $result = true;
        while ($result) {
            $product = $this->container->make(Product::class);
            $db->setFetchInto($product);
            $result = $db->fetch();
            if ($result) {
                $products[] = $product;
            }
        }
        return $products;
    }

    public function getByName(string $name)
    {
        $sql = "SELECT * FROM category WHERE name=? LIMIT 1";
        return $this->getByField($sql, [$name]);
    }

    protected function getById($id)
    {
        $sql = "SELECT * FROM user WHERE category_id=? LIMIT 1";
        return $this->getByField($sql, [$id]);
    }
}