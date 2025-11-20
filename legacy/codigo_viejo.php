<?php
//////////////vehiculos controler

////////addCarVehiculo
    //comprubo los datos
            // if (empty($req->body->id_marca) || !isset($req->body->id_marca)) {
            // return $res->json('Faltan datos1', 400);
            // }
            
            // if (empty($req->body->modelo) || !isset($req->body->modelo)) {
            // return $res->json('Faltan datos2', 400);
            // }

            // if (empty($req->body->anio) || !isset($req->body->anio)) {
            // return $res->json('Faltan datos3', 400);
            // }

            // if ( !isset($req->body->km)) {
            // return $res->json('Faltan datos4', 400);
            // }
            
            
            // if (empty($req->body->precio) || !isset($req->body->precio)) {
            // return $res->json('Faltan datos5', 400);
            // }

            // if (empty($req->body->patente) || !isset($req->body->patente)) {
            // return $res->json('Faltan datos6', 400);
            // }
            
            // if (empty($req->body->imagen)) {
            // return $res->json('Faltan datos7', 400);
            // }


            // //comprobacion de la marca
            // $id_marca = (int) $req->body->id_marca;
            // $marca = $this->modelMarca->getCarBrandById($id_marca);

            // if (!$marca) {
            //     return $res->json('la marca seleccionada no existe .', 404 );
            // }

            // // el trim quita los espacion antes y despues del txt.
            // $modelo = trim($req->body->modelo);
            // $anio = (int) $req->body->anio;
            // $km = (int) $req->body->km;
            // $precio = (float) $req->body->precio;

            
            // //strtoupper hece que todo el txt se vuelva en mayusculas
            // $patente = strtoupper(trim($req->body->patente));
            
            // //comprobacion de patentes
            // if ($this->model->existePatente($patente)) {
            //     return $res->json('la patente seleccionada ya esta ciendo usada.', 404 );
            // }

            // $imagen = trim($req->body->imagen);

            // // Campos opcionales es nuevo por default en la tabla siempre es nuevo
            // if (isset($req->body->es_nuevo)) {
            //     $es_nuevo = (int) $req->body->es_nuevo;
            // } else {
            //     $es_nuevo = 0;
            // }

            // //comprovacion de logica  si es nuevo no puede tener mas de 0 km
            // if ($es_nuevo && $km > 0) {
            // return $res->json('error: Un vehículo nuevo no puede tener kilómetros.', 400);
            // }
            // //comprovacion de logica si el vehiculo es usado no puede tener 0 o menos km
            // if (!$es_nuevo && $km <= 0) {
            // return $res->json('error: El vehiculo es usado pero tiene 0 km .', 400);
            // }


            //esto revisar en clase.
            
            // //strtoupper hece que todo el txt se vuelva en mayusculas
            // $patente = strtoupper(trim($req->body->patente));
            
            // //comprobacion de patentes
            // if ($this->model->existePatente($patente)) {
            //     return $res->json('la patente seleccionada ya esta ciendo usada.', 404 );
            // }

            /////////////////////////////////////////////////////////////////////////////////////////////////////
////////function comprobacionDeQuerysParams($req) {
        //     $params = new stdClass();
        //     $params->marcas = null;
        //     $params->sorts = null;
        //     $params->orders = 'ASC';

        //     // === Validar marca ===
        //     if (isset($req->query->marcas)) {
        //         $nom_marca = $req->query->marcas;
        //         $marca = $this->modelMarca->getCarBrandByName($nom_marca);

        //         if (!$marca) {
        //             return (object)[
        //                 'error' => true,
        //                 'mensaje' => 'La marca seleccionada no existe.'
        //             ];
        //         }

        //         $params->marcas = $marca->id;
        //     }

        //     // === Validar sort ===
        //     if (isset($req->query->sort)) {
        //         $sort = $req->query->sort;
        //         $columnas = $this->model->getColumnas();

        //         if (!in_array($sort, $columnas)) {
        //             return (object)[
        //                 'error' => true,
        //                 'mensaje' => 'El parámetro/columna no existe.'
        //             ];
        //         }

        //         $params->sorts = $sort;
        //     }

        //     // === Validar order ===
        //     if (isset($req->query->order)) {
        //         $order = strtoupper($req->query->order);
        //         if ($order == 'DESC' || $order == 'ASC') {
        //             $params->orders = $order;
        //         }
        //     }

        //     // si todo está bien
        //     return $params;
        // }

///////////////////vehiculos model

?>