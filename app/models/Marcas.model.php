<?php
    require_once 'app/models/model.php';
    class ModelMarcas extends Model{
        // Obtiene y devuelve la base de datos de las marcas
        function getCarBrands() {

            // 2. ejecuto la consulta SQL (SELECT * FROM marcas)
            $query = $this->db->prepare('SELECT * FROM marcas');
            $query->execute();

            // obtengo todos los resultados de la consulta que arroja la query
            $marcas = $query->fetchAll(PDO::FETCH_OBJ);

        return $marcas;
        }



        // Obtiene y devuelve la base de datos de las marcas con el id  (cambiar incuerencia)
        function getCarBrandById($id) {
            // 1. Abrimos la conexión a la DB

            // 2. Enviamos la consulta SQL 
            $query = $this->db->prepare('SELECT * FROM marcas WHERE id = ?');
            $query->execute([$id]);

            // Obtengo los datos de la consulta que arroja la query
            return $query->fetch(PDO::FETCH_OBJ);
        }
        



        function deleteBrand($id) {

            // 2. Envío la consulta
            $query = $this->db->prepare("DELETE FROM marcas WHERE id = ?");
            $query->execute([$id]); // evita la inyección SQL
            
            // no hace falta obtener el resultado
        }



        function insert($marca,$nacionalidad,$anio) {

            // 2. Envío la consulta
            $query = $this->db->prepare("INSERT INTO marcas(marca, nacionalidad, anio_de_creacion) VALUES (?,?,?)");
            $query->execute([$marca,$nacionalidad,$anio]); // evita la inyección SQL
            
            // no hace falta obtener el resultado
            return $this->db->lastInsertId();
        }

        

        function updateBrand($id, $marca, $nacionalidad, $anio) {
            
            // 2. envio la consulta
            $query = $this->db->prepare("UPDATE marcas SET marca = ?, nacionalidad = ?, anio_de_creacion = ? WHERE id = ?");
            $query->execute([$marca, $nacionalidad, $anio, $id]);

            // 3. no delvuelve nada
        }


        function getCarBrandByName($nombre) {


            //2. envio consulta
            $query = $this->db->prepare('SELECT * FROM marcas WHERE marca LIKE ?');
            $query->execute(["%$nombre%"]);

            $carrera = $query->fetch(PDO::FETCH_OBJ);

            return $carrera;
        }
    }

?> 