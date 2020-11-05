<?php

$router = $di->getRouter();


//Get All Users
$router->add("/api/user",[
    "controller" => "Api",
    "action" => "getAllUsers"
])->via("GET");

//Get User By ID
$router->add("/api/user/{id:[0-9]+}",[
    "controller" => "Api",
    "action" => "getUserById"
])->via("GET");

//Register User
$router->add("/api/user/register",[
    "controller" => "User",
    "action" => "register"
])->via("POST");

//Login User
$router->add("/api/user/login",[
    "controller" => "User",
    "action" => "login"
])->via("POST");

$router->add("/api/user/edit/{id:[0-9]+}",[
    "controller" => "User",
    "action" => "edit"
])->via("POST");

$router->handle();
