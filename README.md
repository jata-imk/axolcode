# CRM y Administrador Pagina Web

Desarrollo para agencias de viajes


## Instalación

Para poder usar localmente este proyecto lo primero es descargar el repositorio

```bash
  git clone https://github.com/Lexgo-Tours/axolcode.git

  cd ./axolcode
```

Lo siguiente es instalar las dependencias de composer

```bash
  composer i
  composer u
```

También hay que crear un link simbólico antes para los archivos guardados

```bash
  php artisan storage:link
```

Ahora solo queda iniciar el servidor localmente cada vez que vayamos a usar el proyecto
```bash
  php artisan serve
```
## Variables de entorno

Para poder ejecutar este proyecto necesitas solicitar las variables de entorno con los demás integrantes del proyecto, ya que por razones de seguridad no se suben al repositorio
