Andegna Geezify
===============

[![Build Status](https://travis-ci.org/andegna/geezify.svg?branch=master)](https://travis-ci.org/andegna/geezify)
[![StyleCI](https://styleci.io/repos/68031629/shield?branch=master)](https://styleci.io/repos/68031629)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/andegna/geezify/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/andegna/geezify/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/andegna/geezify/badges/coverage.png?b=develop)](https://scrutinizer-ci.com/g/andegna/geezify/?branch=develop)
[![Total Downloads](https://poser.pugx.org/andegna/geezify/d/total.svg)](https://packagist.org/packages/andegna/geezify)
[![Latest Stable Version](https://poser.pugx.org/andegna/geezify/v/stable.svg)](https://packagist.org/packages/andegna/geezify)
[![Latest Unstable Version](https://poser.pugx.org/andegna/geezify/v/unstable.svg)](https://packagist.org/packages/andegna/geezify)
[![License](https://poser.pugx.org/andegna/geezify/license.svg)](https://packagist.org/packages/andegna/geezify)

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/a3519698-fee9-494c-adbb-c5c2f8abc422/big.png)](https://insight.sensiolabs.com/projects/a3519698-fee9-494c-adbb-c5c2f8abc422)

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
<?php

require 'vendor/autoload.php';

use Andegna\Geez\Geezify;

$geez = Geezify::create();

echo $geez->toGeez(123) . PHP_EOL; // ፻፳፫
echo $geez->toGeez(1234) . PHP_EOL; // ፲፪፻፴፬
echo $geez->toGeez(1986) . PHP_EOL; // ፲፱፻፹፮
echo $geez->toGeez(1000000) . PHP_EOL; // ፻፼

// or you can even do the reverse

echo $geez->toAscii('፻፳፫') . PHP_EOL; // 123
echo $geez->toAscii('፲፪፻፴፬') . PHP_EOL; // 1234
echo $geez->toAscii('፲፱፻፹፮') . PHP_EOL; // 1986
echo $geez->toAscii('፻፼') . PHP_EOL; // 1000000
```

License
-------
Geezify is released under the MIT Licence. See the bundled LICENSE file for details.
