# Reader/Writer

## Installation

```shell
composer require thesis/byte-reader-writer
```

## Basic usage

```php
<?php

declare(strict_types=1);

use Thesis\ByteReaderWriter\ReaderWriter;
use Thesis\ByteReader\Reader;
use Thesis\ByteWriter\Writer;

$rw = new ReaderWriter(
    reader: /* an implementation of Reader or Reader&Writer */,
    writer: /* an implementation of Writer or null */,
);

$rw
    ->writeUint16(4)
    ->write('test');

echo $rw->read($rw->readUint16()); // test
```
