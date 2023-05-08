# MY Admin

Modulo de Gestion de contenido CMS

# Requisitos

- \>= PHP 8.0
- Laravel 9

# Instalación

Agregar a composer.json

```dotenv
"mayahkw/cms": "*"
```

```dotenv
"repositories": [
    { "type": "vcs", "url": "git@github.com:mayahkw/cms.git" }
],
```

Ejecutar composer update e introducir el token para obtener el paquete

Despues de instalado abrir `config/app.php` y agregar el service provider.

```php
'providers' => [
    Mayahkw\CMS\CmsServiceProvider::class,
]
```

Agregar dependencias

```dotenv
npm install --save @ckeditor/ckeditor5-vue @ckeditor/ckeditor5-build-classic
```

<!--
Ahora agregue el alias.

```php
'aliases' => [
    'LaravelGmail' => Mayahkw\LaravelGmail\Facade\LaravelGmail::class,
]
```
-->

# Configuración

Sólo tienes que eliminar la ruta "/" para que el sistema tome el control de la pagina de inicio
