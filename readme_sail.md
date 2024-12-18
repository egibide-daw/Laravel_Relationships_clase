#Para instalar

Referencia:
https://quixdevf.medium.com/how-to-setup-laravel-sail-in-windows-11-10-with-wsl2-b1ee6829fe1

1) Con permisos de administrador:
dism.exe /online /enable-feature /featurename:Microsoft-Windows-Subsystem-Linux /all /norestart

dism.exe /online /enable-feature /featurename:VirtualMachinePlatform /all /norestart

wsl --set-default-version 2

2) En el path, meter la ruta de wsl.exe:
c:/Windows/System32

3) Powershell con permisos de administrador:
wsl --install

4) Configurar en docker desktop

5) Dentro de la máquina de ubundo 
./vendor/bin/sail up -d
6) Y cuando acaba intentar migrar php artisan migrate:
sudo apt-get update 
sudo apt install php8.3-cli 
sudo apt-get install -y libxml2-dev

 7)   
Edita o crea un archivo docker-compose.override.yml para personalizar la configuración del contenedor:

services:
laravel.test:
build:
context: ./vendor/laravel/sail/runtimes/8.2
args:
- WITH_MYSQL=true

Luego, reconstruye los contenedores:

./vendor/bin/sail build --no-cache
./vendor/bin/sail up -d

Esto asegurará que la extensión pdo_mysql esté instalada en el entorno.

//Meterse en el shell
./vendor/bin/sail shell
y ahí
php artisan migrate
