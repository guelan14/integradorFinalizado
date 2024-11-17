DESARROLLO
PixFood
El objetivo del trabajo fue desarrollar un software integral para un restaurante ficticio llamado
“PixFood"que permita a los clientes acceder a información relevante (comidas principales,
información, localización, contacto) y realizar dos acciones principales para consumo, tanto si están
presentes en el local como si prefieren realizar pedidos para entrega a domicilio
Tecnologías Utilizadas
El desarrollo de este sistema se realizó utilizando las siguientes tecnologías:
● PHP: Lenguaje de programación del lado del servidor utilizado para gestionar la lógica de
negocio y la interacción con la base de datos.
● MySQL: Sistema de gestión de bases de datos utilizado para almacenar toda la información del
restaurante, como los menús, las mesas y los pedidos.
● JavaScript: Lenguaje de programación utilizado para gestionar la interactividad en el lado del
cliente, como la actualización dinámica del estado de las mesas y la visualización de menús.
● HTML/CSS: Tecnologías utilizadas para estructurar y diseñar la interfaz de usuario,
asegurando que el sitio sea responsivo y visualmente atractivo.
Funcionalidades Principales del Sistema
El sistema ofrece las siguientes funcionalidades tanto para clientes presentes en el local como
para aquellos que deseen hacer pedidos para entrega a domicilio:
Funcionalidades para Delivery (Entrega a Domicilio):
● Los clientes pueden acceder a una página específica donde se les muestra el menú disponible
para pedidos a domicilio.
3
CARRERA: Ingeniería en Sistemas de Información MATERIA: Paradigmas de Programacion III
COMISIÓN: “U”(Única) A PROFESOR: Mgter. Ing. Agustín Encina
ESTUDIANTES: Neumann Miguel Angel FECHA: 13/11/2024
● Pueden seleccionar los productos que desean pedir, realizar el pago y optar por la opción de
entrega a domicilio.
Funcionalidades para el Local Físico (Clientes en el Restaurante):
● Visualización de Mesas: Los clientes pueden ver el estado de las mesas, si están disponibles u
ocupadas, para que puedan elegir una mesa disponible al llegar.
● Selección de Menú: Una vez sentados, los clientes pueden visualizar el menú del restaurante y
elegir los platos que desean consumir.
● Llamada al Mozo: Los clientes tienen la opción de presionar un botón para solicitar la
atención del mozo, facilitando el servicio en la mesa.
Funcionalidades de Administrador:
● Ofrece un panel de administrador para poder visualizar y administrar las órdenes, empleados,
mesas disponibles, ítems del menú del restaurante.
Implementación del Patrón Vista, Modelo, Controlador (MVC)
El proyecto sigue el patrón Vista, Modelo, Controlador (MVC) para asegurar una correcta
separación de responsabilidades y facilitar el mantenimiento del código a largo plazo.
Implementación responsive
Se añadieron funcionalidades responsivas para poder ingresar desde cualquier dispositivo,
como por ejemplo:
● Alternancia del menú de hamburguesa: Se puede cerrar o abrir el menú de navegación cuando
el usuario hace clic en el icono de hamburguesa.
Implementación de localstorage
Se utilizó el método de guardado de localstorage para poder realizar distintas funciones, entre
4
CARRERA: Ingeniería en Sistemas de Información MATERIA: Paradigmas de Programacion III
COMISIÓN: “U”(Única) A PROFESOR: Mgter. Ing. Agustín Encina
ESTUDIANTES: Neumann Miguel Angel FECHA: 13/11/2024
estas:
● Modo de entrega o retiro: Se puede alternar entre el modo de "delivery" (con costo de entrega)
y "retiro" (sin costo de entrega). Esta configuración se guarda en el localStorage, lo que permite
que persista entre recargas de página. Al cambiar entre los modos, también se actualiza la
interfaz del carrito con los costos correspondientes.
● Persistencia del carrito: Se ha implementado la funcionalidad para guardar y cargar el
contenido del carrito desde localStorage, lo que permite que el usuario no pierda su carrito
aunque cierre la página.
Implementación de Session:
Se utiliza sesión para poder controlar que solamente los empleados o administradores puedan
acceder y editar contenidos de la base de datos del sistema. También se crearon roles para que
solamente el administrador (jefe) pueda ver a todos los empleados y además la creación de estos.
Triggers
Se implementaron triggers dentro de la base de datos, como por ejemplo:
● Actualización de la eliminación lógica:
Cada vez que un usuario se marque como inactivo (activo cambia de TRUE a FALSE), se
actualizará automáticamente el campo fecha_baja con la fecha y hora exacta en que ocurrió ese
cambio.
● Actualización de mesas
Este trigger se activa después de actualizar una fila en la tabla orders (especificado por AFTER
UPDATE). Su propósito es liberar una mesa asociada con una orden cuando el estado de la orden
cambia a pagado (status = 'paid').
5
CARRERA: Ingeniería en Sistemas de Información MATERIA: Paradigmas de Programacion III
COMISIÓN: “U”(Única) A PROFESOR: Mgter. Ing. Agustín Encina
ESTUDIANTES: Neumann Miguel Angel FECHA: 13/11/2024
Eliminación Lógica
Se implementó la eliminación lógica mediante un atributo denominado activo en las tablas
correspondientes del sistema. En lugar de eliminar físicamente los registros, se marcó el estado de cada
registro a través de este atributo, el cual indica si el registro está activo o inactivo. De esta manera, los
registros eliminados lógicamente permanecen en la base de datos, pero no se consideran en las
operaciones normales del sistema
Conclusión
En conclusión, el desarrollo del sistema PixFood ha permitido crear una solución integral para
la gestión de un restaurante, proporcionando tanto a los clientes como al personal una experiencia
eficiente y fluida, ya sea para pedidos a domicilio o para los que se encuentran en el local.
A través de la implementación de tecnologías como PHP, MySQL, JavaScript, HTML y CSS,
se logró crear un entorno interactivo, responsivo y fácil de usar, donde se garantiza la correcta gestión
de pedidos, mesas y menús, utilizando eliminación lógica.
Cabe destacar que, aunque el sistema ha alcanzado un avance significativo, aún no está completamente
terminado y continúa en desarrollo. Se seguirán implementando nuevas funcionalidades y mejoras para
optimizar la experiencia del usuario y adaptarse a las necesidades cambiantes del restaurante.
