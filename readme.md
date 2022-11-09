# MY Admin

Modulo de Gestion de contenido CMS

# Requisitos

- \>= PHP 8.0 
- Laravel 9

# Instalación

Agregar a composer.json

```dotenv
"mayahkw/cms": "^v0.007"
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
    Mayahkw\LaravelGmail\LaravelGmailServiceProvider::class,
]
```

Ahora agregue el alias.

```php
'aliases' => [
    'LaravelGmail' => Mayahkw\LaravelGmail\Facade\LaravelGmail::class,
]
```

# Configuración

Sólo tienes que establecer las siguientes variables en tu archivo .env:

```dotenv
GOOGLE_PROJECT_ID=
GOOGLE_CLIENT_ID=
GOOGLE_CLIENT_SECRET=
GOOGLE_REDIRECT_URI=
GOOGLE_ALLOW_MULTIPLE_CREDENTIALS
GOOGLE_ALLOW_JSON_ENCRYPT
```


