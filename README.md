🔐
SISTEM CAMESEC es una plataforma web diseñada para gestionar la instalación, monitoreo y mantenimiento de equipos de seguridad como cámaras, alarmas y sistemas de vigilancia. Está orientado a empresas que instalan y mantienen estos dispositivos, facilitando el seguimiento de equipos, gestión de clientes, cotizaciones, órdenes de compra y facturación.

📖 Descripción
Esta plataforma centraliza todos los procesos operativos de una empresa de seguridad: desde la gestión de clientes y proveedores, hasta el mantenimiento de equipos, cotizaciones, monitoreo y más. Su objetivo es mejorar la eficiencia operativa y la trazabilidad del servicio prestado.

✨ Características Principales
    • Gestión de Clientes: Registro completo de clientes (nombre, contacto, dirección, RFC, etc.).
    • Cotizaciones y Facturas: Generación de cotizaciones detalladas, con impuestos, descuentos y costos de instalación; conversión a facturas.
    • Órdenes de Compra: Registro de compras a proveedores asociadas a cotizaciones.
    • Gestión de Equipos: Seguimiento de equipos instalados, mantenimientos y estado.
    • Mantenimiento Preventivo/Correctivo: Registro de servicios realizados con fechas y estatus.
    • Monitoreo de Productos: Gestión de stock de cámaras, alarmas, sensores, etc.
    • Gestión de Proveedores: Registro completo de proveedores y su categoría.
    • Control de Servicios: Instalaciones, reparaciones y otros servicios realizados.

🗃️ Estructura de Base de Datos
Tablas principales:
    • cliente: Información general del cliente.
    • cotizaciones: Detalles de cotizaciones (precios, impuestos, descuentos).
    • facturas: Facturas derivadas de cotizaciones y su estado de pago.
    • orden_compras: Órdenes de compra realizadas a proveedores.
    • producto: Equipos de seguridad disponibles para instalación.
    • proveedor: Proveedores de productos/servicios.
    • servicios: Registros de mantenimiento o instalación.
    • solicitudes_cotizacion: Solicitudes enviadas por los clientes.

⚙️ Requisitos del Sistema
    • PHP: Versión 7.4 o superior
    • Base de Datos: MySQL o MariaDB (5.7+)
    • Servidor Web: Apache o Nginx con soporte PHP
    • Frontend: HTML, CSS, Bootstrap 5
    • JavaScript: Para interactividad en formularios

🚀 Instalación y Configuración
1. Clonar el repositorio
git clone https://github.com/tu-usuario/sistem-camesec.git
2. Configurar el servidor web
Coloca los archivos del proyecto en el directorio raíz del servidor (por ejemplo, htdocs en XAMPP).
3. Crear la base de datos
CREATE DATABASE camesec_db;
Importa el archivo db_schema.sql incluido en el proyecto.

5. (Opcional) Configurar servidor de correo
Si se usarán notificaciones por correo, configura un servidor SMTP (Gmail, Mailgun, etc.) en el archivo correspondiente.
6. Ejecutar el sistema
Abre tu navegador y accede a:
http://localhost/sistem-camesec

🧩 Funcionalidades Detalladas
1. Gestión de Clientes
    • Registro y edición de clientes.
    • Solicitudes de cotización por parte del cliente.
2. Cotizaciones
    • Cotizaciones personalizadas con impuestos, descuentos y costos de instalación.
    • Transformación de cotizaciones en facturas.
3. Facturación
    • Facturas con estado (pendiente, pagada).
    • Gestión de pagos asociados a cotizaciones.
4. Órdenes de Compra
    • Asociadas a cotizaciones aprobadas.
    • Control de abastecimiento de equipos.
5. Mantenimiento y Servicios
    • Mantenimiento preventivo y correctivo.
    • Registro del servicio, estado y fecha.
6. Gestión de Proveedores
    • Registro de proveedores, contacto y categoría.
7. Productos
    • Gestión del stock de productos.
    • Registro de detalles: nombre, descripción, precio, cantidad.
8. Monitoreo de Equipos
    • Seguimiento de estado, fecha de instalación y ubicación.

🛠️ Tecnologías Utilizadas
    • PHP: Backend y lógica del sistema.
    • MySQL/MariaDB: Almacenamiento de datos.
    • HTML/CSS/Bootstrap 5: Interfaz responsiva y moderna.
    • JavaScript: Funciones interactivas en el frontend.
    • phpMyAdmin / HeidiSQL: Administración de base de datos.

🤝 Contribuciones
¡Eres bienvenido a contribuir! Sigue estos pasos:
1. Fork este repositorio
2. Crea una nueva rama:
   git checkout -b feature/nueva-funcionalidad
3. Realiza tus cambios y haz commit:
   git commit -am "Añadir nueva funcionalidad"
4. Sube tu rama:
   git push origin feature/nueva-funcionalidad
5. Abre un Pull Request

