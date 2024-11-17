# Desarrollo
## PixFood

### Descripción del Proyecto
El objetivo del trabajo fue desarrollar un software integral para un restaurante ficticio llamado **PixFood**, que permita a los clientes acceder a información relevante (comidas principales, localización, contacto) y realizar dos acciones principales para consumo:  
- **Consumo en el local**  
- **Pedidos para entrega a domicilio**

### Tecnologías Utilizadas
- **PHP**: Para la lógica de negocio y la interacción con la base de datos.  
- **MySQL**: Almacenamiento de información como menús, mesas y pedidos.  
- **JavaScript**: Interactividad del cliente, como actualización dinámica del estado de mesas y visualización de menús.  
- **HTML/CSS**: Diseño responsivo y atractivo para la interfaz de usuario.

### Funcionalidades Principales
#### Para Delivery (Entrega a Domicilio):
- Visualización del menú para pedidos.  
- Selección de productos, realización de pagos y opción de entrega a domicilio.

#### Para el Local Físico:
- **Visualización de Mesas**: Estado (disponibles u ocupadas) para facilitar la elección.  
- **Selección de Menú**: Los clientes pueden elegir platos para consumir en el local.  
- **Llamada al Mozo**: Botón para solicitar atención personalizada.

#### Funcionalidades de Administrador:
- Panel para gestionar órdenes, empleados, mesas disponibles e ítems del menú.

### Implementaciones Técnicas
#### Patrón MVC
El proyecto sigue el patrón Modelo-Vista-Controlador para una correcta separación de responsabilidades, facilitando el mantenimiento y escalabilidad del código.

#### Diseño Responsivo
- **Menú de Hamburguesa**: Alterna entre abierto/cerrado al hacer clic en el ícono.

#### Uso de LocalStorage
- **Modo de Entrega o Retiro**: Configuración persistente entre recargas para aplicar costos adecuados en el carrito.  
- **Persistencia del Carrito**: El contenido del carrito se guarda y recupera automáticamente entre sesiones.

#### Gestión de Sesiones
- Control de acceso para empleados y administradores.  
- Roles diferenciados para visualización y edición de datos.

#### Triggers en la Base de Datos
- **Eliminación Lógica**: Actualiza la fecha de baja automáticamente al desactivar un usuario.  
- **Liberación de Mesas**: Libera la mesa asociada cuando el estado del pedido cambia a "pagado".

#### Eliminación Lógica
Los registros no se eliminan físicamente; en su lugar, se utiliza un atributo `activo` para marcar su estado.

### Conclusión
El desarrollo del sistema **PixFood** ha proporcionado una solución integral para la gestión de un restaurante, ofreciendo una experiencia fluida y eficiente tanto para clientes como para el personal.  
Gracias al uso de tecnologías modernas, se ha logrado crear un entorno interactivo y responsivo que optimiza la gestión de pedidos, mesas y menús.

Aunque el sistema está en una fase avanzada, continuará en desarrollo para incorporar nuevas funcionalidades y mejoras que satisfagan las necesidades cambiantes del restaurante.
