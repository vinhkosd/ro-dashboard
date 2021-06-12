<?php
session_start();
require __DIR__.'/../vendor/autoload.php';
include 'config.php';
include 'global.php';
include 'routes.php';
include 'function.php';

foreach (glob(__DIR__."/../models/*.php") as $filename)
{//include models
    include $filename;
}
?>