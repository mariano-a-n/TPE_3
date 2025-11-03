<?php 
    include_once 'app/models/Marcas.model.php';
    include_once 'app/models/Vehiculos.model.php';

    class MarcasControler {

        private $model; 
        private $modelCar;

        function __construct(){
            $this->model = new taskModel();
            $this->modelCar = new taskModelV();
        }


        function getBrands($req , $res) {
            // obtengo las marcas de la db/arry de datos
            $marcas = $this->model->getCarBrands(); 

            return $res->json($marcas, 200);
        }

        

        function getBrandById($req , $res) {
            // obtengo modelos by id/trae arry de marcas con id =?
            $id = $req->params->id;
            $marca = $this->model-> getCarBrandById($id);

            if (!$marca) {
                return $res->json("La marca con el id=$id no existe", 404);
            }
            
            return $res->json($marca, 200);
        }

        function removeBrand($req, $res) {
            $id = $req->params->id;

            $marca = $this->model-> getCarBrandById($id);

            if (!$marca) {
                return $res->json("La marca con el id=$id no existe", 404);
            }

            $vehiculos = $this->modelCar->getVehiculosByMarca($id);
            if (count($vehiculos) > 0) {
                return $res->json("no puedes eliminar esta marca porque existen veiculos asociados");
            }

            //borro la marca que del id que pase
            $this->model->deleteBrand($id);

            return $res->json("La marca con el id=$id se eliminó", 204);
            
        }
        
        function buscar($req , $res) {
            if (empty($req->body->marca) || !isset($req->body->marca)) {
                return $res->json('Faltan datos', 400);
            }

            $name_carrera = $req->body->marca;

            $marca = $this->model->getCarBrandByName($name_carrera);
            

            if (count($marca) <= 0) {
                return $res->json('la marca no existe');
            }
            
            $vehiculos = $this->modelCar->getVehiculosByMarca($marca->id);
            return $vehiculos;
        }

        
        function insertBrand($req , $res) {
            if (empty($req->body->marca) || !isset($req->body->marca)) {
            return $res->json('Faltan datos', 400);
            }
            
            if (empty($req->body->nacionalidad) || !isset($req->body->nacionalidad)) {
            return $res->json('Faltan datos', 400);
            }

            if (empty($req->body->anio) || !isset($req->body->anio)) {
            return $res->json('Faltan datos', 400);
            }


            $marca = $req->body->marca;
            $nacionalidad = $req->body->nacionalidad;
            $anio = $req->body->anio;

            $id_insertado = $this->model->insert($marca,$nacionalidad,$anio);

            if ($id_insertado == null) {
                return $res->json('Error del servidor', 500);
            }

            
            $nuevaMarca = $this->model->getCarBrandById($id_insertado);
            return $res->json($nuevaMarca, 201); 
        }


        

        function update($req , $res) {

            $id = $req->params->id;
            $marca = $this->model-> getCarBrandById($id);

            if (!$marca) {
                return $res->json("La marca con el id=$id no existe", 404);
            }

            if (empty($req->body->marca) || !isset($req->body->marca)) {
            return $res->json('Faltan datos', 400);
            }
            
            if (empty($req->body->nacionalidad) || !isset($req->body->nacionalidad)) {
            return $res->json('Faltan datos', 400);
            }

            if (empty($req->body->anio) || !isset($req->body->anio)) {
            return $res->json('Faltan datos', 400);
            }
            
            $marca = $req->body->marca;
            $nacionalidad = $req->body->nacionalidad;
            $anio = $req->body->anio;

            $this->model->updateBrand($id,$marca,$nacionalidad,$anio);

            $Marca_actualizada = $this->model->getCarBrandById($id);
            return $res->json($Marca_actualizada, 201); 
            
        }
    }

?>