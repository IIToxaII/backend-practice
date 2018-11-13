<?php
/**
 * Created by PhpStorm.
 * User: djtoryx
 * Date: 16.10.2018
 * Time: 18:58
 */

namespace App\model;

class Product extends baseModel
{
    protected function getId()
    {
        return $this->product_id;
    }

    protected function update(): bool
    {
        $sqlUpdate = "UPDATE product SET name=?, price=? WHERE product_id=?";
        $db = $this->getDbAdapter();
        return $db->prepareAndExecute($sqlUpdate, [$this->name, $this->price, $this->getId()]);
    }

    protected function insert(): bool
    {
        $sqlInsert = "INSERT INTO product (name, price) VALUES (?, ?)";
        $db = $this->getDbAdapter();
        return $db->prepareAndExecute($sqlInsert, [$this->name, $this->price]);
    }

    public function delete(): bool
    {
        $sqlDelete = "DELETE FROM product WHERE product_id=? LIMIT 1";
        $db = $this->getDbAdapter();
        return $db->prepareAndExecute($sqlDelete, [$this->getId()]);
    }

    public function getByName(string $name)
    {
        $sql = "SELECT * FROM product WHERE name=? LIMIT 1";
        return $this->getByField($sql, [$name]);
    }

    protected function getById($id)
    {
        $sql = "SELECT * FROM user WHERE product_id=? LIMIT 1";
        return $this->getByField($sql, [$id]);
    }
}