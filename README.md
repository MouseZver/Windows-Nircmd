# Nircmd
Computer management in Windows OC using the Facade API in PHP

[![Latest Unstable Version](https://poser.pugx.org/Nouvu/windows-nircmd/v)](https://packagist.org/packages/nouvu/windows-nircmd) [![License](https://poser.pugx.org/nouvu/windows-nircmd/license)](https://packagist.org/packages/nouvu/windows-nircmd)

> composer require nouvu/windows-nircmd

Example:
```php
$cmd = new Nouvu\Windows\Nircmd;

$cmd -> savescreenshot( filename:'test.png', x:496, y:308, w:474, h:503 );
```

***

[Documentation...](https://nircmd.nirsoft.net/)
