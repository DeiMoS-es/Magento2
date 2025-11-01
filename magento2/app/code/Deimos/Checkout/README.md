# Deimos_Checkout (módulo de ejemplo)

Módulo de ejemplo que añade un plugin para registrar un log cuando la dirección de envío tiene country_id = 'US'.

Instalación rápida:

1. php bin/magento setup:upgrade
2. php bin/magento cache:flush

Prueba: realiza un checkout con dirección de envío en Estados Unidos y comprueba `var/log/system.log`.
