<?php 
    include_once 'app/models/Vehiculos.model.php';
    include_once 'app/models/Marcas.model.php';

    class VehiculosControler {
        private $model;
        private $modelMarca;

        function __construct(){
            $this->model = new ModelVehiculos();
            $this->modelMarca =  new ModelMarcas();
        }

        // ==== HOME ====
        // function showHomeUser($request) {
        //     $modelos = $this->model->getCarModel();
        //     $this->veiw->showTaksVehiculosUser($modelos, $request->user);
        // }

        function showHome($req, $res) {
            if (isset($req->query->marca)) {

                $marca = (int)$req->query->marca;

                $modelos = $this->model->getCarModel();

            }else{
                $modelos = $this->model->getCarModel();

                
            }
            return $res->json($modelos);
        }

        // ==== VEHÍCULOS ====
        function showCarBrandById($req, $res) {
            $id = $req->params->id;
            $vehiculo = $this->model-> getCarById($id);

            if (!$vehiculo) {
                return $res->json("el vehiculo con el id=$id no existe", 404);
            }
            return $res->json($vehiculo, 200);
        }

        function showCarDetails($id) {
            $modelos = $this->model->getCarModel();
            
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
            header("Location: " . BASE_URL . "modelos");
        }

        function eraseCar($id) {
            $this->model->deleteCar($id);
            header("Location: " . BASE_URL . "modelos");
        }


        function addCarVehiculo($req, $res) {

            //comprubo los datos

            if (empty($req->body->id_marca) || !isset($req->body->id_marca)) {
            return $res->json('Faltan datos', 400);
            }
            
            if (empty($req->body->modelo) || !isset($req->body->modelo)) {
            return $res->json('Faltan datos', 400);
            }

            if (empty($req->body->anio) || !isset($req->body->anio)) {
            return $res->json('Faltan datos', 400);
            }

            if (empty($req->body->km) || !isset($req->body->km)) {
            return $res->json('Faltan datos', 400);
            }
            
            
            if (empty($req->body->precio) || !isset($req->body->precio)) {
            return $res->json('Faltan datos', 400);
            }

            if (empty($req->body->patente) || !isset($req->body->patente)) {
            return $res->json('Faltan datos', 400);
            }

            if (empty($req->body->imagen) || !isset($req->body->imangen)) {
            return $res->json('Faltan datos', 400);
            }

            $id_marca = (int) $req->body->id_marca;
            $marca = $this->modelMarca->getCarBrandById($id_marca);

            if (!$marca) {
                return $res->json('la marca seleccionada no existe .', 404 );
            }

            // el trim quita los espacion antes y despues del txt.
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

            //comprovacion de logica  si es nuevo no puede tener mas de 0 km
            if ($es_nuevo == 1 && $km > 0) {
            return $res->json('error: Un vehículo nuevo no puede tener kilómetros.', 400);
            }
            //
            if ($es_nuevo == 0 && $km <= 0) {
            return $res->json('error: El vehiculo es usado pero tiene 0 km .', 400);
            }

            //comprobacion de la marca
            

            if (!empty($req->body->vendido) || ($req->body->vendido == 1)) {
                return $res->json('error El vehículo no puede registrarse como vendido al crearse.', 400);
            }
            
            $NuevoVehiculo = $this->model->insertCar($id_marca,$modelo,$anio,$km,$precio,$patente,$es_nuevo,$imagen);

            return $res->json($NuevoVehiculo,201);
        }

    }
    
?>
