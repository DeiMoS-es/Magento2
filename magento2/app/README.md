# 👑 Estructura y Definiciones Completas del Directorio 'app/' en Magento 2
# ----------------------------------------------------------------------

# 📜 Listado 'ls -l app/'
-rw-r--r--  autoload.php
-rw-r--r--  bootstrap.php
drwxr-xr-x  design/
drwxr-xr-x  etc/
# drwxr-xr-x  code/ [A menudo creado en entornos de desarrollo]

# 📝 Explicaciones Detalladas de los Elementos Clave
# ---------------------------------------------------

## 1️⃣ Archivo: app/autoload.php
# -----------------------------
# **Función:** Script de arranque secundario.
# **Detalle:** Se utiliza principalmente en el **contexto de línea de comandos (CLI)**, como para algunas tareas del instalador o *scripts* personalizados que no cargan el *framework* completo. Se encarga de configurar el **mecanismo de *autoloading* de Composer** antes de que el *bootstrap* principal tome el control. **Es una capa inferior al `vendor/autoload.php`**.
# **Importancia:** Media. Crítico para algunas herramientas de *backend*.

## 2️⃣ Archivo: app/bootstrap.php
# ------------------------------
# **Función:** Punto de entrada principal para inicializar la aplicación.
# **Detalle:** Este script ejecuta el **proceso de *bootstrap*** de Magento: determina la aplicación a cargar (web, CLI, *setup*), inicializa el **Object Manager**, configura el manejo de errores, y establece el entorno de ejecución (`production`, `developer`, etc.). Es **el corazón del inicio de la aplicación** en casi todos los modos de operación.
# **Importancia:** Alta. Es un archivo esencial del *framework*.

## 3️⃣ Directorio: app/design/ 🎨
# ------------------------------
# **Función:** Almacena todos los **Themes (Temas)** de la tienda.
# **Detalle:** Contiene la capa de presentación (*View* en el patrón MVVM). Se subdivide en:
# * `frontend/`: Themes para la tienda que ven los clientes. Estructura: `app/design/frontend/Vendor/theme`.
# * `adminhtml/`: Themes para el área de administración (backend).
# **Trabajo Común:** Modificación de plantillas (`.phtml`), layouts (`.xml`), estilos y *assets* de diseño.
# **Importancia:** Alta para la experiencia de usuario y personalización visual.

## 4️⃣ Directorio: app/etc/ ⚙️
# ----------------------------
# **Función:** Contiene la **Configuración a nivel de Instancia/Global**.
# **Detalle:** Es uno de los directorios más críticos de la aplicación, guardando configuraciones que no son específicas de módulos individuales:
# * `env.php`: **Configuración sensible del Entorno**. Contiene credenciales de **conexión a la DB**, *backend frontName*, *session handler* y la ***crypt key***. **¡Debe estar fuera del repositorio si contiene datos sensibles!**
# * `config.php`: **Lista de Módulos**. Almacena una matriz de todos los módulos instalados y si están `enabled` o `disabled`. Se gestiona principalmente con el comando `bin/magento module:enable/disable`.
# **Nota:** Los archivos `di.xml` y `etc/*.xml` de configuración específicos de un módulo **no van aquí**; van dentro de cada módulo en `app/code/Vendor/Module/etc/`.
# **Importancia:** Crítica. Define el comportamiento y la conectividad de la instancia.

## 5️⃣ Directorio: app/code/ (Contexto de Desarrollo)
# -----------------------------
# **Función:** Aloja los módulos desarrollados **localmente**.
# **Detalle:** Aunque no está presente en una instalación por defecto, es el lugar canónico para los módulos que se están creando o personalizando fuera del ámbito de Composer. Estructura: `app/code/Vendor/Module`. **Es la alternativa para el desarrollo local a la carpeta `vendor/` (que contiene módulos de terceros instalados vía Composer).**
# **Importancia:** Crítica en entornos de desarrollo y para desarrolladores.


## Ejemplo de Módulo en app/code/
A continuación, se muestra un ejemplo básico de un módulo llamado `Vendor_Hello` ubicado en `app/code/Vendor/Hello/`.
### Archivo: app/code/Vendor/Hello/registration.php
```php
<?php
// Le indica a Magento que hay un módulo nuevo en esa ruta
\Magento\Framework\Component\ComponentRegistrar::register(
    \Magento\Framework\Component\ComponentRegistrar::MODULE,
    'Vendor_Hello',
    __DIR__
);
``` ### Archivo: app/code/Vendor/Hello/etc/module.xml
```xml
<!-- Este archivo define el módulo y su versión -->
<?xml version="1.0"?>
<config xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
        xsi:noNamespaceSchemaLocation="urn:magento:framework:Module/etc/module.xsd">
    <module name="Vendor_Hello" setup_version="1.0.0"/>
</config>
``` ### Descripción del Módulo
- **registration.php:** Registra el módulo `Vendor_Hello` con Magento, indicando su ubicación.
- **module.xml:** Define el módulo y su versión, permitiendo a Magento gestionar su instalación y actualizaciones.  
    __DIR__
);

# 1. Hacer que Magento detecte nuevos módulos e instalar esquemas si los hubiera
desde el contenedor de warden: warden shell
php bin/magento setup:upgrade

# 2. Opcional: volver a compilar DI (en dev no siempre es necesario; útil si entras en errores)
php bin/magento setup:di:compile

# 3. Limpiar caché
php bin/magento cache:flush

# 4. Comprobar estado del módulo (debería aparecer como enabled)
php bin/magento module:status Vendor_Hello


En Magento (y en cualquier framework moderno compatible con PSR-4), los nombres de carpetas y archivos dependen de para qué sirven:

🔹 Carpetas que contienen clases PHP (código que se autoload-ea)
→ Deben seguir exactamente el mismo nombre y mayúsculas/minúsculas que el namespace.

🔹 Carpetas de configuración, vistas o recursos (XML, PHTML, CSS, JS)
→ No contienen clases PHP, así que pueden (y deben) ir en minúsculas por convención.