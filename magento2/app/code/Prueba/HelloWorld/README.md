# Prueba_HelloWorld — Módulo mínimo de ejemplo

Este directorio contiene un módulo de prueba con la estructura mínima requerida por Magento 2 para que el sistema lo reconozca.

Archivos incluidos (mínimo):

- `registration.php` — registro del módulo con ComponentRegistrar.
- `etc/module.xml` — declaración del módulo (nombre y dependencias opcionales).
- `composer.json` — metadata/autoload para desarrollo local.
- `Controller/Index/Index.php` — ejemplo de controlador frontend que imprime un texto de prueba.

Pasos para probar el módulo localmente:

1. Habilitar el módulo y ejecutar upgrade:

```bash
php bin/magento module:enable Prueba_HelloWorld
php bin/magento setup:upgrade
```

2. Limpiar caché:

```bash
php bin/magento cache:flush
```

3. Probar la URL frontend (ruta por defecto según el controller):

```
https://<tu-host>/prueba_helloworld/index/index
```

Notas:

- El controlador de ejemplo imprime `Hello World desde Index.php`. En producción deberías devolver un `ResultInterface` (por ejemplo `ResultPage`) en lugar de `echo`.
- `composer.json` facilita la instalación local y autoload; no es obligatorio para un módulo en `app/code`, pero es buena práctica si el módulo se redistribuye.
