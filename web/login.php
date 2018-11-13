<?php
require __DIR__ . "/../header.php";

use App\Authorization;

    $auth = $container->get(Authorization::class);
    if (!$auth->getIsGuest()){
        echo 'isntGuest';
        return;
    }
    if(!empty($_GET['name']) && !empty($_GET['password'])){
        $result = $auth->signInByPassword($_GET['name'], $_GET['password']);
        if ($result){
            echo "ok";
        }else{
            echo "fail";
        }
    }else{
        echo "clear";
    }

?>