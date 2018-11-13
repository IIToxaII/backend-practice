<?php

namespace App;

use App\model\User;
use DI\Container;

class Authorization
{
    private $user = null;

    /**
     * @Inject
     * @var Container
    */
    private $container;

    public function __construct(Container $container = null)
    {
        $this->container = $container;
    }

    public function getIsGuest()
    {
        return !isset($this->user);
    }

    public function getUser()
    {
        return $this->user;
    }

    public function logout(User $user = null, Cookie $cookie = null) : bool
    {
        if (isset($user)){
            $this->user = $user;
        }

        if ($this->getIsGuest()){
            return false;
        }

        $this->user->access_token = '';
        $this->user->save();
        $this->user = null;
        $cookie->deleteCookie('token');
        return true;
    }

    public function signInByToken(User $user = null, Cookie $cookie = null) : bool
    {
        if (is_null($cookie)){
            $cookie = $this->container->get(Cookie::class);
        }

        $token = $cookie->getCookie('token');
        if (!isset($token)){
            $this->user = null;
            return false;
        }

        if (is_null($user)){
            $user = $this->container->make(User::class);
        }

        if ($user->findByToken($token)) {
            $this->user = $user;
            return true;
        }
        return false;
    }

    public function signInByPassword(string $name, string $password, User $user = null, Cookie $cookie = null) : bool
    {
        if (is_null($user)){
            $user = $this->container->make(User::class);
        }
        if (is_null($cookie)){
            $cookie = $this->container->get(Cookie::class);
        }

        if (!$user->getByName($name)){
            return false;
        }
        if ($user->verifyPassword($password)){
            $token = bin2hex(random_bytes(64));
            $cookie->setCookie('token', $token);
            $user->access_token = $token;
            $this->user = $user;
            $user->save();
            return true;
        }
        return false;
    }

}