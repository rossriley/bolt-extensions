<?php
use Aura\Router\RouterFactory;


$router_factory = new RouterFactory;
$router = $router_factory->newInstance();

/******* Main Page Routes ************/
$router->add("home", "/")->setValues(['action'=>'Bolt\Extensions\Action\Home']);
$router->add("submit", "/submit")->setValues(['action'=>'Bolt\Extensions\Action\Submit']);
$router->add("submitted", "/submitted")->setValues(['action'=>'Bolt\Extensions\Action\Submitted']);

$router->add("register", "/register")->setValues(['action'=>'Bolt\Extensions\Action\Register']);
$router->add("admin", "/admin")->setValues(['action'=>'Bolt\Extensions\Action\Admin']);
$router->add("login", "/login")->setValues(['action'=>'Bolt\Extensions\Action\Login']);
$router->add("logout", "/logout")->setValues(['action'=>'Bolt\Extensions\Action\Logout']);
$router->add("profile", "/profile")->setValues(['action'=>'Bolt\Extensions\Action\Profile']);
$router->add("update", "/update/{package}")->setValues(['action'=>'Bolt\Extensions\Action\UpdatePackage']);
$router->add("edit", "/edit/{package}")->setValues(['action'=>'Bolt\Extensions\Action\EditPackage']);


$router->add("search", "/search")->setValues(['action'=>'Bolt\Extensions\Action\Search']);
$router->add("list", "/list.json")->setValues(['action'=>'Bolt\Extensions\Action\ListPackages']);

$router->add("install", "/{package}/install.json")->setValues(['action'=>'Bolt\Extensions\Action\Ping','id'=>'install']);
$router->add("uninstall", "/{package}/uninstall.json")->setValues(['action'=>'Bolt\Extensions\Action\Ping','id'=>'uninstall']);
$router->add("star", "/{package}/star.json")->setValues(['action'=>'Bolt\Extensions\Action\Ping','id'=>'star']);


return $router;
