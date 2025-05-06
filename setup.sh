#!/bin/bash

# ======================================================
# Script de inicialización para el proyecto Florida Cats
# ======================================================

# Colores para una mejor visualización en terminal
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[0;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Directorio actual
CURRENT_DIR=$(pwd)
PROJECT_DIR="$CURRENT_DIR"
PHP_SERVER_PORT=8000
MYSQL_USER="root"
MYSQL_PASSWORD=""
DB_NAME="gatos"

# Función para imprimir mensajes con formato
print_message() {
    echo -e "${BLUE}[INFO]${NC} $1"
}

print_success() {
    echo -e "${GREEN}[ÉXITO]${NC} $1"
}

print_warning() {
    echo -e "${YELLOW}[ADVERTENCIA]${NC} $1"
}

print_error() {
    echo -e "${RED}[ERROR]${NC} $1"
}

# Función para detectar el sistema operativo
detect_os() {
    case "$(uname -s)" in
        Linux*)     OS="Linux";;
        Darwin*)    OS="MacOS";;
        CYGWIN*)    OS="Windows";;
        MINGW*)     OS="Windows";;
        MSYS*)      OS="Windows";;
        *)          OS="Desconocido";;
    esac
    echo $OS
}

# Función para verificar si PHP está instalado
check_php() {
    if command -v php >/dev/null 2>&1; then
        PHP_VERSION=$(php -v | head -n 1 | cut -d' ' -f2)
        print_success "PHP $PHP_VERSION encontrado"
        return 0
    else
        print_error "PHP no está instalado"
        print_message "Por favor, instale PHP antes de continuar:"
        OS=$(detect_os)
        if [ "$OS" = "MacOS" ]; then
            print_message "  brew install php"
        elif [ "$OS" = "Linux" ]; then
            print_message "  sudo apt-get install php   # Para distribuciones basadas en Debian"
            print_message "  sudo yum install php       # Para distribuciones basadas en Red Hat"
        elif [ "$OS" = "Windows" ]; then
            print_message "  Descargue PHP desde https://windows.php.net/download/"
        fi
        return 1
    fi
}

# Función para verificar si MySQL está instalado
check_mysql() {
    if command -v mysql >/dev/null 2>&1; then
        MYSQL_VERSION=$(mysql --version | cut -d' ' -f3)
        print_success "MySQL $MYSQL_VERSION encontrado"
        return 0
    else
        print_error "MySQL no está instalado"
        print_message "Por favor, instale MySQL antes de continuar:"
        OS=$(detect_os)
        if [ "$OS" = "MacOS" ]; then
            print_message "  brew install mysql"
        elif [ "$OS" = "Linux" ]; then
            print_message "  sudo apt-get install mysql-server   # Para distribuciones basadas en Debian"
            print_message "  sudo yum install mysql-server       # Para distribuciones basadas en Red Hat"
        elif [ "$OS" = "Windows" ]; then
            print_message "  Descargue MySQL desde https://dev.mysql.com/downloads/installer/"
        fi
        return 1
    fi
}

# Función para obtener las credenciales de MySQL
get_mysql_credentials() {
    print_message "Configuración de acceso a MySQL"
    print_message "Por defecto, se intentará usar el usuario 'root' sin contraseña"
    read -p "¿Desea usar credenciales diferentes? (s/n): " change_credentials
    
    if [[ $change_credentials == "s" || $change_credentials == "S" ]]; then
        read -p "Usuario de MySQL [root]: " mysql_user
        MYSQL_USER=${mysql_user:-root}
        read -s -p "Contraseña de MySQL: " mysql_pass
        echo ""
        MYSQL_PASSWORD=${mysql_pass}
    fi
    
    # Verificar conexión
    print_message "Verificando conexión a MySQL..."
    if mysql -u"$MYSQL_USER" ${MYSQL_PASSWORD:+-p"$MYSQL_PASSWORD"} -e "SELECT 1" >/dev/null 2>&1; then
        print_success "Conexión a MySQL exitosa"
        return 0
    else
        print_error "No se pudo conectar a MySQL con las credenciales proporcionadas"
        return 1
    fi
}

# Función para iniciar el servidor MySQL
start_mysql() {
    print_message "Verificando si el servidor MySQL está ejecutándose..."
    
    # Intentar iniciar MySQL solo si la conexión no funciona
    if ! mysql -u"$MYSQL_USER" ${MYSQL_PASSWORD:+-p"$MYSQL_PASSWORD"} -e "SELECT 1" >/dev/null 2>&1; then
        print_message "Iniciando servidor MySQL..."
        OS=$(detect_os)
        if [ "$OS" = "MacOS" ]; then
            brew services start mysql
        elif [ "$OS" = "Linux" ]; then
            sudo service mysql start || sudo systemctl start mysqld
        elif [ "$OS" = "Windows" ]; then
            net start MySQL
        fi
        
        # Esperar unos segundos para que el servicio se inicie
        sleep 3
        
        # Verificar nuevamente si MySQL está corriendo
        if mysql -u"$MYSQL_USER" ${MYSQL_PASSWORD:+-p"$MYSQL_PASSWORD"} -e "SELECT 1" >/dev/null 2>&1; then
            print_success "Servidor MySQL iniciado correctamente"
        else
            print_error "No se pudo iniciar el servidor MySQL"
            get_mysql_credentials || {
                print_error "No se pudo establecer conexión con MySQL"
                exit 1
            }
        fi
    else
        print_success "El servidor MySQL ya está ejecutándose"
    fi
}

# Función para configurar la base de datos
setup_database() {    
    print_message "Configurando la base de datos..."
    
    # Crear archivo SQL temporal combinado con correcciones
    SQL_TEMP=$(mktemp)
    
    # Corregir CREATE TABLE carrito (hay un error en el archivo original donde dice REATE en lugar de CREATE)
    cat > "$SQL_TEMP" << EOL
CREATE DATABASE IF NOT EXISTS $DB_NAME;

USE $DB_NAME;

CREATE TABLE IF NOT EXISTS usuario (
  username VARCHAR(100) NOT NULL PRIMARY KEY, 
  contrasenya VARCHAR(100) NOT NULL, 
  nombre VARCHAR(100) NOT NULL, 
  apellido VARCHAR(200) NOT NULL, 
  email VARCHAR(200) NOT NULL
); 

CREATE TABLE IF NOT EXISTS animal (
  id INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT, 
  nombre VARCHAR(50) NOT NULL, 
  tipo VARCHAR(50) NOT NULL, 
  color VARCHAR(20) NOT NULL, 
  sexo BOOLEAN NOT NULL, 
  precio DECIMAL(10,2) NOT NULL, 
  foto LONGBLOB NULL, 
  fecha_anyadido TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
); 

CREATE TABLE IF NOT EXISTS carrito (
  id_animal INT(11) NOT NULL,
  username_usuario VARCHAR(50) NOT NULL,
  FOREIGN KEY (id_animal) REFERENCES animal (id),
  FOREIGN KEY (username_usuario) REFERENCES usuario(username)
);

CREATE TABLE IF NOT EXISTS compra (
  fecha DATETIME NOT NULL,
  id_animal INT(11) NOT NULL,
  username_usuario VARCHAR(100) NOT NULL,
  FOREIGN KEY (id_animal) REFERENCES animal(id),
  FOREIGN KEY (username_usuario) REFERENCES usuario(username)
);

-- Insertar datos de animales iniciales (sin las imágenes por ahora)
INSERT INTO animal (nombre, tipo, color, sexo, precio)
VALUES ('Michi', 'Munchkin', 'Gris', 1, 344.55);

INSERT INTO animal (nombre, tipo, color, sexo, precio)
VALUES ('Whiskas', 'Munchkin', 'Gris y blanco', 0, 500);

INSERT INTO animal (nombre, tipo, color, sexo, precio)
VALUES ('Michi', 'ShortHair', 'Marron y blanco', 1, 700.50);

INSERT INTO animal (nombre, tipo, color, sexo, precio)
VALUES ('Lila', 'British', 'Gris', 1, 420.50);

INSERT INTO animal (nombre, tipo, color, sexo, precio)
VALUES ('Garfield Jr.', 'OrangeStray', 'Naranja', 0, 999);

INSERT INTO animal (nombre, tipo, color, sexo, precio)
VALUES ('Pepe', 'Munchkin', 'Negro y blanco', 1, 3450);

INSERT INTO animal (nombre, tipo, color, sexo, precio)
VALUES ('Lucas', 'British', 'Gris', 1, 700.50);

INSERT INTO animal (nombre, tipo, color, sexo, precio)
VALUES ('Toni', 'Stray', 'Gris', 1, 202);

INSERT INTO animal (nombre, tipo, color, sexo, precio)
VALUES ('Viqui', 'Argentina', 'Negro y blanco', 0, 5);

INSERT INTO animal (nombre, tipo, color, sexo, precio)
VALUES ('Ramses', 'Egiptshorthair', 'Blanco', 1, 700.50);

-- Insertar un usuario administrador predeterminado
INSERT INTO usuario (username, contrasenya, nombre, apellido, email)
VALUES ('javial', '12', 'Javier', 'Administrador', 'admin@floridacats.com');
EOL

    # Ejecutar el archivo SQL
    if mysql -u"$MYSQL_USER" ${MYSQL_PASSWORD:+-p"$MYSQL_PASSWORD"} < "$SQL_TEMP"; then
        print_success "Base de datos configurada correctamente."
    else
        print_error "Error al configurar la base de datos. Verificando credenciales..."
        get_mysql_credentials && mysql -u"$MYSQL_USER" ${MYSQL_PASSWORD:+-p"$MYSQL_PASSWORD"} < "$SQL_TEMP" && \
        print_success "Base de datos configurada correctamente." || \
        print_error "Error al configurar la base de datos. Verifique los logs de MySQL."
    fi
    
    # Eliminar archivo temporal
    rm "$SQL_TEMP"
}

# Función para actualizar el archivo de configuración de la base de datos
update_config() {
    print_message "Actualizando archivo de configuración de la base de datos..."
    
    # Verificar si el archivo usaGATOS.php existe
    if [ -f "$PROJECT_DIR/usaGATOS.php" ]; then
        # Crear una copia de seguridad del archivo original
        cp "$PROJECT_DIR/usaGATOS.php" "$PROJECT_DIR/usaGATOS.php.bak"
        
        # Actualizar el archivo de configuración
        cat > "$PROJECT_DIR/usaGATOS.php" << EOL
<?php
mysqli_report(MYSQLI_REPORT_ERROR);
\$servidor="localhost";
\$usuario="$MYSQL_USER";
\$clave="$MYSQL_PASSWORD";

@\$mysqli = new mysqli(\$servidor,\$usuario,\$clave);
if (\$mysqli->connect_errno)
{
  echo "Fallo conexión a Mysql: ".\$mysqli->connect_errno." ".\$mysqli->connect_error;
}
else 

\$basedatos="$DB_NAME";
\$mysqli->select_db(\$basedatos);
?>
EOL
        print_success "Archivo de configuración actualizado correctamente."
    else
        print_error "No se encontró el archivo usaGATOS.php"
    fi
}

# Función para iniciar el servidor PHP
start_php_server() {
    print_message "Iniciando servidor PHP en http://localhost:$PHP_SERVER_PORT..."
    print_message "Presione Ctrl+C para detener el servidor cuando termine."
    print_message ""
    print_message "Acceda a la aplicación desde su navegador en:"
    print_success "http://localhost:$PHP_SERVER_PORT"
    print_message ""
    print_message "Credenciales de administrador:"
    print_message "  Usuario: javial"
    print_message "  Contraseña: 12"
    print_message ""
    
    # Iniciar el servidor PHP en el directorio del proyecto
    php -S localhost:$PHP_SERVER_PORT -t "$PROJECT_DIR"
}

# =========================================================================
# Programa principal
# =========================================================================

echo ""
print_message "Iniciando configuración del proyecto Florida Cats..."
echo ""

# Verificar si PHP y MySQL están instalados
check_php || exit 1
check_mysql || exit 1

# Solicitar credenciales de MySQL
get_mysql_credentials || {
    print_warning "Se intentará continuar con la configuración predeterminada"
}

# Iniciar servidor MySQL
start_mysql

# Configurar base de datos
setup_database

# Actualizar archivo de configuración
update_config

# Mostrar instrucciones para las imágenes
print_message "Para completar la configuración de imágenes, inicie sesión como administrador:"
print_message "  Usuario: javial"
print_message "  Contraseña: 12"
print_message "  Y suba manualmente las imágenes desde la sección 'configuracion'."
print_message ""

# Iniciar servidor PHP
start_php_server 