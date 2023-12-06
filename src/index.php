<?php

define('SERVER_NAME', 'TheFoundation Skeleton');
define('APPLICATION_PATH', './application/');

require_once './../TheFoundation/TheFoundation.php';

error_reporting(E_ALL ^ E_DEPRECATED);
ini_set('max_execution_time', 60);

use TheFoundation\PDOFactory;
use TheFoundation\Database\Entity;
use TheFoundation\RouterHttp;
use TheFoundation\RouterHttp\Response\Template;


$RouterHttp = new RouterHttp(new Template('./application/html/base_template.phtml', [
    'title' => SERVER_NAME,
    'content' => null,
]));

$RouterHttp->map('get', null, function() {
    $this->Response->send();
});

if ($RouterHttp->listen() != RouterHttp::LISTEN_FAILED)
    return;

// RouterHttp: admin
$RouterHttp = new RouterHttp(new Template('./application/html/admin/base_template.phtml', [
    'title' => SERVER_NAME,
    'content' => null,
    'menu' => jump('admin-menu.php'),
]));

$RouterHttp->map('get|post', 'admin', function() {
    $this->Response->Template->content = 'TheFoundation Skeleton - admin';
    $this->Response->send();
});

if ($RouterHttp->listen() != RouterHttp::LISTEN_FAILED)
    return;

// RouterHttp: handle error documents
$RouterHttp->map(404, null, function() {
    $this->Response->Template->content = '404 Not Found';
    $this->Response->send();
});
?>