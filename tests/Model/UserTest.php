<?php

use PHPUnit\Framework\TestCase;
use DI\Container;
use App\model\User;
use App\db\DBAdapter;

class UserTest extends TestCase
{
    /**
     * @var Container
    */
    private $container;

    private $user;

    public function setUp()
    {
        $containerBuild = new \DI\ContainerBuilder();
        $containerBuild->useAnnotations(true);
        $containerBuild->addDefinitions([
            DBAdapter::class => $this->createMock(DBAdapter::class),
        ]);
        $this->container = $containerBuild->build();

        $this->user = $this->getMockBuilder(User::class)->setMethods(['getIsInDb'])->getMock();
        $this->user->name = "Darth Vader";
    }

    public function testSaveInsertUser()
    {
        $this->user->method('getIsInDb')->willReturn(false);
        $this->container->get(DBAdapter::class)->expects($this->once())->method('prepareAndExecute')->with($this->stringStartsWith("INSERT"));
        $this->container->injectOn($this->user);
        $this->user->save();
    }

    public function testSaveUpdateUser()
    {
        $this->user->method('getIsInDb')->willReturn(true);
        $this->container->get(DBAdapter::class)->expects($this->once())->method('prepareAndExecute')->with($this->stringStartsWith("UPDATE"));
        $this->container->injectOn($this->user);
        $this->user->save();
    }
}