Andegna Geezify
===============
This package is a simple library to convert ascii number '3456' to geez number '፴፬፻፶፮'.

Installation
------------

### Prerequisites
geezify requires PHP 5.4 or greater.

### Setup through composer
```sh
composer require andegna/geezify
```

A simple example
----------------
```php
require 'vendor/autoload.php';

$geez = new Andegna\Geez\Geezify();

echo $geez->convert(123) . PHP_EOL; // ፻፳፫
echo $geez->convert(1234) . PHP_EOL; // ፲፪፻፴፬
echo $geez->convert(1986) . PHP_EOL; // ፲፱፻፹፮
echo $geez->convert(1000000) . PHP_EOL; // ፻፼
```

License
-------
Geezify is released under the MIT Licence. See the bundled LICENSE file for details.
