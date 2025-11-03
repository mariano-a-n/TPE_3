<?php
require_once 'app/models/model.php';
    class ModelVehiculos extends Model{

        function getCarModel() {
            // 2. consulta SQL (SELECT * FROM vehiculos)
            $query = $this->db->prepare('SELECT * FROM vehiculos');
            $query->execute();

            // obtengo todos los resultados de la consulta que arroja la query
            $models = $query->fetchAll(PDO::FETCH_OBJ);

            return $models;
        }

        function getCarById() {
            // 2. consulta SQL (SELECT * FROM vehiculos)
            $query = $this->db->prepare('SELECT * FROM vehiculos');
            $query->execute();

            // obtengo todos los resultados de la consulta que arroja la query
            $models = $query->fetchAll(PDO::FETCH_OBJ);

            return $models;
        }
        
        function updateCar($id) {
            $query = $this->db->prepare('UPDATE vehiculos SET vendido = 1 WHERE id = ?');
            $query->execute([$id]);
        }

        function deleteCar($id) {
            $query = $this->db->prepare('DELETE FROM vehiculos WHERE id = ?');
            $query->execute([$id]);
        }

        function insertCar($id_marca, $modelo, $anio, $km, $precio, $patente, $es_nuevo, $imagen) {
            // 1. Verificar si la marca ya existe
            

            // 2. Insertar vehículo
            $insertVehiculo = $this->db->prepare("INSERT INTO vehiculos(id_marca, modelo, anio, km, precio, patente, es_nuevo, imagen) VALUES (?,?,?,?,?,?,?,?)");
            $insertVehiculo->execute([$id_marca, $modelo, $anio, $km, $precio, $patente, $es_nuevo, $imagen]);

            return $this->db->lastInsertId();
        }

//////////////////// mariano-dev

        function getVehiculosByMarca($id_marca) {
            // 2. ejecuto consulta SQL (SELECT * FROM vehiculos)
            $query = $this->db->prepare('SELECT * FROM vehiculos WHERE id_marca = ?');
            $query->execute([$id_marca]);

            // obtengo todos los resultados de la consulta que arroja la query
            $models = $query->fetchAll(PDO::FETCH_OBJ);

            return $models;
        }
    }

