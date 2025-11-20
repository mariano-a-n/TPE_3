<?php
require_once 'app/models/model.php';
    class ModelVehiculos extends Model{
        
        function getCarModel($limite, $offset) {

            // 2. consulta SQL (SELECT * FROM vehiculos)
            $sql = "SELECT * FROM vehiculos LIMIT $limite OFFSET $offset";

            $query = $this->db->prepare($sql);
            $query->execute();

            // obtengo todos los resultados de la consulta que arroja la query
            return $query->fetchAll(PDO::FETCH_OBJ);
        }
        
        function deleteCar($id) {
            $query = $this->db->prepare('DELETE FROM vehiculos WHERE id = ?');
            $query->execute([$id]);
        }
        
        function getCarById($id) {
            // 2. consulta SQL (SELECT * FROM vehiculos)
            $query = $this->db->prepare('SELECT * FROM vehiculos WHERE id = ?');
            $query->execute([$id]);
            
            // obtengo todos los resultados de la consulta que arroja la query
            return $query->fetch(PDO::FETCH_OBJ);
            
        }
        
        function updateCar($id) {
            $query = $this->db->prepare('UPDATE vehiculos SET vendido = 1 WHERE id = ?');
            $query->execute([$id]);
        }
        
        function updateModelCar($id_marca, $modelo, $anio, $km, $precio, $patente, $es_nuevo, $imagen, $id) {
            $query = $this->db->prepare("UPDATE vehiculos SET id_marca=?, modelo=?, anio=?, km=?, precio=?, patente=?, es_nuevo=?, imagen=? WHERE id=?");
            $query->execute([$id_marca, $modelo, $anio, $km, $precio, $patente, $es_nuevo, $imagen, $id]);
        }
        
        function insertCar($id_marca, $modelo, $anio, $km, $precio, $patente, $es_nuevo, $imagen) {
            
            // 2. Insertar vehículo
            $insertVehiculo = $this->db->prepare("INSERT INTO vehiculos(id_marca, modelo, anio, km, precio, patente, es_nuevo, imagen) VALUES (?,?,?,?,?,?,?,?)");
            $insertVehiculo->execute([$id_marca, $modelo, $anio, $km, $precio, $patente, $es_nuevo, $imagen]);

            return $this->db->lastInsertId();
        }
        
        function getCarModels($filtros, $sorts, $orders,$limite,$offset) {

            // valores por defecto si vienen vacíos
            if (empty($sorts)){
                $sorts = 'id';
            }  

            if (empty($orders)){
                $orders = 'ASC';
            }
            
            $sql = "SELECT * FROM vehiculos ";
            
            
            if (!empty($filtros)) {
                $flitro = " WHERE id_marca = ". $filtros;
                $sql .= $flitro . " ORDER BY $sorts $orders LIMIT $limite OFFSET $offset";
            }else{
                $sql .= " ORDER BY $sorts $orders LIMIT $limite OFFSET $offset";
            }

                

            // 2. consulta SQL (SELECT * FROM vehiculos)
            $query = $this->db->prepare($sql);
            
            $query->execute();
            // obtengo todos los resultados de la consulta que arroja la query
            $models = $query->fetchAll(PDO::FETCH_OBJ);

            return $models;
        }
        
        function getVehiculosByMarca($id_marca) {
            // 2. ejecuto consulta SQL (SELECT * FROM vehiculos)
            $query = $this->db->prepare('SELECT * FROM vehiculos WHERE id_marca = ?');
            $query->execute([$id_marca]);
            
            // obtengo todos los resultados de la consulta que arroja la query
            $models = $query->fetchAll(PDO::FETCH_OBJ);
            
            return $models;
        }
        
        public function getColumnas() {
            // 2. ejecuto consulta SQl
            $stmt = $this->db->prepare("SHOW COLUMNS FROM vehiculos");
            $stmt->execute();
            // 3. envio la respuesta.
            return $stmt->fetchAll(PDO::FETCH_COLUMN);
        }
        
        function contarVehiculos() {
            // 2. ejecuto la consulta SQL (el cuont es una función de SQL que cuenta la cantidad total de filas en una tabla (sin importar su contenido).
            $query = $this->db->prepare("SELECT COUNT(*) as total FROM vehiculos");
            $query->execute();
            // 3. envio la respueta.
            $resultado = $query->fetch(PDO::FETCH_OBJ);
            return (int)$resultado->total;
            
        }

        public function contarVehiculosPorMarca($id_marca) {
            $query = $this->db->prepare("SELECT COUNT(*) as total FROM vehiculos WHERE id_marca = ?");
            $query->execute([$id_marca]);
            $result = $query->fetch(PDO::FETCH_OBJ);
            return $result->total;
        }

        function existePatente($patente){
            $query = $this->db->prepare("SELECT COUNT(*) AS total FROM vehiculos WHERE patente = ?");
            $query->execute([$patente]);
            $resultado = $query->fetch(PDO::FETCH_OBJ);
            return $resultado->total > 0;
        }
}