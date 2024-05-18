# Aicoll
## Configuracion 
* Para iniciar el servidor con: 
    ``` 
        php artisan serve
    ```
* Para ejecutar los test:
    ```
        php artisan test
    ```
* Para validar los endpoints he creado una coleccion de postman que esta en la raiz del proyecto llamada "[Aicoll_Test.postman_collection.json](Aicoll_Test.postman_collection.json)"
* En la implementacion realizada se presenta una solucion al siguiente problema con los requerimientos solicitados
* Problema
    Se requiere gestionar los datos de la tabla empresas a través de Web Services que permitan agregar nuevas empresas, actualizar los datos de una empresa, consultar las empresas por nit, consultar todas las empresas registradas y borrar las empresas con estado inactivo..
    * La tabla Empresas deberá contener los siguientes campos:
         * nit
         * nombre
         * direccion
         * telefono
         * estado
    * Los campos que se pueden actualizar son:
         * nombre,
         * direccion
         * Telefono
         * estado

* Requerimientos tecnológicos y técnicos
    ● En el momento de crearse una empresa esta deberá crearse con estado ‘Activo’ por defecto.
    ● El nit debe ser único por lo tanto no puede estar duplicado
    ● Puede usarse cualquier motor de BD
    ● La lógica debe ser codificada utilizando Laravel y PHP
    ● Deben validarse los datos de entrada (tipo, valores permitidos, longitud)
    ● Subir la implementación a un repositorio público y compartir enlace.
 