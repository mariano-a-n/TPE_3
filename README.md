# TPE Parte 3

## Integrantes

 * Marcelo Gelato (gelatomarcelo@hotmail.com)

 * Mariano Nesci (nescimarianoa999@gmail.com)

## Temática

 * Venta de vehículos (concesionaria)

## Descripción

 * tabla de marca de vehículos y sus modelos, aniadido tabla usuario

 ### digrama de identidad
![DRE] (/img/captura.jpg)


### SQL
[Script SQL](dataDB/concesionaria.sql)

### tabla usuarios
usuario: webadmin@gmail.com
contraseña : admin


### Despliegue del sitio

**Instalación y configuración:**

Copiar el proyecto dentro de la carpeta htdocs del entorno de XAMPP.

Ejemplo de ruta:

C:\xampp\htdocs\nombre_del_proyecto


Crear la base de datos en phpMyAdmin e importar el archivo concesionaria.sql incluido en el proyecto.

Esto generará automáticamente las tablas y datos iniciales necesarios.

Configurar la conexión a la base de datos en el archivo:

app/config/config.php


Dentro encontrarás las constantes de conexión:

define('MYSQL_HOST', 'localhost');
define('MYSQL_USER', 'root');
define('MYSQL_PASS', '');
define('MYSQL_DB', '');


# Todos los valores vienen configurados por defecto.
Si ocurre algún problema al ingresar, revisar el acceso a la base o los datos del usuario MySQL.

Iniciar Apache y MySQL desde el panel de control de XAMPP.

Acceder al sitio desde el navegador:

http://localhost/

### Usuario administrador

Usuario: webadmin@gmail.com
Contraseña: admin

### Requisitos para ejecutar y probar el proyecto

Para poder ejecutar la API y probar los endpoints correctamente, se requiere instalar las siguientes herramientas:

- Herramienta	Descripción	Enlace de descarga
  XAMPP	Entorno que incluye Apache, MySQL y PHP. Necesario para ejecutar el servidor local y la base de datos.	Link De Descarga: https://www.apachefriends.org/es/download.html

- Postman	Herramienta obligatoria para probar y enviar solicitudes HTTP a la API (GET, POST, PUT, DELETE). Link De Descarga: https://www.postman.com/downloads/

- Visual Studio Code	Editor de código recomendado para abrir y editar los archivos del proyecto. Link De Descarga:	https://code.visualstudio.com/Download

- phpMyAdmin	Incluido dentro de XAMPP. Se utiliza para crear y administrar la base de datos MySQL. Link De Descarga:	https://www.phpmyadmin.net/downloads/

Uso de Postman (obligatorio para la API):
Todos los endpoints de la API deben probarse mediante Postman.
Desde allí podés enviar peticiones con diferentes métodos (GET, POST, PUT, DELETE) y observar las respuestas JSON generadas por el servidor.


Cada endpoint tiene su propia documentación y ejemplos de uso dentro del archivo de referencia o el apéndice de endpoints.


# API de Vehículos 

Esta API permite realizar operaciones CRUD (Crear, Leer, Actualizar y Eliminar) sobre los vehículos almacenados en la base de datos.

Tecnologías utilizadas:

-Lenguaje: PHP

-Base de datos: MySQL

-Cliente para pruebas: Postman

-Formato de respuesta: JSON.

---

##  Endpoints

###  GET /vehiculos
**Descripción:**  
Obtiene la lista completa de todos los vehículos registrados en el sistema.

**Ejemplo de uso:**  
GET http://localhost/web2/api/vehiculos


Respuesta exitosa:
 json , y codigo de respuesta

[
    {
        "id": 1,
        "id_marca": 3,
        "modelo": "ford f-100",
        "anio": 1981,
        "km": 1000,
        "precio": 1500000,
        "patente": "SHY 893",
        "es_nuevo": 0,
        "imagen": "https://http2.mlstatic.com/D_NQ_NP_2X_742636-MLA89983452028_082025-F.webp",
        "vendido": 0
    },
    {
        "id": 2,
        "id_marca": 6,
        "modelo": "corola",
        "anio": 2010,
        "km": 0,
        "precio": 100000,
        "patente": "gdfeygf",
        "es_nuevo": 1,
        "imagen": "",
        "vendido": 1
    },{.....}
]

### Apéndice: Uso de Query Params en GET /vehiculos

El endpoint /vehiculos permite aplicar filtros y ordenamientos mediante parámetros opcionales en la URL (query parameters):

api/vehiculos?marcas=nombre_de_la_marca&sort=nombre_columna&order=asc|desc


A continuación, se detalla el funcionamiento de cada parámetro:

*** ?marcas= ***

El parámetro marcas sirve para filtrar los vehículos por su marca/fabricante.

Pasos recomendados:

1- Si no conocés las marcas disponibles, podés:

Realizar una petición GET /marcas desde Postman, o

Revisar la documentación dentro de la carpeta database, donde se detalla el contenido de las tablas.

2- Una vez sepas el nombre de la marca, escribilo en la URL de la siguiente forma:

api/vehiculos?marcas=Ford


Notas:

Si ingresás una marca inexistente, la API devolverá un mensaje de error con su respectivo código HTTP.

Este parámetro es opcional: si no lo usás, se listarán todos los vehículos.

*** &sort= ***

El parámetro sort se utiliza para ordenar los resultados según una columna específica de la tabla vehiculos.

Sugerencias:

Consultá la documentación en la carpeta database para conocer los nombres exactos de las columnas disponibles (por ejemplo: anio, modelo, marca, id).

Si ingresás una columna que no existe, el sistema devolverá un mensaje de error.

Ejemplo:

api/vehiculos?sort=anio


Esto ordenará los resultados por el campo anio de forma ascendente por defecto.

*** &order= ***

El parámetro order define el sentido del ordenamiento de los resultados.
Solo admite dos valores válidos:

asc → orden ascendente

desc → orden descendente

Cualquier otro valor provocará un mensaje de error.

Ejemplo:

api/vehiculos?sort=anio&order=desc


Ordena los vehículos por año en forma descendente (de más nuevo a más viejo).

#### Combinaciones posibles 

Los parámetros marcas, sort y order son completamente opcionales y pueden usarse de forma combinada o individual:

***Sin filtros (GET común):***
Muestra todos los vehículos.

http://localhost/web2proyectos/tpEspe/TPE-api-rest1/api/vehiculos


***Usando todos los parámetros (filtro + orden):***

http://localhost/web2proyectos/tpEspe/TPE-api-rest1/api/vehiculos?marcas=Ford&sort=anio&order=desc


***Solo filtrando por marca:***

http://localhost/web2proyectos/tpEspe/TPE-api-rest1/api/vehiculos?marcas=Ford


Esto devuelve solo los vehículos de esa marca, ordenados por defecto según el ID.

***Solo ordenando:***
(Recomendado usar sort junto con order para definir también el sentido del ordenamiento).

http://localhost/web2proyectos/tpEspe/TPE-api-rest1/api/vehiculos?sort=anio&order=asc

#### Resultado esperado

En caso de éxito, Postman mostrará un objeto JSON con los vehículos filtrados y/o ordenados según los parámetros elegidos :
http://localhost/web2proyectos/tpEspe/TPE-api-rest1/api/vehiculos?marcas=ford&sort=anio&order=desc
[
    {
        "id": 5,
        "id_marca": 3,
        "modelo": "Bronco Sport",
        "anio": 2025,
        "km": 0,
        "precio": 100,
        "patente": "ER875XD",
        "es_nuevo": 0,
        "imagen": "https://www.ford.com.ar/content/dam/Ford/website-assets/latam/ar/home/showroom/fds/far-bronco-sport-showroom.jpg.dam.full.high.jpg/1741354285826.jpg",
        "vendido": 0
    },
    {
        "id": 9,
        "id_marca": 3,
        "modelo": "read POWER",
        "anio": 2025,
        "km": 10,
        "precio": 10000,
        "patente": "TTE 894 RK",
        "es_nuevo": 0,
        "imagen": "tt",
        "vendido": 0
    },{...}
]




### GET /vehiculos/:id

Descripción:
Obtiene la información de un vehículo específico a partir de su ID.

**Ejemplo de uso:**

GET http://localhost/web2/api/vehiculos/2


Respuesta exitosa ej:

{
    "id": 2,
    "id_marca": 6,
    "modelo": "corola",
    "anio": 2010,
    "km": 0,
    "precio": 100000,
    "patente": "gdfeygf",
    "es_nuevo": 1,
    "imagen": "",
    "vendido": 1
}

Respueta de error:
return $res->json("el vehiculo con el id= $id no existe", 404);


# !IMPORTANTE! #
Para poder usar los siguentes Endpoints es necesario loguarce o usar el siguente token JWT :



### GET /auth/login

Descripción:
sirve para como el mismo nombre indica loguearte. 


**Ejemplo de uso:**

GET http://localhost/web2/api/auth/login

1- abra posman justo debajo de donde esta la peticiones (post get put etc..) y la url ahi unas pestañas/botones aprete el que dice authorization le aparecera un input de tipo select del lado izquierdo apretelo y se deplegaran varias opciones clikee la opcion que dice basic auth e ingrese el usuario y contraseña anterior mente dados (por si no lo vio son estos:Usuario: webadmin@gmail.com , Contraseña: admin) esto generara un token JWT copielo.

2- ahora en input de tipo select del lado izquierdo apretelo nuevamente y ahora clikee la opcion que dice bearer token y pege el token genero.

3- en caso de no dejarle crear el toque probar con con el sigiente punto el **token jtw duracion 15 dias desde su creacion**, ese token fue creado por mariano nesci con anterioridad y capas este generando incompatibilidad al querer crear otro si que se haya vencido el anteriro antes.

Respueta de error:

si el usuario no existe :
return $res->json("Autenticación no valida", 401);

si el token esta mal ingresado o no es el corecto :
return $res->json("Autenticación no valida", 401);




**token jtw duracion 15 dias desde su creacion**: eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEsInVzdWFyaW8iOm51bGwsInJvbGVzIjpbIkFETUlOIiwiVVNFUiIsIkJBTkFOQSJdLCJleHAiOjE3NjQ4ODM3ODF9.UI4ki2827a9bocszvftIF8cxqPEqNqau_TKAWhq_Q_I 

***uso del token***
si no le deja loguarce o no reconoce el usuario utilice el toque dado que fue el ultimo creado hasta la fecha de entrega el token debe durar hasta el 4 de diciembre,aclaracion lo siguiente que se le va a explicar debe de hacerce con todos los Enpoints que requieran autorizacion osea (post,put,delete... otros si es que hay revisar api_router).
abra posman justo debajo de donde esta la peticiones (post get put etc..) y la url ahi unas pestañas/botones aprete el que dice authorization le aparecera un input de tipo select del lado izquierdo apretelo y se deplegaran varias opciones clikee la opcion que dice bearer token y pege el token dado. 




### POST /vehiculos

Descripción:
Permite registrar un nuevo vehículo en la base de datos.
Los datos deben enviarse en formato JSON dentro del cuerpo de la solicitud (body).
El servidor validará todos los campos y devolverá un error si falta alguno o si los valores no cumplen las condiciones lógicas establecidas.

***Datos requeridos***
Campo	Tipo	Descripción
id_marca	->  int (en el futuro también por nombre de la marca — string) ->	ID de la marca a la que pertenece el vehículo.
modelo ->	string	Nombre o modelo del vehículo.
anio	-> int	Año de fabricación del vehículo.
km	-> int	Cantidad de kilómetros recorridos.
precio	-> float	Precio del vehículo.
patente	-> string	Patente del vehículo (convertida a mayúsculas automáticamente).
es_nuevo ->	boolean (opcional)	Indica si el vehículo es nuevo (1) o usado (0). Si no se especifica, se asume usado (0).
imagen -> string	Imagen o referencia de la imagen del vehículo (URL).
vendido	-> boolean (solo debe ser 0)	Indica si el vehículo está vendido. No puede registrarse como vendido en la creación.

*** Ejemplo de uso**

Solicitud:

POST http://localhost/web2/api/vehiculos


Body (JSON):

{
  "id_marca": 2,
  "modelo": "Road POWER",
  "anio": 2025,
  "km": 10,
  "precio": 10000,
  "patente": "ZTE 432 RK",
  "es_nuevo": 0,
  "imagen": "imagen_auto.png",
  "vendido": 0
}


Respuesta exitosa (201 Created):

{ 
  "mensaje": "Vehículo creado con éxito", 
  "id": 5 
}

### PUT /vehiculos/:id

Descripcion:
función que se encarga de actualizar los datos de un vehículo en la base de datos. Se usa cuando se quiere modificar la información de un auto que ya está registrado, por ejemplo si cambió el precio o se corrigió algún dato. El método PUT requiere agregar todos los campos nuevamente, sean distintos o no

#### paso a paso del PUT:
* se obtiene el id del vehículo desde los parámetros de la URL y se guarda en la variable $id

* se busca ese vehículo en la base de datos con getCarById($id), función que está en model. Si no existe, se devuelve un JSON con el error 404 diciendo que no se encontró y dejando un registro de que ha sido error = true; esto puede servir para el desarrollador para registrar en una base de datos y luego contabilizar cuantos fallos hubo, o hacer un debugging para saber que endpoints fallan más y por que.

* si el vehículo existe, se validan los datos nuevos que llegaron en el request (como marca, modelo, año, etc.) usando la función validarDatos para controlar que estén seteados, no vacíos, y en formato correcto.

* luego se actualiza el vehículo con updateModelCar(...), pasando todos los datos nuevos junto con el id correspondiente, que es necesario para el UPDATE desde la base de datos de model y sepa que vehículo va a actualizar.

* finalmente, se vuelve a buscar el vehículo ya actualizado y se devuelve en la respuesta formato JSON junto con un mensaje de éxito, el código 200, el error = false en este caso, y data = $modelo para que muestre los datos del vehículo ya actualizados.

* http://localhost/web2/TPE_3/api/vehiculos/:id es el endpoint  y permite mantener actualizada la información de los autos en la concesionaria. Hay que ingresar todos los datos nuevamente, con sus modificaciones, desde el 'body raw' en formato JSON .

*** Ejemplo  de uso ***

Solicitud:

PUT http://localhost/web2/api/vehiculos/:id


Body (JSON) (campos actiales):

{
  "id_marca": 2,
  "modelo": "Road POWER",
  "anio": 2025,
  "km": 10,
  "precio": 10000,
  "patente": "ZTE 123 FK",
  "es_nuevo": 0,
  "imagen": "imagenautodsdd",
  "vendido": 0
}

Body (JSON) (campos actualizados):

{
  "id_marca": 3,
  "modelo": "Road full",
  "anio": 2024,
  "km": 100,
  "precio": 10,
  "patente": "ZTE 123 FK",
  "es_nuevo": 0,
  "imagen": "hfoashf",
  "vendido": 0
}

(todo esto es solo un ejemplo).

### PATCH /vehiculos/:id

## paso a paso del PATCH?

obtiene el ID del vehículo desde los parámetros de la URL ($req->params->id)

busca el vehículo en la base de datos usando ese ID. Si no existe, devuelve respuesta en formato JSON con el código de error 404, un mensaje claro y un registro del error

lee el contenido bruto del HTTP con file_get_contents('php://input') y lo decodifica desde JSON a un array asociativo ($input). Permite acceder a los campos enviados por el cliente

filtra los campos permitidos: solo se consideran válidos los campos definidos en $allowedFields ('tipo', 'marca', 'modelo', 'anio', 'km', 'precio', 'patente', 'es_nuevo', 'imagen', 'vendido'). Esto evita que se actualicen campos no autorizados o inexistentes

valida que haya al menos un campo válido. Si no se envió ninguno, responde con un error 400 indicando que no se enviaron campos válidos

ejecuta la actualización usando el método patchField del modelo mediante $this->model->patchField($id, $data), que aplica la actualización en la base de datos

vuelve a consultar el vehículo actualizado y lo devuelve en la respuesta en formato JSON junto con un mensaje de éxito, código HTTP 200 de éxito, y muestra el array "data" con la nueva infomación del vehículo

http://localhost/web2/TPE_3/api/vehiculos/:id es el endpoint con el id del vehículo a modificar para ingresar y hacer cambio de 1 dato o mas de 1 desde el 'body raw' mediante formato JSON 


### DELETE /vehiculos/:id

Descripción:
Elimina un vehículo existente del sistema utilizando su ID.

**Ejemplo de uso:**

DELETE http://localhost/web2/api/vehiculos/5


Respuesta exitosa:

{ "mensaje": "El veiculo id= $id eliminado con éxito", 204 }


Error (Vehiculo con ID no existente):

{ "error": "El vehiculo con el id= $id no existe", 404 }


#### Códigos de respuesta HTTP: 

- 200 OK: Solicitud exitosa.

- 201 Created: Recurso creado correctamente.

- 204 No Content: La petición se ha completado con éxito pero su respuesta no tiene ningún contenido.

- 400 Bad Request: Datos faltantes o formato incorrecto.

- 401 Unauthorized: Es necesario autenticar para obtener la respuesta solicitada.

- 404 Not Found: El recurso solicitado no existe.

- 409 Conflict: La petición tiene conflicto con el estado actual del servidor.

- 500 Internal Server Error: Error en el servidor.