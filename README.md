# This is my package tenant

[![Latest Version on Packagist](https://img.shields.io/packagist/v/callcocam/tenant.svg?style=flat-square)](https://packagist.org/packages/callcocam/tenant)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/callcocam/tenant/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/callcocam/tenant/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/callcocam/tenant/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/callcocam/tenant/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/callcocam/tenant.svg?style=flat-square)](https://packagist.org/packages/callcocam/tenant)



This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

## Installation

You can install the package via composer:

```bash
composer require callcocam/tenant
```
Execute the command

```bash
php artisan app:tenant-install
```
Enable the tenant in config/tenant.php

Run the command again

```bash
php artisan app:tenant-install
```

OR

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="tenant-migrations" 
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="tenant-config"
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="tenant-views"
```


Remember to install the plugin on Your Provider

```
use Callcocam\Tenant\TenantPlugin;
 return $panel
 ...
->plugin(new TenantPlugin())
...
``

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [](https://github.com/callcocam)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
