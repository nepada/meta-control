Meta Control
============

[![Build Status](https://travis-ci.org/nepada/meta-control.svg?branch=master)](https://travis-ci.org/nepada/meta-control)
[![Coverage Status](https://coveralls.io/repos/github/nepada/meta-control/badge.svg?branch=master)](https://coveralls.io/github/nepada/meta-control?branch=master)
[![Downloads this Month](https://img.shields.io/packagist/dm/nepada/meta-control.svg)](https://packagist.org/packages/nepada/meta-control)
[![Latest stable](https://img.shields.io/packagist/v/nepada/meta-control.svg)](https://packagist.org/packages/nepada/meta-control)


Installation
------------

Via Composer:

```sh
$ composer require nepada/meta-control
```


Usage
-----

First register the control factory in your config and optionally set up default metadata:
```yaml
services:
    -
        implement: Nepada\MetaControl\IMetaControlFactory
        setup:
            - setCharset('utf-8')
            - setAuthor('Jon Doe')
```

Use the control factory in your presenter:
```php
protected function createComponentMeta(): Nepada\MetaControl\MetaControl
{
    $control = $this->metaControlFactory->create();
    $control->setDescription('Lorem ipsum');
    return $control;
}
```

And render it in your Latte template:
```html
<html>
<head>
    {control meta}
</head>
<body>
    ...
</body>
</html>
```

### Overview of supported meta tags

Charset:
```php
// <meta charset="utf-8">
$control->setCharset('utf-8');
$control->getCharset(); // 'utf-8'
```

Document metadata:
```php
// <meta name="author" content="John Doe">
$control->setMetadata('author', 'Jon Doe');
$control->getMetadata('author'); // 'Jon Doe'
```

Document properties:
```php
// <meta property="og:title" content="Foo title">
$control->setProperty('og:title', 'Foo title');
$control->getProperty('og:title'); // 'Foo title'
```

Pragma directives:
```php
// <meta http-equiv="content-type" content="text/html; charset=UTF-8">
$control->setPragma('content-type', 'text/html; charset=UTF-8');
$control->getPragma('content-type'); // 'text/html; charset=UTF-8'
```

### Shorthands for standard metadata

Author:
```php
// <meta name="author" content="John Doe">
$control->setAuthor('Jon Doe');
$control->getAuthor(); // 'Jon Doe'
```

Description:
```php
// <meta name="description" content="Lorem ipsum">
$control->setDescription('Lorem ipsum');
$control->getDescription(); // 'Lorem ipsum'
```

Keywords:
```php
// <meta name="keywords" content="foo, bar, baz">
$control->setKeywords('foo', 'bar');
$control->addKeyword('baz');
$control->getKeywords(); // ['foo', 'bar', 'baz']
```

Robots:
```php
// <meta name="robots" content="noindex, nofollow">
$control->setRobots('noindex, nofollow');
$control->getRobots(); // 'noindex, nofollow'
```
