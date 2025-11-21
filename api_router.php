<?php


require_once 'libs/router/router.php';

require_once './libs/jwt/jwt.middleware.php';
require_once './app/middlewares/guard-api.middleware.php';

require_once './app/controler/Marcas.Controler.php';
require_once './app/controler/Vehiculos.Controler.php';
require_once './app/controler/user.controler.php';


$router = new Router();
$router->addMiddleware(new JWTMiddleware());

$router->addRoute('auth/login',     'GET',     'AuthApiController',    'login');


$router->addRoute('marcas',      'GET',      'MarcasControler',         'getBrands');
$router->addRoute('marcas/:id',      'GET',      'MarcasControler',         'getBrandById');

$router->addRoute('vehiculos',      'GET',      'VehiculosControler',         'showHome');
$router->addRoute('vehiculos/:id',      'GET',      'VehiculosControler',         'showCarBrandById');

$router->addMiddleware(new GuardMiddleware());

// /// MARCAS / brads

$router->addRoute('marcas/:id',      'DELETE',      'MarcasControler',         'removeBrend');
$router->addRoute('marcas',      'POST',      'MarcasControler',         'insertBrand');
$router->addRoute('marcas/:id',      'PUT',      'MarcasControler',         'update');


/// VEHICULOS / 

$router->addRoute('vehiculos/:id',      'DELETE',      'VehiculosControler',         'deletCar');
$router->addRoute('vehiculos',      'POST',      'VehiculosControler',         'addCarVehiculo');
$router->addRoute('vehiculos/:id',      'PUT',      'VehiculosControler',         'putCar');
$router->addRoute('vehiculos/:id',    'PATCH',    'VehiculosControler',     'patchCar');



/// OTROS
$router->route($_GET['resource'], $_SERVER['REQUEST_METHOD']);
