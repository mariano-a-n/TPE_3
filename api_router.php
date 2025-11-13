<?php


require_once 'libs/router/router.php';
require_once 'app/controler/Vehiculos.Controler.php';
require_once 'app/controler/Marcas.Controler.php';


$router = new Router();


/// MARCAS / brads
$router->addRoute('marcas',          'GET',      'MarcasControler',         'getBrands');
$router->addRoute('marcas/:id',      'GET',      'MarcasControler',         'getBrandById');

$router->addRoute('marcas',          'POST',     'MarcasControler',         '');
$router->addRoute('marcas/:id',      'PUT',      'MarcasControler',         '');
$router->addRoute('marcas/:id',      'DELETE',   'MarcasControler',         'removeBrend');

/// VEHICULOS /
$router->addRoute('vehiculos',        'GET',      'VehiculosControler',     'showHome');
$router->addRoute('vehiculos/:id',    'GET',      'VehiculosControler',     'showCarBrandById');

$router->addRoute('vehiculos',        'POST',     'VehiculosControler',     'postCar');
$router->addRoute('vehiculos/:id',    'PUT',      'VehiculosControler',     'putCar');
$router->addRoute('vehiculos/:id',    'PATCH',    'VehiculosControler',     'patchCar');
$router->addRoute('vehiculos/:id',    'DELETE',   'VehiculosControler',     'deleteCar');


/// OTROS
$router->route($_GET['resource'], $_SERVER['REQUEST_METHOD']);
