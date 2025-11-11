<?php


require_once 'libs/router/router.php';
require_once 'app/controler/Vehiculos.Controler.php';
require_once 'app/controler/Marcas.Controler.php';


$router = new Router();


/// MARCAS / brads
$router->addRoute('marcas',          'GET',      'MarcasControler',         'getBrands');
$router->addRoute('marcas/:id',      'GET',      'MarcasControler',         'getBrandById');

$router->addRoute('marcas/:id',      'DELETE',   'MarcasControler',         'removeBrend');
$router->addRoute('marcas',          'POST',     'MarcasControler',         '');
$router->addRoute('marcas/:id',      'PUT',      'MarcasControler',         '');

/// VEHICULOS /
$router->addRoute('vehiculos',        'GET',      'VehiculosControler',     'showHome');
$router->addRoute('vehiculos/:id',    'GET',      'VehiculosControler',     'showCarBrandById');

$router->addRoute('vehiculos/:id',    'DELETE',   'VehiculosControler',     'deleteCar');
$router->addRoute('vehiculos',        'POST',     'VehiculosControler',     'addCarVehiculo');
$router->addRoute('vehiculos/:id',    'PUT',      'VehiculosControler',     'refreshCar');





/// OTROS
$router->route($_GET['resource'], $_SERVER['REQUEST_METHOD']);
