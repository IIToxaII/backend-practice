<?php
require __DIR__ . "/../header.php";

use App\Authorization;

Authorization::$auth->logout();
header('Location: index.php');
?>