<?php
// public/index.php
declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../app/Core/helpers.php';

use Bramus\Router\Router;
use App\Controllers\LoginController;
use App\Controllers\HomeController;
use App\Controllers\RegisterController;
use App\Controllers\NewGameController;
use App\Controllers\GameController;

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


//jeu


// get
$router->get('game', function() {
    $controller = new GameController();
    $controller->show();
});

//post
$router->post('game', function() {
    $controller = new GameController();
    $controller->register();
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



// 404

$router->set404(function() {
    header('HTTP/1.1 404 Not Found');
    echo "404 - Page introuvable";
});


$router->run();
