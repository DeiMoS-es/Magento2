# 🛠️ Warden Setup (solo una vez por máquina)

# Instalar Warden (si no lo tienes)
brew tap davidalger/warden
brew install warden

# Instalar certificados y túnel SSH
warden install

# Configurar DNS local para dominios `.test`
sudo mkdir -p /etc/dnsmasq.d
echo -e "address=/.test/127.0.0.1\nserver=1.1.1.1\nserver=8.8.8.8" | sudo tee /etc/dnsmasq.d/warden
sudo systemctl restart dnsmasq

# Desactivar systemd-resolved y usar dnsmasq como DNS
sudo systemctl disable systemd-resolved
sudo systemctl stop systemd-resolved
sudo rm /etc/resolv.conf
echo "nameserver 127.0.0.1" | sudo tee /etc/resolv.conf

# Verificar resolución DNS externa
docker run busybox nslookup google.com
ping google.com

# Iniciar servicios globales de Warden
warden svc up

# ✅ Crear nuevo proyecto Warden (por cada proyecto)

# Crear carpeta del proyecto
mkdir -p ~/sites/MiProyecto && cd ~/sites/MiProyecto

# Inicializar entorno (Magento 2 en este ejemplo)
warden env-init magento2 miproyecto.test

# ⚠️ Editar .env si el nombre tiene puntos
nano .env
# Cambiar WARDEN_ENV_NAME=miproyecto.test → WARDEN_ENV_NAME=miproyecto

# Arrancar entorno
warden env up

# Instalar Magento manualmente dentro del contenedor
warden shell
composer create-project --repository-url=https://repo.magento.com magento/project-community-edition .


# 🧱 Crear nuevo proyecto Magento 2 con Warden (estructura por subcarpeta)

# Crear carpeta del proyecto
mkdir -p ~/sites/Magento2/trendcommerce
cd ~/sites/Magento2/trendcommerce

# Inicializar entorno Magento 2
warden env-init magento2

# (Opcional) Editar .env si el nombre tiene puntos
nano .env
# Asegúrate de tener:
# WARDEN_ENV_TYPE=magento2
# WARDEN_ENV_NAME=trendcommerce

# Levantar entorno
warden env up

# Entrar al contenedor
warden shell

# Instalar Magento con Composer
composer create-project --repository-url=https://repo.magento.com magento/project-community-edition .

# ⚠️ Si el directorio no está vacío, instala en una subcarpeta y luego copia los archivos:
mkdir /var/www/magento && cd /var/www/magento
composer create-project --repository-url=https://repo.magento.com magento/project-community-edition .
cp -R /var/www/magento/* /var/www/html/
cp -R /var/www/magento/.htaccess /var/www/html/
cp -R /var/www/magento/.user.ini /var/www/html/
rm -rf /var/www/magento
