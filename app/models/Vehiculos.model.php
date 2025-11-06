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

        function getCarById($id) {
            // 2. consulta SQL (SELECT * FROM vehiculos)
            $query = $this->db->prepare('SELECT * FROM vehiculos WHERE id = ?');
            $query->execute([$id]);

            // obtengo todos los resultados de la consulta que arroja la query
            return $query->fetchAll(PDO::FETCH_OBJ);
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
            $query = $this->db->prepare("INSERT INTO vehiculos(id_marca, modelo, anio, km, precio, patente, es_nuevo, imagen) VALUES (?,?,?,?,?,?,?,?)");
            $query->execute([$id_marca, $modelo, $anio, $km, $precio, $patente, $es_nuevo, $imagen]);

            return $this->db->lastInsertId();
        }

        function updateModelCar($id_marca, $modelo, $anio, $km, $precio, $patente, $es_nuevo, $imagen) {
            $query = $this->db->prepare("UPDATE vehiculos SET id_marca=?, modelo=?, anio=?, km=?, precio=?, patente=?, es_nuevo=?, imagen=?, vendido=? WHERE id=?");
            $query->execute($modelo, $anio, $km, $precio, $patente, $es_nuevo, $imagen, $id_marca);
        }

        function getCarsOrderedByPrecio($order) {
            $query = $this->db->prepare("SELECT * FROM vehiculos ORDER BY precio $order");
            $query->execute();
            return $query->fetchAll(PDO::FETCH_OBJ);
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

