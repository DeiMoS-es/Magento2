#!/bin/bash
if ! command -v warden &> /dev/null; then
  echo "❌ Warden no está instalado o no está en el PATH."
  exit 1
fi


# 🚀 Magento 2 + Warden Setup Script
# Autor: Nagib
# Fecha: 2025-10-18
# Requisitos: Warden instalado, Docker activo, Ubuntu con systemd-resolved configurado

# 📁 1. Crear directorio del proyecto
mkdir -p ~/Sites/magento2
cd ~/Sites/magento2 || exit

# ⚙️ 2. Inicializar entorno Warden
warden env-init ecomerce magento2

# 🔐 3. Firmar certificado SSL
warden sign-certificate ecomerce.test

# 🚀 4. Levantar entorno
warden env up

# 🐚 5. Entrar al contenedor PHP y ejecutar comandos internos
warden shell <<'EOF'

# 🔑 6. Configurar credenciales de Magento Marketplace
composer global config http-basic.repo.magento.com <PUBLIC_KEY> <PRIVATE_KEY>

# 📥 7. Descargar Magento en /tmp y moverlo a /var/www/html
composer create-project --repository-url=https://repo.magento.com/ \
  magento/project-community-edition /tmp/ecomerce

rsync -a /tmp/ecomerce/ /var/www/html/
rm -rf /tmp/ecomerce/

# ⚙️ 8. Instalar Magento
bin/magento setup:install \
  --backend-frontname=backend \
  --amqp-host=rabbitmq \
  --amqp-port=5672 \
  --amqp-user=guest \
  --amqp-password=guest \
  --db-host=db \
  --db-name=magento \
  --db-user=magento \
  --db-password=magento \
  --search-engine=opensearch \
  --opensearch-host=opensearch \
  --opensearch-port=9200 \
  --opensearch-index-prefix=magento2 \
  --opensearch-enable-auth=0 \
  --opensearch-timeout=15 \
  --http-cache-hosts=varnish:80 \
  --session-save=redis \
  --session-save-redis-host=redis \
  --session-save-redis-port=6379 \
  --session-save-redis-db=2 \
  --session-save-redis-max-concurrency=20 \
  --cache-backend=redis \
  --cache-backend-redis-server=redis \
  --cache-backend-redis-db=0 \
  --cache-backend-redis-port=6379 \
  --page-cache=redis \
  --page-cache-redis-server=redis \
  --page-cache-redis-db=1 \
  --page-cache-redis-port=6379

# 🔐 9. Crear usuario administrador
ADMIN_PASS="$(pwgen -n1 16)"
ADMIN_USER=localadmin

bin/magento admin:user:create \
  --admin-password="${ADMIN_PASS}" \
  --admin-user="${ADMIN_USER}" \
  --admin-firstname="Local" \
  --admin-lastname="Admin" \
  --admin-email="${ADMIN_USER}@example.com"

printf "u: %s\np: %s\n" "${ADMIN_USER}" "${ADMIN_PASS}"

# 🚫 10. Desactivar 2FA
bin/magento module:disable Magento_AdminAdobeImsTwoFactorAuth Magento_TwoFactorAuth
bin/magento setup:upgrade
bin/magento cache:flush

# 🌐 11. Configurar URLs
bin/magento config:set --lock-env web/unsecure/base_url "https://ecomerce.test/"
bin/magento config:set --lock-env web/secure/base_url "https://ecomerce.test/"
bin/magento config:set --lock-env web/secure/use_in_frontend 1
bin/magento config:set --lock-env web/secure/use_in_adminhtml 1
bin/magento config:set --lock-env web/secure/offloader_header X-Forwarded-Proto
bin/magento config:set --lock-env web/seo/use_rewrites 1
bin/magento config:set --lock-env system/full_page_cache/caching_application 2
bin/magento config:set --lock-env system/full_page_cache/ttl 604800
bin/magento config:set --lock-env catalog/search/enable_eav_indexer 1
bin/magento config:set --lock-env dev/static/sign 0

# ✅ Verificación final de Magento 2 + Warden

# Verifica que el frontend esté accesible
# Debe mostrar la tienda sin errores
xdg-open https://ecomerce.test/

# Verifica que el backend esté accesible
xdg-open https://ecomerce.test/backend

# Si el frontend muestra un error 404:
# 1. Verifica que pub/index.php existe
ls -la /var/www/html/pub/index.php

# 2. Asegúrate de que las URLs base están configuradas
bin/magento config:set --lock-env web/unsecure/base_url "https://ecomerce.test/"
bin/magento config:set --lock-env web/secure/base_url "https://ecomerce.test/"
bin/magento config:set --lock-env web/secure/use_in_frontend 1
bin/magento config:set --lock-env web/secure/use_in_adminhtml 1
bin/magento config:set --lock-env web/secure/offloader_header X-Forwarded-Proto
bin/magento config:set --lock-env web/seo/use_rewrites 1

# 3. Genera contenido estático y limpia caché
bin/magento setup:static-content:deploy -f
bin/magento cache:flush

# 4. Reinicia el entorno desde tu máquina host
exit
warden env down
warden env up



# 🧪 12. Activar modo desarrollador y limpiar caché
bin/magento deploy:mode:set -s developer
bin/magento cache:disable block_html full_page
bin/magento indexer:reindex
bin/magento cache:flush

EOF

# ✅ Fin del script
echo -e "\nMagento 2 instalado correctamente en https://ecomerce.test/backend"
echo -e "\nFrontend disponible en https://ecomerce.test/"