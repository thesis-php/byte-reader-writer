# Reader/Writer

## Installation

```shell
composer require thesis/reader-writer
```

## Basic usage

```php
<?php

declare(strict_types=1);

use Thesis\ReaderWriter\ReaderWriter;
use Thesis\ByteReader\Reader;

$rw = new ReaderWriter(
    /* an implementation of Thesis\ByteReader\Reader or Thesis\ByteReader\Reader|Thesis\ByteReader\Writer */,
    /* an implementation of ?Thesis\ByteReader\Writer */
);

$rw
    ->writeUint16(4)
    ->write('test');

echo $rw->read($rw->readUint16()); // test
```
