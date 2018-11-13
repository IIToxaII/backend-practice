<?php
require __DIR__ . "/vendor/autoload.php";
$config = require_once __DIR__ . "/config/config.php";

use App\Authorization;
use App\db\DBConfig;
use App\db\DB;

$db = $config['testing'] ? $config['testDb'] : $config['db'];

$containerBuild = new \DI\ContainerBuilder();
$containerBuild->useAnnotations(true);
$containerBuild->addDefinitions([
   DB::class => new DB(new DBConfig($db))
]);
$container = $containerBuild->build();

$container->get(Authorization::class)->signInByToken();

?>