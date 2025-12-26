<?php
// public/index.php

session_start();

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../app/Core/helpers.php';

use Bramus\Router\Router;
use App\Controllers\LoginController;
use App\Controllers\HomeController;
use App\Controllers\RegisterController;
use App\Controllers\NewGameController;
use App\Controllers\GameController;
use App\Controllers\ProfileController;

$router = new Router();

$router->setBasePath('/DungeonXplorer/public');

// login

// get
$router->get('/login', function() {
    $controller = new LoginController();
    $controller->show(); //affichage quand c 'est get
});

// post
$router->post('/login', function() {
    $controller = new LoginController();
    $controller->login(); // traitement quand c 'est post
});



//register 

// get
$router->get('/register', function() {
    $controller = new RegisterController();
    $controller->show();
});

// post
$router->post('/register', function() {
    $controller = new RegisterController();
    $controller->register();
});

// accueil

$router->get('/', function() {
    $controller = new HomeController();
    $controller->index(); 
});



//new game

// get
$router->get('new-game', function() {
    $controller = new NewGameController();
    $controller->show();
});

//post
$router->post('new-game', function() {
    $controller = new NewGameController();
    $controller->create();
});







//game

// get
$router->get('game', function() {
    $controller = new GameController();
    $controller->show();
});

//post
$router->post('game', function() {
    $controller = new GameController();
    $controller->postGame();
});

//profile
$router->get('/profile', function() {
    $controller = new ProfileController();
    $controller->show();
});

$router->post('/profile', function() {
    $controller = new ProfileController();
    $controller->update();
});

// Save combat result
$router->post('/save-combat', function() {
    $controller = new GameController();
    $controller->saveCombat();
});

//logout
$router->get('/logout', function() {
    session_destroy();
    header('Location: /DungeonXplorer/public/login');
    exit;
});     

// 404
$router->set404(function() {
    header('HTTP/1.1 404 Not Found');
    echo "404 - Page introuvable";
});

$router->run();