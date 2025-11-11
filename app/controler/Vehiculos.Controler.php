<?php 
    include_once 'app/models/Vehiculos.model.php';
    include_once 'app/models/Marcas.model.php';

    class VehiculosControler {
        private $model;
        private $modelMarca;
        private $params;

        function __construct(){
            $this->params = (object) $_GET;
            $this->model = new ModelVehiculos();
            $this->modelMarca =  new ModelMarcas();
        }

        // ==== HOME ====
        // function showHomeUser($request) {
        //     $modelos = $this->model->getCarModel();
        //     $this->veiw->showTaksVehiculosUser($modelos, $request->user);
        // }
        
        function showHome($req, $res) {
            $vehiculos = $this->model->getCarModel();
            if(!$vehiculos){
              return $res->json("Error", 404); // no se ha encontrado
            }

            // valores por defecto
            $sort = 'id';
            $order = 'ASC';
            
            if (isset($req->query->sort)) {
                $sort = $req->query->sort;
            }
    
            if (isset($req->query->order)) {
                $order = strtoupper($req->query->order);
            }

            $vehiculos = $this->model->getCarsOrderedByPrecio($sort, $order);

            // var_dump($req, $res);
            // die();
            return $res->json($vehiculos, 200); // ok
        }

        // ==== VEHÍCULOS ====
        function showCarBrandById($req, $res) {
            $id = $req->params->id;
            $vehiculo = $this->model-> getCarById($id);

            if (!$vehiculo) {
                return $res->json("El vehiculo con el id=$id no existe", 404); // no se ha encontrado
            }
            return $res->json($vehiculo, 200); // ok
        }

        function showCarDetails($id) {
            $modelos = $this->model->getCarModel($id);

        }

        function orderCarByPrecio($req, $res) {
            $order = $req->params->order ?? 'ASC';
            $modelos = $this->model->getCarsOrderedByPrecio($order, $req);

            if (empty($modelos)) {
                return $res->json("No se encontraron vehículos", 404); // no se ha encontrado
            }

            return $res->json($modelos);
        }

        function addCarVehiculo($req, $res) {
            $id_marca = (int) $req->body->id_marca;
            $marca = $this->modelMarca->getCarBrandById($id_marca);
    
            if (!$marca) {
                return $res->json('la marca seleccionada no existe .', 404 );
            }
            
            // agrego el auto
            $datos = $this->validarDatos($req, $res);
            $NuevoVehiculo = $this->model->insertCar(
                $datos['id_marca'],
                $datos['marca'],
                $datos['modelo'],
                $datos['anio'],
                $datos['km'],
                $datos['precio'],
                $datos['patente'],
                $datos['es_nuevo'],
                $datos['imagen']
            );
            
            
            // if (!empty($req->body->vendido) || ($req->body->vendido == 1)) {
            //     return $res->json('error El vehículo no puede registrarse como vendido al crearse.', 401); // no autorizado
            // }
                        
            return $res->json($NuevoVehiculo, 201); // creado
        }

        function refreshCar($req, $res) { // PUT
            $id = $req->params->id;
            $modelo = $this->model->getCarById($id);
            
            if (!$modelo) {
                return $res->json("Vehículo con id=$id no encontrado", 404); // no se ha encontrado
            }

            // actualizo el auto
            $datos = $this->validarDatos($req, $res);
            $this->model->updateModelCar(
                $datos['id_marca'],
                $datos['marca'],
                $datos['modelo'],
                $datos['anio'],
                $datos['km'],
                $datos['precio'],
                $datos['patente'],
                $datos['es_nuevo'],
                $datos['imagen'],
                $id
            );

            // obtengo auto modificado y devuelvo la respuesta
            $modelo = $this->model->getCarById($id);
            return $res->json("El vehículo id=$id actualizado con éxito", 202); // aceptado
        }

        function usedCars($id) {
            $modelos = $this->model->getCarModel();
            
        }

        function newCars($id) {
            $modelos = $this->model->getCarModel();
            
        }

        // ==== ACCIONES ====
        function sellCar($id) {
            $this->model->updateCar($id);
            // header("Location: " . BASE_URL . "modelos");
        }

        function deleteCar($req, $res) {
            $id = $req->params->id;
            $modelo = $this->model->getCarById($id);

            if (!$modelo) {
                return $res->json("El vehículo con el id=$id no existe, 404");
            }

            $this->model->removeCar($id);

            return $res->json("El vehículo con el id=$id se eliminó con éxito");
        }
        
        function validarDatos($req, $res) {
            if (empty($req->body->id_marca) || !isset($req->body->id_marca)) {
                return $res->json('Faltan datos', 400); // bad request
            }

            if (empty($req->body->marca) || !isset($req->body->marca)) {
                return $res->json('Falta la marca', 400);
            }
            
            if (empty($req->body->modelo) || !isset($req->body->modelo)) {
                return $res->json('Falta el modelo', 400);
            }

            if (empty($req->body->anio) || !isset($req->body->anio)) {
                return $res->json('Falta el año', 400);
            }

            if (!isset($req->body->km)) {
                return $res->json('Faltan los kilómetros', 400);
            }
            
            if (empty($req->body->precio) || !isset($req->body->precio)) {
                return $res->json('Falta el precio', 400);
            }

            if (!isset($req->body->patente)) {
                return $res->json('Falta la patente', 400);
            }

            if (empty($req->body->imagen) || !isset($req->body->imagen)) {
                return $res->json('Falta la imagen', 400);
            }

            $id_marca = $req->body->id_marca;
            $marca = trim($req->body->marca);
            $modelo = trim($req->body->modelo);
            $anio = (int) $req->body->anio;
            $km = (int) $req->body->km;
            $precio = (float) $req->body->precio;

            //strtoupper hece que todo el txt se vuelva en mayusculas
            $patente = strtoupper(trim($req->body->patente));

            $imagen = trim($req->body->imagen);

            // Campos opcionales es nuevo por default en la tabla siempre es nuevo
            if (isset($req->body->es_nuevo)) {
                $es_nuevo = (int) $req->body->es_nuevo;
            } else {
                $es_nuevo = 0;
            }
            // patente
            if (empty($req->body->$patente)) {
                $patente == null;
            }
            // comprobar si no tiene kilometros es nuevo
            if ($km <= 0) {
                $es_nuevo = 1;
            }
            //comprobacion de logica  si es nuevo no puede tener mas de 0 km
            if ($es_nuevo == 1 && $km > 0) {
                return $res->json('error: Un vehículo nuevo no puede tener kilómetros.', 400);
            }
            //
            if ($es_nuevo == 0 && $km <= 0) {
                return $res->json('error: El vehiculo es usado pero tiene 0 km.', 400);
            }
            // comprobacion de marca con el ID
            $objetoMarca = $this->modelMarca->getCarBrandByName($marca);
            if (!$objetoMarca) {
                return $res->json('Esa marca no existe', 400);
            }
            if ($id_marca != $objetoMarca->id) {
                return $res->json('Marca no coincide con ID', 400);
            }

            // Si todo está bien, devolvemos los datos procesados
            return [
                'id_marca' => $id_marca,
                'marca' => $marca,
                'modelo' => $modelo,
                'anio' => $anio,
                'km' => $km,
                'precio' => $precio,
                'patente' => $patente,
                'imagen' => $imagen,
                'es_nuevo' => $es_nuevo
            ];

        }

    }
    
?>
