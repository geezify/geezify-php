Andegna Geezify
===============

[![Build Status](https://travis-ci.org/andegna/geezify.svg?branch=master)](https://travis-ci.org/andegna/geezify)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/andegna/geezify/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/andegna/geezify/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/andegna/geezify/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/andegna/geezify/?branch=master)
[![Total Downloads](https://poser.pugx.org/andegna/geezify/d/total.svg)](https://packagist.org/packages/andegna/geezify)
[![Latest Stable Version](https://poser.pugx.org/andegna/geezify/v/stable.svg)](https://packagist.org/packages/andegna/geezify)
[![Latest Unstable Version](https://poser.pugx.org/andegna/geezify/v/unstable.svg)](https://packagist.org/packages/andegna/geezify)
[![License](https://poser.pugx.org/andegna/geezify/license.svg)](https://packagist.org/packages/andegna/geezify)

This package is a simple library to convert ascii number '**3456**' to geez number '**፴፬፻፶፮**'.

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
