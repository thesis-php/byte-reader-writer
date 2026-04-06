<?php

declare(strict_types=1);

namespace Thesis\ByteReaderWriter;

use Thesis\ByteOrder\ReadFrom;
use Thesis\ByteOrder\WriteTo;
use Thesis\ByteReader\Reader;
use Thesis\ByteWriter\Flushable;
use Thesis\ByteWriter\Writer;
use Thesis\Endian\endian;

/**
 * @api
 */
final readonly class ReaderWriter implements ReadFrom, WriteTo, Flushable
{
    private Writer $writer;

    public function __construct(
        private Reader $reader,
        ?Writer $writer = null,
    ) {
        $writer ??= $reader;

        if (!$writer instanceof Writer) {
            throw new \UnexpectedValueException(\sprintf('The $reader must be a subtype of "%s", when $writer is not passed, but "%s" given.', Writer::class, get_debug_type($writer)));
        }

        $this->writer = $writer;
    }

    public function readInt8(endian $endian = endian::network): int
    {
        return $endian->unpackInt8($this->reader->read(1));
    }

    public function readUint8(endian $endian = endian::network): int
    {
        return $endian->unpackUint8($this->reader->read(1));
    }

    public function readInt16(endian $endian = endian::network): int
    {
        return $endian->unpackInt16($this->reader->read(2));
    }

    public function readUint16(endian $endian = endian::network): int
    {
        return $endian->unpackUint16($this->reader->read(2));
    }

    public function readInt32(endian $endian = endian::network): int
    {
        return $endian->unpackInt32($this->reader->read(4));
    }

    public function readUint32(endian $endian = endian::network): int
    {
        return $endian->unpackUint32($this->reader->read(4));
    }

    public function readInt64(endian $endian = endian::network): int
    {
        return $endian->unpackInt64($this->reader->read(8));
    }

    public function readUint64(endian $endian = endian::network): int
    {
        return $endian->unpackUint64($this->reader->read(8));
    }

    public function readFloat(endian $endian = endian::network): float
    {
        return $endian->unpackFloat($this->reader->read(4));
    }

    public function readDouble(endian $endian = endian::network): float
    {
        return $endian->unpackDouble($this->reader->read(8));
    }

    public function read(int $limit): string
    {
        return $this->reader->read($limit);
    }

    public function writeInt8(int $v, endian $endian = endian::network): self
    {
        return $this->doWrite($endian->packInt8(...), $v);
    }

    public function writeUint8(int $v, endian $endian = endian::network): self
    {
        return $this->doWrite($endian->packUint8(...), $v);
    }

    public function writeInt16(int $v, endian $endian = endian::network): self
    {
        return $this->doWrite($endian->packInt16(...), $v);
    }

    public function writeUint16(int $v, endian $endian = endian::network): self
    {
        return $this->doWrite($endian->packUint16(...), $v);
    }

    public function writeInt32(int $v, endian $endian = endian::network): self
    {
        return $this->doWrite($endian->packInt32(...), $v);
    }

    public function writeUint32(int $v, endian $endian = endian::network): self
    {
        return $this->doWrite($endian->packUint32(...), $v);
    }

    public function writeInt64(int $v, endian $endian = endian::network): self
    {
        return $this->doWrite($endian->packInt64(...), $v);
    }

    public function writeUint64(int $v, endian $endian = endian::network): self
    {
        return $this->doWrite($endian->packUint64(...), $v);
    }

    public function writeFloat(float $v, endian $endian = endian::network): self
    {
        return $this->doWrite($endian->packFloat(...), $v);
    }

    public function writeDouble(float $v, endian $endian = endian::network): self
    {
        return $this->doWrite($endian->packDouble(...), $v);
    }

    public function write(string $bytes): void
    {
        $this->writer->write($bytes);
    }

    public function flush(): void
    {
        if ($this->writer instanceof Flushable) {
            $this->writer->flush();
        }
    }

    /**
     * @template T
     * @param callable(T): non-empty-string $write
     * @param T $v
     */
    private function doWrite(callable $write, mixed $v): self
    {
        $this->writer->write($write($v));

        return $this;
    }
}
