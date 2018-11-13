<?php
/**
 * Created by PhpStorm.
 * User: djtoryx
 * Date: 16.10.2018
 * Time: 17:24
 */

namespace App\model;

class User extends baseModel
{
    protected function getId()
    {
        return $this->user_id;
    }

    public function verifyPassword(string $password)
    {
        return password_verify($password, $this->password);
    }

    protected function update(): bool
    {
        $sqlUpdate = "UPDATE user SET name=?, access_token=? WHERE user_id=?";
        $db = $this->getDbAdapter();
        return $db->prepareAndExecute($sqlUpdate, [$this->name, $this->access_token, $this->user_id]);
    }

    protected function insert(): bool
    {
        $sqlInsert = "INSERT INTO user (name, password, access_token) VALUES (?, ?, ?)";
        $db = $this->getDbAdapter();
        return $db->prepareAndExecute($sqlInsert, [$this->name, $this->password, $this->access_token]);
    }

    public function delete(): bool
    {
        $sqlDelete = "DELETE FROM user WHERE user_id=? LIMIT 1";
        $db = $this->getDbAdapter();
        return $db->prepareAndExecute($sqlDelete, [$this->getId()]);
    }

    public function getByName(string $name)
    {
        $sql = "SELECT * FROM user WHERE name=? LIMIT 1";
        return $this->getByField($sql, [$name]);
    }

    public function findByToken(string $token)
    {
        $sql = "SELECT * FROM user WHERE access_token=? LIMIT 1";
        return $this->getByField($sql, [$token]);
    }

    protected function getById($id)
    {
        $sql = "SELECT * FROM user WHERE user_id=? LIMIT 1";
        return $this->getByField($sql, [$id]);
    }

}