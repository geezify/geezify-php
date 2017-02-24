Geezify  ![From Ethiopia](https://img.shields.io/badge/From-Ethiopia-brightgreen.svg)
=======

[![Build Status](https://travis-ci.org/geezify/geezify-php.svg?branch=master)](https://travis-ci.org/geezify/geezify-php)
[![StyleCI](https://styleci.io/repos/68031629/shield?branch=master)](https://styleci.io/repos/68031629)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/geezify/geezify-php/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/geezify/geezify-php/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/geezify/geezify-php/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/geezify/geezify-php/?branch=master)
[![Total Downloads](https://poser.pugx.org/geezify/geezify-php/d/total.svg)](https://packagist.org/packages/geezify/geezify-php)
[![Latest Stable Version](https://poser.pugx.org/geezify/geezify-php/v/stable.svg)](https://packagist.org/packages/geezify/geezify-php)
[![Latest Unstable Version](https://poser.pugx.org/geezify/geezify-php/v/unstable.svg)](https://packagist.org/packages/geezify/geezify-php)
[![License](https://poser.pugx.org/geezify/geezify-php/license.svg)](https://packagist.org/packages/geezify/geezify-php)

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/10402788-4581-471f-a963-e1b775ff7630/big.png)](https://insight.sensiolabs.com/projects/10402788-4581-471f-a963-e1b775ff7630)

This package is a library to convert ascii number like '**3456**' to geez number '**፴፬፻፶፮**' and vise versa.

 > Ge'ez (ግዕዝ) is an ancient South Semitic language that originated in Eritrea and the northern region of Ethiopia in the Horn of Africa. It later became the official language of the Kingdom of Aksum and Ethiopian imperial court.
 
click [here](https://en.wikipedia.org/wiki/Ge%27ez) to read more.

Prerequisites
-------------
`geezify` requires **PHP** 5.6 or greater.

Installation
------------
```sh
composer require geezify/geezify-php
```

 > If you never used `composer` before, please check out 
 > [this link](https://getcomposer.org)
 > before you write any **PHP** code again!

Usage
----------------
```php
<?php

require 'vendor/autoload.php';

use Geezify\Geezify;

$geez = Geezify::create();

echo $geez->toGeez(123) . PHP_EOL;        // ፻፳፫
echo $geez->toGeez(1234) . PHP_EOL;      // ፲፪፻፴፬
echo $geez->toGeez(1986) . PHP_EOL;     // ፲፱፻፹፮
echo $geez->toGeez(1000000) . PHP_EOL; // ፻፼

// or you can even do the reverse

echo $geez->toAscii('፻፳፫') . PHP_EOL;     // 123
echo $geez->toAscii('፲፪፻፴፬') . PHP_EOL;   // 1234
echo $geez->toAscii('፲፱፻፹፮') . PHP_EOL;  // 1986
echo $geez->toAscii('፻፼') . PHP_EOL;    // 1000000
```

License
-------
Geezify is released under the MIT Licence. See the bundled LICENSE file for details.
