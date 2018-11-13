<?php
/**
 * Created by PhpStorm.
 * User: djtoryx
 * Date: 29.10.2018
 * Time: 21:05
 */

use PHPUnit\Framework\TestCase;

class AuthorizationTest extends TestCase
{
    /**
     * @var \App\Authorization
    */
    private $auth;
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject
    */
    private $user;
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject
     */
    private $cookie;

    public function setUp()
    {
        $this->auth = new \App\Authorization();
        $this->user = $this->getMockBuilder(\App\model\User::class)->setMethods(['save', 'getByName', 'verifyPassword', 'findByToken'])->getMock();
        $this->cookie = $this->createMock(\App\Cookie::class);
    }

    public function testSignInByPasswordNoUser()
    {
        $this->user->expects($this->never())->method('save');
        $this->cookie->expects($this->never())->method('setCookie');

        $this->user->method('getByName')->willReturn(false);
        $this->assertFalse($this->auth->signInByPassword('arg1','arg2', $this->user, $this->cookie));
    }

    public function testSignInByPasswordVerifyFailed()
    {
        $this->user->method('getByName')->willReturn(true);
        $this->user->method('verifyPassword')->willReturn(false);
        $this->assertFalse($this->auth->signInByPassword('arg1','arg2', $this->user, $this->cookie));
    }

    public function testSignInByPassword()
    {
        $this->user->method('getByName')->willReturn(true);
        $this->user->method('verifyPassword')->willReturn(true);
        $this->user->expects($this->once())->method('save');
        $this->cookie->expects($this->once())->method('setCookie')->with($this->equalTo('token'), $this->anything());
        $this->assertTrue($this->auth->signInByPassword('arg1','arg2', $this->user, $this->cookie));
    }

    public function testSignInByTokenNoToken()
    {
        $this->cookie->expects($this->once())->method('getCookie')->with($this->equalTo('token'))->willReturn("");
        $this->assertFalse($this->auth->signInByToken( $this->user, $this->cookie));
    }

    public function testSignInByTokenNoUser()
    {
        $this->cookie->expects($this->once())->method('getCookie')->with($this->equalTo('token'))->willReturn('something');
        $this->user->expects($this->once())->method('findByToken')->with($this->equalTo('something'))->willReturn(false);
        $this->assertFalse($this->auth->signInByToken( $this->user, $this->cookie));
    }

    public function testSignInByToken()
    {
        $this->cookie->expects($this->once())->method('getCookie')->with($this->equalTo('token'))->willReturn('something');
        $this->user->expects($this->once())->method('findByToken')->with($this->equalTo('something'))->willReturn(true);
        $this->assertTrue($this->auth->signInByToken( $this->user, $this->cookie));
    }

    public function testLogoutNoUser()
    {
        $this->assertFalse($this->auth->logout( null, $this->cookie));
    }

    public function testLogout()
    {
        $this->cookie->expects($this->once())->method('deleteCookie')->with($this->equalTo('token'));
        $this->user->expects($this->once())->method('save');
        $this->assertTrue($this->auth->logout( $this->user, $this->cookie));
    }
}