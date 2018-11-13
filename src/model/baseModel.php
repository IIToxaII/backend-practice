<?php

namespace App\model;

use App\db\DBAdapter;
use DI\Container;

abstract class baseModel
{
    protected function getDbAdapter() : DBAdapter
    {
        return $this->container->make(DBAdapter::class);
    }

    /**
     * @Inject
     * @var Container
     */
    protected $container;

    protected $isInDb = false;

    public function getIsInDb()
    {
        return $this->isInDb;
    }

    protected function getByField(string $sql, array $params)
    {
        $db = $this->getDbAdapter();
        $db->prepareAndExecute($sql, $params);
        $db->setFetchInto($this);
        if ($db->fetch()){
            $this->isInDb = true;
            return true;
        }
        return false;

    }

    public function save() : bool
    {
        if ($this->getIsInDb()) {
            return $this->update();
        }
        if ($this->insert()){
            $this->isInDb = true;
            return true;
        }
        return false;
    }

    public function getIsExist()
    {
    }

    abstract protected function insert() : bool;
    abstract protected function update() : bool;
    abstract public function delete() : bool;
    abstract protected function getById($id);
    abstract protected function getId();

}