<?php 
include_once 'app/models/task.modelV.php';

class VehiculosControler {
    private $model;

    function __construct(){
        $this->model = new taskModelV();
    }

    // ==== HOME ====
    // function showHomeUser($request) {
    //     $modelos = $this->model->getCarModel();
    //     $this->veiw->showTaksVehiculosUser($modelos, $request->user);
    // }

    function showHome($req, $res) {
        $modelos = $this->model->getCarModel();

        return $res->json($modelos);
    }

    // ==== VEHÍCULOS ====
    function showCarBrandById($req, $res) {
        $id = $req->params->id;
        $vehiculo = $this->model-> getCarBrandById($id);

        if (!$vehiculo) {
            return $res->json("La marca con el id=$id no existe", 404);
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

    function addCarModel() {
        if (isset($_POST['modelo'], $_POST['anio'], $_POST['km'], $_POST['precio'], $_POST['patente'], $_POST['marca'])
            && !empty($_POST['marca']) && !empty($_POST['modelo']) && !empty($_POST['anio']) && !empty($_POST['precio'])) {

            $modelo = trim($_POST['modelo']);
            $anio = filter_var($_POST['anio'], FILTER_VALIDATE_INT);
            $km = filter_var($_POST['km'], FILTER_VALIDATE_INT);
            $precio = filter_var($_POST['precio'], FILTER_VALIDATE_FLOAT);
            $patente = !empty($_POST['patente']) ? strtoupper(trim($_POST['patente'])) : null;
            $es_nuevo = isset($_POST['es_nuevo']) ? 1 : 0;
            $imagen = isset($_POST['imagen']) && filter_var($_POST['imagen'], FILTER_VALIDATE_URL) ? $_POST['imagen'] : null;
            $vendido = isset($_POST['vendido']) ? 1 : 0;
            $marca = trim($_POST['marca']);
            $nacionalidad = $_POST['nacionalidad'] ?? null;
            $anio_de_creacion = $_POST['anio_de_creacion'] ?? null;

            $this->model->insertCar($modelo, $anio, $km, $precio, $patente, $es_nuevo, $imagen, $vendido, $marca, $nacionalidad, $anio_de_creacion);
            header("Location: " . BASE_URL . "modelos");
        } else {
            $this->veiw->showError('Falta ingresar datos');
        }
    }
}
?>
