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

        function showHome($req, $res) {
            //mariano-dev
            $parametros = $this->comprobacionDeQuerysParams($req,$res);

            // si devuelve null, hay error
            if ($parametros === null) {
                return $res->json("Parámetros inválidos o inexistentes.", 400);
            }

            //valores por defecto
            $pagina = isset($req->query->pagina) ? (int)$req->query->pagina : 1;
            $limite = isset($req->query->limite) ? (int)$req->query->limite : 5;

            if ($pagina < 1){
                $pagina = 1;
            } 
            if ($limite < 1){ 
                $limite = 5;
            }

            // si viene un filtro → contar según filtro
            if (!empty($req->query) && !empty($parametros->marcas)) {
                $filtro = $parametros->marcas;
                $totalRegistros = $this->model->contarVehiculosPorMarca($filtro);
            } else {
                // sin filtros → contar todo
                $totalRegistros = $this->model->contarVehiculos();
            }
            
            ///el ceil es una función de PHP que redondea un número hacia arriba al entero más cercano, es como la funcion MAHT. de java.
            $totalPaginas = ceil($totalRegistros / $limite);

            // si se pasa del número máximo de páginas, error
            if ($pagina > $totalPaginas) {
                return $res->json("La página $pagina no existe. Solo hay $totalPaginas páginas disponibles.", 400);
            }

            $offset = ($pagina - 1) * $limite;


            // si no pasaron ningún parámetro, traer todos
            if (empty($req->query)) {
                $modelos = $this->model->getCarModel($limite,$offset);
            } else {
                $filtro = $parametros->marcas;
                $sort = $parametros->sorts;
                $order = $parametros->orders;
                $modelos = $this->model->getCarModels($filtro, $sort, $order,$limite,$offset);
            }
            // respuesta con info de paginación
            $respuesta = [
                'pagina_actual' => $pagina,
                'total_paginas' => $totalPaginas,
                'total_registros' => $totalRegistros,
                'vehiculos' => $modelos
            ];

            return $res->json($respuesta,200);
        }

        // ==== VEHÍCULOS ====
        function showCarBrandById($req, $res) {
            $id = $req->params->id;
            $vehiculo = $this->model-> getCarById($id);

            if (!$vehiculo) {
                return $res->json("el vehiculo con el id= $id no existe", 404);
            }
            return $res->json($vehiculo, 200);
        }

        /// funcion editar
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
            

            if ($datos == null) {
                return $res->json(["error" => false,
                "message" => "Parámetros inválidos o inexistentes."], 400);
            }

            $this->model->updateModelCar(
                $datos['id_marca'],
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

        //////eliminar
        function deletCar($req, $res) {
            $id = $req->params->id;
            $vehiculo = $this->model-> getCarById($id);

            if (!$vehiculo) {
                return $res->json("El vehiculo con el id= $id no existe", 404);
            }
            
            $this->model->deleteCar($id);
            
            return $res->json("El veiculo id= $id eliminado con éxito", 204);
        }

        ////agregar
        function addCarVehiculo($req, $res) {

            $datos = $this->validarDatos($req, $res);
            
            if ($datos == null) {
                return $res->json(["error" => false,
                "message" => "Parámetros inválidos o inexistentes."], 400);
            }
            
            //strtoupper hece que todo el txt se vuelva en mayusculas
            $patente = $datos['patente'];
            
            
            //comprobacion de patentes
            if ($this->model->existePatente($patente)) {
                return $res->json('la patente seleccionada ya esta ciendo usada.', 409 );
            }
            
            
            if ($req->body->vendido == 1) {
                return $res->json('error El vehículo no puede registrarse como vendido al crearse.', 400);
            }
            
            $NuevoVehiculo = $this->model->insertCar($datos['id_marca'],
                $datos['modelo'],
                $datos['anio'],
                $datos['km'],
                $datos['precio'],
                $datos['patente'],
                $datos['es_nuevo'],
                $datos['imagen']);

            if ($NuevoVehiculo == null) {
                return $res->json('Error del servidor', 500);
            }

            return $res->json("Vehículo creado con éxito: $NuevoVehiculo",201);
        }

        ////funciones de filtros
        function comprobacionDeQuerysParams($req,$res) {
            $params = new stdClass();
            $params->marcas = null;
            $params->sorts = null;
            $params->orders = ' ASC ';
            
            
            if (isset($req->query->marcas)) {
                
                $nom_marca = ($req->query->marcas);
                
                $marcas = $this->modelMarca->getCarBrandByName($nom_marca);

                

                if (!$marcas) {
                    return $res->json('la marca seleccionada no existe.', 404 );
                }
                $params->marcas = $marcas->id;

            }
            
            //////////// verificacion del sort 

            if (isset($req->query->sort)) {
                $sort = $req->query->sort;
                
                //pido las columnas de la tabla vehiculos.
                $columnas = $this->model->getColumnas();
                
                //verificar si el campo existe.
                if(in_array($sort, $columnas)){
                    $params->sorts = $sort;
                }else {
                    return $res->json('El parametro/columna no existe .', 404 );
                }
            }
            

            if (isset($req->query->order)) {
                $order = strtoupper($req->query->order);
                

                if ($order == 'DESC' || $order == 'ASC') {
                    $params->orders = $order;
                }
                
            }
            

            return $params;
        }

        ////validacion de datos
        function validarDatos($req, $res) {
            $body = $req->body;

            if (!isset($body->id_marca) || empty($body->id_marca)) {
                return $res->json([
                    "error" => true,
                    "message" => "Faltan datos: id_marca"
                ], 400);
            }

            // if (empty($body->marca)) {
            //     return $res->json([
            //         "error" => true,
            //         "message" => "Falta ingresar la marca"
            //     ], 400);
            // }

            if (empty($body->modelo)) {
                return $res->json([
                    "error" => true,
                    "message" => "Falta ingresar el modelo"
                ], 400);
            }

            if (empty($body->anio)) {
                return $res->json([
                    "error" => true,
                    "message" => "Falta ingresar el año"
                ], 400);
            }

            if (!isset($body->km)) {
                return $res->json([
                    "error" => true,
                    "message" => "Falta ingresar los kilómetros"
                ], 400);
            }

            if (!isset($body->precio)) {
                return $res->json([
                    "error" => true,
                    "message" => "Falta ingresar el precio"
                ], 400);
            }

            if (!isset($body->patente)) {
                return $res->json([
                    "error" => true,
                    "message" => "Falta ingresar la patente"
                ], 400);
            }

            if (empty($body->imagen)) {
                return $res->json('Falta la imagen', 400);
            }
            
            $id_marca = $body->id_marca;

            //Comprobacion de la marca
            $marca = $this->modelMarca->getCarBrandById($id_marca);

            if (!$marca) {
                return $res->json('la marca seleccionada no existe .', 404 );
            }

            // $marca = trim($body->marca);
            $modelo = trim($body->modelo);
            $anio = (int) $body->anio;
            $km = (int) $body->km;
            $precio = (float) $body->precio;



            //strtoupper hece que todo el txt se vuelva en mayusculas
            $patente = strtoupper(trim($body->patente));

            // //comprobacion de patentes no es necesario para el put
            // if ($this->model->existePatente($patente)) {
            //     return $res->json([
            //         "error" => true,
            //         "message" => "La Patente esta ciendo usada"
            //     ], 404 );
            // }

            $imagen = trim($body->imagen);

            // Campos opcionales es nuevo por default en la tabla siempre es nuevo.
            if (isset($body->es_nuevo)) {
                $es_nuevo = (int) $body->es_nuevo;
            }

            //comprobacion de logica  si es nuevo no puede tener mas de 0 km.
            if ($es_nuevo && $km > 0) {
                return $res->json('error: Un vehículo nuevo no puede tener kilómetros.', 400);
            }
            //comprobacion de logica si es nuevo no puede tener mas de 0 km.
            if (!$es_nuevo && $km <= 0) {
                return $res->json('error: El vehiculo es usado pero tiene 0 km.', 400);
            }

            // comprobacion de nombre_marca con el ID_marca no neceraio de momento
            // $objetoMarca = $this->modelMarca->getCarBrandByName($marca);
            // if (!$objetoMarca) {
            //     return $res->json('Esa marca no existe en la base de datos', 400);
            // }
            // if ($id_marca != $objetoMarca->id) {
            //     return $res->json('La Marca no coincide con ID_marca', 400);
            // }
            
            // Si todo está bien devolvemos los datos procesados
            return [
                'id_marca' => $id_marca,
                'modelo' => $modelo,
                'anio' => $anio,
                'km' => $km,
                'precio' => $precio,
                'patente' => $patente,
                'imagen' => $imagen,
                'es_nuevo' => $es_nuevo
            ];
        }
    
        //marcelo

        function patchCar($req, $res) {

            $id = $req->params->id;
            $modelo = $this->model->getCarById($id);

            $input = json_decode(file_get_contents('php://input'), true);

            // file_get_contents('php://input') lee el contenido bruto del HTTP
            // json_decode convierte el contenido JSON en un array asociativo
            
            if (empty($modelo)) {
                return $res->json([
                    "error" => true,
                    "message" => "Vehículo con id=$id no encontrado"
                ], 404); // no se ha encontrado
            }
            
            $allowedFields = ['tipo', 'marca', 'modelo', 'anio', 'km', 'precio', 'patente', 'es_nuevo', 'imagen', 'vendido']; // campos permitidos
            $data = [];

            foreach ($input as $field => $value) {
                if (in_array($field, $allowedFields)) {
                    $data[$field] = $value;
                }
            }

            if (empty($data)) {
                return $res->json([
                    "error" => true,
                    "message" => "No están presentes los campos válidos"
                ], 400);
            }

            if (isset($data['vendido'])) {
                $vendido = (int) $data['vendido'];
                if ($vendido === 1) {
                    $this->model->deleteCar($id);
                    return $res->json([
                        "error" => false,
                        "message" => "Vehículo de id=$id vendido y eliminado de la base de datos",
                    ]);
                }
            }
            $this->model->patchField($id, $data); // ejecuta la acción de la base de datos
            $modeloActualizado = $this->model->getCarById($id); // actualiza el modelo

            return $res->json([
                "error" => false,
                "message" => "Se ha actualizado el dato correspondiente del vehículo con id=$id",
                "data" => $modeloActualizado // muestra el modelo ya actualizado
            ], 200);
        }

    } 
?>
