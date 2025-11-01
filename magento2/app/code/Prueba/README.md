Para buscar un ejemplo del registration.php, podemos ir a la carpeta del vendor de Magento y ver como registra un módulo.
Dentro de la clase  ComponentRegistrar tenemos los distintos tipos de componentes que podemos registrar, en este caso un módulo (MODULE).

Ficheros mínimos para activar un módulo:
- registration.php
- etc/module.xml
- README.md (opcional pero recomendable para documentar el módulo)
bin/magento | grep module --> muestra los módulos instalados y su estado (habilitado/deshabilitado).
bin/magento module:enable Prueba_HelloWorld --> habilita el módulo.

TODO:
- Modificar agents.md para que cuando le diga que quiero crear un módulo nuevo en magento, me cree estos ficheros mínimos. Actualiznado también el README.md con instrucciones básicas de instalación y prueba. Y las rutas en los distintos archivos.