<?php
require_once 'app/models/model.php';
    class taskModelV extends Model{

        function getCarModel() {
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

        function insertCar($modelo, $anio, $km, $precio, $patente, $es_nuevo, $imagen, $vendido, $marca, $nacionalidad, $anio_de_creacion) {
            // 1. Verificar si la marca ya existe
            $query = $this->db->prepare("SELECT id FROM marcas WHERE marca = ?");
            $query->execute([$marca]);
            $resultadoMarca = $query->fetch(PDO::FETCH_ASSOC);

            if ($resultadoMarca) {
                $id_marca = $resultadoMarca['id'];
            } else {
                // 2. Insertar nueva marca
                $insertMarca = $this->db->prepare("INSERT INTO marcas(marca, nacionalidad, anio_de_creacion) VALUES (?,?,?)");
                $insertMarca->execute([$marca, $nacionalidad, $anio_de_creacion]);
                $id_marca = $this->db->lastInsertId();
            }

            // 3. Insertar vehículo
            $insertVehiculo = $this->db->prepare("INSERT INTO vehiculos(modelo, anio, km, precio, patente, es_nuevo, imagen, vendido, id_marca) VALUES (?,?,?,?,?,?,?,?,?)");
            $insertVehiculo->execute([$modelo, $anio, $km, $precio, $patente, $es_nuevo, $imagen, $vendido, $id_marca]);
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

