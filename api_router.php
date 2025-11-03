<?php


require_once 'libs/router/router.php';

require_once 'app/controler/Marcas.Controler.php';


$router = new Router();


/// MARCAS / brads
$router->addRoute('marcas',      'GET',      'MarcasControler',         'getBrands');
$router->addRoute('marcas/:id',      'GET',      'MarcasControler',         'getBrandById');

$router->addRoute('marcas/:id',      'DELETE',      'MarcasControler',         'removeBrend');
$router->addRoute('marcas/:id',      'POST',      'MarcasControler',         '');
$router->addRoute('marcas/:id',      'PUT',      'MarcasControler',         '');

/// VEHICULOS / 
$router->addRoute('vehiculos',      'GET',      'VehiculosControler',         'showHome');
$router->addRoute('vehiculos/:id',      'GET',      'VehiculosControler',         'showCarBrandById');

$router->addRoute('vehiculos/:id',      'DELETE',      'VehiculosControler',         '');
$router->addRoute('vehiculos',      'POST',      'VehiculosControler',         'addCarVehiculo');
$router->addRoute('vehiculos/:id',      'PUT',      'VehiculosControler',         '');





/// OTROS
$router->route($_GET['resource'], $_SERVER['REQUEST_METHOD']);
