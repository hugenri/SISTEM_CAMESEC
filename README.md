
# SISTEM CAMESEC
SISTEM CAMESEC es una plataforma web desarrollada para gestionar la instalación, monitoreo y mantenimiento de equipos de seguridad, tales como cámaras de vigilancia, sistemas de monitoreo, y alarmas, utilizados por empresas dedicadas a la instalación de estos dispositivos. Este sistema permite realizar seguimientos completos de los equipos, registrar órdenes de compra, cotizaciones y facturas, y gestionar toda la información relacionada con clientes, productos y proveedores.
Descripción
SISTEM CAMESEC está diseñado para facilitar a las empresas de seguridad la gestión de su infraestructura de equipos y servicios. Permite administrar el ciclo completo del equipo de seguridad desde su instalación, mantenimiento, hasta su monitoreo. Además, maneja cotizaciones, facturación y órdenes de compra, todo centralizado en una plataforma fácil de usar.
Características
    • Gestión de Clientes: Mantén registros detallados de tus clientes, con campos como nombre, dirección, contacto, RFC, etc.
    • Cotizaciones y Facturas: Genera cotizaciones para tus clientes y sigue el proceso de facturación de cada venta.
    • Órdenes de Compra: Registra las órdenes de compra realizadas a proveedores para el abastecimiento de equipos.
    • Gestión de Equipos de Seguridad: Controla y realiza un seguimiento completo de la instalación y mantenimiento de los equipos.
    • Mantenimiento Preventivo y Correctivo: Programación de mantenimientos preventivos y resolución de incidencias relacionadas con los equipos.
    • Monitoreo de Productos: Realiza el seguimiento de productos como cámaras, alarmas y otros dispositivos, y gestiona su stock.
    • Gestión de Proveedores: Registra y administra los proveedores que suministran equipos y servicios.
    • Control de Servicios: Gestiona los servicios prestados, como instalación o reparaciones de los equipos.
Base de Datos
La estructura de la base de datos está compuesta por varias tablas clave para garantizar un control eficiente de los equipos, clientes, cotizaciones y más:
    • Clientes: cliente
        ◦ Registra la información básica del cliente, como nombre, dirección, teléfono, correo electrónico y RFC.
    • Cotizaciones: cotizaciones
        ◦ Detalla las cotizaciones generadas para los clientes, incluyendo subtotales, impuestos, descuentos y costos de instalación.
    • Facturas: facturas
        ◦ Relacionadas con las cotizaciones, las facturas reflejan el cobro y el estado de los pagos de cada cliente.
    • Órdenes de Compra: orden_compras
        ◦ Registra las compras de equipos realizadas a proveedores, asociadas a cotizaciones previas.
    • Productos: producto
        ◦ Información sobre los equipos y productos disponibles para instalar, incluyendo nombre, descripción, precio, y cantidad en stock.
    • Proveedores: proveedor
        ◦ Registra a los proveedores de productos y servicios relacionados con la seguridad, incluyendo sus datos de contacto y categoría.
    • Servicios: servicios
        ◦ Mantenimientos y otros servicios prestados a los equipos, registrados junto con su estado y fecha.
    • Solicitudes de Cotización: solicitudes_cotizacion
        ◦ Los clientes pueden realizar solicitudes de cotización para ciertos productos o servicios relacionados con la seguridad.
Instalación y Configuración
Requisitos del sistema
    • PHP 7.4 o superior: Para el backend.
    • MySQL o MariaDB: Base de datos compatible (MySQL 5.7 o superior).
    • Servidor Web: Apache o Nginx (con soporte para PHP).
    • Bootstrap 5: Para la interfaz de usuario (frontend).
    • JavaScript: Para funcionalidades dinámicas de la interfaz.
Pasos para la instalación:
    1. Clonar el repositorio:
       git clone https://github.com/tu-usuario/sistem-camesec.git
    2. Configurar el servidor:
        ◦ Coloca los archivos del proyecto en la carpeta del servidor web, como htdocs en XAMPP o el directorio de tu servidor Nginx.
    3. Configurar la base de datos:
        ◦ Crea una base de datos en MySQL/MariaDB, por ejemplo camesec_db.
       CREATE DATABASE camesec_db;
        ◦ Importa el esquema de la base de datos desde el archivo db_schema.sql en el repositorio o desde el archivo que contenga el volcado de la base de datos proporcionado.
    4. Configurar el archivo de conexión:
        ◦ Ajusta las credenciales de la base de datos en el archivo config.php para que coincidan con tu configuración local.
    5. Configurar el servidor de correo (si es necesario):
        ◦ Si se van a enviar notificaciones por correo electrónico, configura un servidor SMTP para el envío de emails (p. ej. Gmail, Mailgun, etc.).
    6. Acceder al sistema:
        ◦ Después de la configuración, abre tu navegador y accede a la URL correspondiente (por ejemplo, http://localhost/sistem-camesec).
Funcionalidades Principales
1. Gestión de Clientes
    • Registra y edita la información de los clientes, incluyendo su dirección, teléfono, correo electrónico y RFC.
    • Los clientes pueden realizar solicitudes de cotización a través de la plataforma.
2. Gestión de Cotizaciones
    • Genera cotizaciones detalladas para los productos y servicios solicitados por los clientes.
    • Aplica impuestos, descuentos y costos de instalación.
    • Las cotizaciones pueden convertirse en facturas una vez aprobadas.
3. Facturación
    • Genera y gestiona facturas asociadas a las cotizaciones.
    • Las facturas tienen estados como "pendiente" o "pagada".
4. Órdenes de Compra
    • Registra las compras de equipos de seguridad a los proveedores para cumplir con las solicitudes de los clientes.
    • Cada orden de compra está vinculada a una cotización específica.
5. Mantenimiento y Servicios
    • Registra los mantenimientos preventivos o correctivos realizados a los equipos de seguridad.
    • Registra los servicios realizados, como instalaciones o reparaciones, y su estado.
6. Gestión de Proveedores
    • Lleva un registro de los proveedores que suministran equipos y servicios de seguridad, y sus detalles de contacto.
7. Productos
    • Registra los productos disponibles para ser instalados, como cámaras, alarmas, sensores y otros dispositivos.
    • Monitorea el stock de productos y los detalles de cada uno.
8. Monitoreo de Equipos
    • Permite hacer un seguimiento de los equipos instalados, incluyendo el estado de funcionamiento y la fecha de instalación.
Tecnologías Utilizadas
    • Backend: PHP para la gestión de la lógica y la interacción con la base de datos.
    • Frontend: HTML, CSS y Bootstrap 5 para crear una interfaz de usuario moderna y responsiva.
    • Base de Datos: MySQL/MariaDB para almacenar toda la información relacionada con los clientes, productos, cotizaciones y más.
    • JavaScript: Para funcionalidades dinámicas y validaciones en la interfaz de usuario.
    • PHPMyAdmin o HeidiSQL: Herramientas recomendadas para gestionar la base de datos.
Contribuciones
Si deseas contribuir al proyecto, sigue estos pasos:
    1. Fork el repositorio.
    2. Crea una nueva rama para tus cambios (git checkout -b feature/nueva-funcionalidad).
    3. Realiza tus cambios y haz commit (git commit -am 'Añadir nueva funcionalidad').
    4. Sube tus cambios (git push origin feature/nueva-funcionalidad).
    5. Envía un Pull Request con una descripción detallada de los cambios.
