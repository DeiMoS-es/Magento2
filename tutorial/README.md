# Tutorial Magento 2

## Comprobar la Conexión a la Base de Datos

Para asegurarte de que la conexión a la base de datos está funcionando correctamente, sigue estos pasos:

1. **Conéctate a la base de datos**:

    ```bash
    mariadb -h db -u magento -p
    ```

2. **Ingresa la contraseña**: `magento`.

3. **Ejecuta los siguientes comandos SQL**:
   
    ```sql
    SHOW DATABASES;
    USE magento;
    SHOW TABLES;
    ```

## Comandos Básicos de Magento

1. **Verificar la Versión de Magento**:

    ```bash
    bin/magento --version
    ```

2. **Limpiar la Caché de Magento**:

    ```bash
    bin/magento cache:clean
    bin/magento cache:flush
    ```

3. **Verificar el Estado del Sistema**:

    ```bash
    bin/magento setup:status
    ```

4. **Regenerar Archivos Estáticos**:

    ```bash
    bin/magento setup:static-content:deploy -f
    ```

5. **Verificar el Estado de los Módulos**:

    ```bash
    bin/magento module:status
    ```
6. **Actualizar la base de datos y los esquemas**:

    ```bash
    bin/magento setup:upgrade
    ```
---