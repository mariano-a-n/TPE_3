<?php
    include_once 'app/models/Vehiculos.model.php';
    include_once 'app/models/Marcas.model.php';

    class VehiculosControler {
        private $model;
        private $modelMarca;
        private $params;

        function __construct(){
            // $this->params = (object) $_GET;
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
            if (empty($vehiculos)){
              return $res->json([ // array asociativo para el error
                "error"=>true,
                "message"=>"No hay modelos de vehículos cargados"], 404); // no se ha encontrado
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
            return $res->json([
                "error"=>false,
                "data"=>$vehiculos
            ], 200); // ok
        }

        // ==== VEHÍCULOS ====
        function showCarBrandById($req, $res) {
            $id = $req->params->id;
            $vehiculo = $this->model->getCarById($id);

            if (!$vehiculo) {
                return $res->json([
                    "error" => true,
                    "message" => "El vehiculo con el id=$id no existe"
                ], 404); // no se ha encontrado
            }
            
            return $res->json([
                "error"=>false,
                "data"=>$vehiculo
            ], 200); // ok
        }

                ///// POST //////
        function postCar($req, $res) {
            $id_marca = (int) $req->body->id_marca;
            $marca = $this->modelMarca->getCarBrandById($id_marca);
    
            if (empty($marca)) {
                return $res->json([
                    "error" => true,
                    "message" => "Esa marca no existe"
                ], 404);
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
            return $res->json([
                "error" => false,
                "message" => "Vehículo agregado con éxito",
                "data" => "id=$NuevoVehiculo"
            ], 201); // creado
        }
                ////// PUT //////
        function putCar($req, $res) {
            $id = $req->params->id;
            $modelo = $this->model->getCarById($id);
            
            if (empty($modelo)) {
                return $res->json([
                    "error" => true,
                    "message" => "Vehículo con id=$id no encontrado"
                ], 404); // no se ha encontrado
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
            return $res->json([
                "error" => false,
                "message" => "El vehículo id=$id actualizado con éxito",
                "data" => $modelo
            ], 200);
        }

                ///// PATCH //////
        function patchCar($req, $res) {
            $id = $req->params->id;
            $modelo = $this->model->getCarById($id);
            $input = json_decode(file_get_contents('php://input'), true);
            // file_get_contents('php://input') lee el contenido bruto del cuerpo HTTP
            // json_decode convierte contenido JSON en un array asociativo
            
            if (empty($modelo)) {
                return $res->json([
                    "error" => true,
                    "message" => "Vehículo con id=$id no encontrado"
                ], 404); // no se ha encontrado
            }
            
            $allowedFields = ['marca', 'modelo', 'anio', 'km', 'precio', 'patente', 'imagen', 'vendido'];
            $data = [];

            foreach ($input as $field => $value) {
                if (in_array($field, $allowedFields)) {
                    $data[$field] = $value;
                }
            }

            if (empty($data)) {
                return $res->json([
                    "error" => true,
                    "message" => "No se enviaron campos válidos"
                ]);
            }

            $set = [];
            $params = [];
            foreach ($data as $field => $value) {
                $set[] = "$field = ?";
                $params[] = $value;
            }
            $params[] = $id;
            $this->model->patchField($set, $params);
            $modeloActualizado = $this->model->getCarById($id);

            return $res->json([
                "error" => false,
                "message" => "Se ha actualizado el campo del vehículo con id=$id",
                "data" => $modeloActualizado
            ], 200);
            
        }

            //// DELETE /////
        function deleteCar($req, $res) {
            $id = $req->params->id;
            $modelo = $this->model->getCarById($id);

            if (!$modelo) {
                return $res->json([
                    "error" => true,
                    "message" => "El vehículo con el id=$id no existe"
                ], 404);
            }
            $this->model->removeCar($id);

            return $res->json([
                "error" => false,
                "message" => "El vehículo con el id=$id se eliminó con éxito",
                "data" => $modelo
            ], 200);
        }
        
        function usedCars() {
            $modelos = $this->model->getCarModel();
            
        }

        function newCars() {
            $modelos = $this->model->getCarModel();
            
        }

        // ==== ACCIONES ====
        function sellCar($id) {
            $this->model->updateCar($id);
            // header("Location: " . BASE_URL . "modelos");
        }

        
        function validarDatos($req, $res) {
            $body = $req->body;

            if (!isset($body->id_marca) || $body->id_marca === '') {
                return $res->json('Faltan datos: id_marca', 400);
            }

            if (empty($body->marca)) {
                return $res->json('Falta la marca', 400);
            }

            if (empty($body->modelo)) {
                return $res->json('Falta el modelo', 400);
            }

            if (empty($body->anio)) {
                return $res->json('Falta el año', 400);
            }

            if (!isset($body->km)) {
                return $res->json('Faltan los kilómetros', 400);
            }

            if (!isset($body->precio)) {
                return $res->json('Falta el precio', 400);
            }

            if (!isset($body->patente)) {
                return $res->json('Falta la patente', 400);
            }

            if (empty($body->imagen)) {
                return $res->json('Falta la imagen', 400);
            }

            $id_marca = $body->id_marca;
            $marca = trim($body->marca);
            $modelo = trim($body->modelo);
            $anio = (int) $body->anio;
            $km = (int) $body->km;
            $precio = (float) $body->precio;

            //strtoupper hece que todo el txt se vuelva en mayusculas
            $patente = strtoupper(trim($body->patente));

            $imagen = trim($body->imagen);

            // Campos opcionales es nuevo por default en la tabla siempre es nuevo
            if (isset($body->es_nuevo)) {
                $es_nuevo = (int) $body->es_nuevo;
            } else {
                $es_nuevo = 0;
            }
            // patente
            if (empty($body->$patente)) {
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
