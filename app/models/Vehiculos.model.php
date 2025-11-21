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
        
        function insertCar($id_marca, $tipo, $marca, $modelo, $anio, $km, $precio, $patente, $es_nuevo, $imagen) {
            $sql = "INSERT INTO vehiculos (id_marca, tipo, marca, modelo, anio, km, precio, patente, es_nuevo, imagen) VALUES (:id_marca, :tipo, :marca, :modelo, :anio, :km, :precio, :patente, :es_nuevo, :imagen)";

            $params = [
                ':id_marca' => $id_marca,
                ':tipo' => $tipo,
                ':marca' => $marca,
                ':modelo' => $modelo,
                ':anio' => $anio,
                ':km' => $km,
                ':precio' => $precio,
                ':patente' => $patente,
                ':es_nuevo' => $es_nuevo,
                ':imagen' => $imagen
            ];

            $query = $this->db->prepare($sql);
            $query->execute($params);

            return $this->db->lastInsertId();
        }

        function updateModelCar($id_marca, $tipo, $marca, $modelo, $anio, $km, $precio, $patente, $es_nuevo, $imagen, $id) {
            $sql = "UPDATE vehiculos SET
                id_marca = :id_marca,
                tipo = :tipo,
                marca = :marca,
                modelo = :modelo,
                anio = :anio,
                km = :km,
                precio = :precio,
                patente = :patente,
                es_nuevo = :es_nuevo,
                imagen = :imagen
                WHERE id = :id";

            $params = [
                ':id_marca' => $id_marca,
                ':tipo' => $tipo,
                ':marca' => $marca,
                ':modelo' => $modelo,
                ':anio' => $anio,
                ':km' => $km,
                ':precio' => $precio,
                ':patente' => $patente,
                ':es_nuevo' => $es_nuevo,
                ':imagen' => $imagen,
                ':id' => $id
            ];
            // si son muchos campos así es claro, seguro y mantenible
            // y no es necesario el orden exacto, asocia cada valor por nombre y no por posición

            $query = $this->db->prepare($sql);
            $query->execute($params);
        }
        
        function updateCar($id) {
            $query = $this->db->prepare('UPDATE vehiculos SET vendido = 1 WHERE id = ?');
            $query->execute([$id]);
        }

        function removeCar($id) {
            $query = $this->db->prepare('DELETE FROM vehiculos WHERE id = ?');
            $query->execute([$id]);
        }

        function patchField($id, $data) {
            $set = [];
            $params = [];
            
            foreach ($data as $field => $value) {
                $set[] = "$field = ?";
                $params[] = $value;
            }
            $params[] = $id;

            $query = $this->db->prepare("UPDATE vehiculos SET " . implode(', ', $set) . " WHERE id = ?"); // implode(', ', $set) es mas seguro y flexible. Usa los parametros que ya estan defindos
            $query->execute($params);
        }

        function getCarsOrderedByPrecio($sort, $order) {
            // $sql = "SELECT * FROM vehiculos ORDER BY $sort $order";
            $query = $this->db->prepare("SELECT * FROM vehiculos ORDER BY $sort $order");
            $query->execute();
            return $query->fetchAll(PDO::FETCH_OBJ);
        }

        function getCarByFilter($tipo) {
            $sql = "SELECT * FROM vehiculos";
            $params = []; // si fuera con ? habría que pasar el parametro: [$tipo]

            if ($tipo) { // si hay $tipo
                $sql .= " WHERE tipo = :tipo"; // :tipo es mas claro y flexible que ?
                $params[':tipo'] = $tipo;
            }
            
            $query = $this->db->prepare($sql);
            $query->execute($params);
            return $query->fetchAll(PDO::FETCH_OBJ);
        }

        function existePatente($patente, $id) {
            $query = $this->db->prepare("SELECT id FROM vehiculos WHERE patente = :patente AND id != :id");
            $query->execute([':patente' => $patente, ':id' => $id]);
            return $query->fetch(PDO::FETCH_OBJ);
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

