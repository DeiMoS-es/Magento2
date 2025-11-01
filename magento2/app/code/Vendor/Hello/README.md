# Resumen del módulo
Cada parte cumple un rol concreto:

Archivo / Carpeta	Propósito
registration.php	Registra el módulo dentro del sistema Magento. Es la “firma” que le dice al framework que este módulo existe.
etc/module.xml	Define los metadatos del módulo: nombre, versión, dependencias, y en qué orden debe cargarse.
etc/frontend/routes.xml	Registra una ruta frontend (en este caso /hello) y la asocia al módulo (Vendor_Hello).
Controller/Index/Index.php	Controlador PHP que se ejecuta cuando se visita /hello. Sigue la convención PSR-4 (por eso va en mayúsculas).
view/frontend/templates/hello.phtml	Plantilla PHTML (HTML + PHP) que define el contenido visual que se renderiza.
🧩 2️⃣ Flujo interno de ejecución (resumen visual)

Magento detecta el módulo gracias a registration.php y module.xml.

routes.xml le dice al router de Magento:
“Si alguien entra a /hello, llama al módulo Vendor_Hello”.

Magento busca dentro del módulo un controlador con la ruta /Index/Index.php.

Ese controlador ejecuta su método execute().

execute() crea un objeto de tipo Page usando PageFactory.

Magento carga el layout y busca una plantilla (hello.phtml) para mostrarla.

El navegador muestra el contenido "Hola Magento — Demo".


🚀 Paso 3 — Añadir una vista real (layout + bloque + plantilla)

Hasta ahora, nuestro módulo muestra una página básica gracias al controlador y la plantilla.
Ahora vamos a hacerlo “a la manera Magento”, usando su arquitectura MVC-extendida:

Añadiremos un layout XML,

Crearemos un Block PHP (intermediario entre controlador y vista),

Y actualizaremos la plantilla .phtml para usar variables dinámicas.

Así aprenderás cómo Magento construye las páginas modularmente.