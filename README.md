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

Copiar el proyecto dentro de la carpeta htdocs de XAMPP.

Crear una base de datos en phpMyAdmin e importar el archivo concesionaria.sql incluido en el proyecto.

Configurar los datos de conexión en app/config/config.php (host, usuario, contraseña y nombre de base)-> todo esta en predeterminadao (ya configurado avisar si hay probleas al ingresar) .

Iniciar Apache y MySQL, luego acceder desde el navegador a:
 http://localhost/TPE1/

Usuario administrador:

Usuario: webadmin@gmail.com

Contraseña: admin


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

Descripción:
Actualiza la información de un vehículo existente identificado por su ID.
Se deben enviar los nuevos datos del vehículo en formato JSON.

Datos requeridos:

marca (string)

modelo (string)

anio (integer)

**Ejemplo de uso:**

PUT http://localhost/web2/api/vehiculos/5


Body (JSON):

{
  
}


Respuesta exitosa:

{ "mensaje": "Vehículo actualizado correctamente" }


Error (ID no existente):

{ "error": "Vehículo no encontrado." }

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