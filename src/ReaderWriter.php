<?php

declare(strict_types=1);

namespace Thesis\ByteReaderWriter;

use BcMath\Number;
use Thesis\ByteOrder\ReadFrom;
use Thesis\ByteOrder\WriteTo;
use Thesis\ByteReader\Reader;
use Thesis\ByteWriter\Flushable;
use Thesis\ByteWriter\Writer;
use Thesis\Endian\Order;

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

    public function readInt8(Order $order = Order::Network): int
    {
        return $order->unpackInt8($this->reader->read(1));
    }

    public function readUint8(Order $order = Order::Network): int
    {
        return $order->unpackUint8($this->reader->read(1));
    }

    public function readInt16(Order $order = Order::Network): int
    {
        return $order->unpackInt16($this->reader->read(2));
    }

    public function readUint16(Order $order = Order::Network): int
    {
        return $order->unpackUint16($this->reader->read(2));
    }

    public function readInt32(Order $order = Order::Network): int
    {
        return $order->unpackInt32($this->reader->read(4));
    }

    public function readUint32(Order $order = Order::Network): int
    {
        return $order->unpackUint32($this->reader->read(4));
    }

    public function readInt64(Order $order = Order::Network): Number
    {
        return $order->unpackInt64($this->reader->read(8));
    }

    public function readUint64(Order $order = Order::Network): Number
    {
        return $order->unpackUint64($this->reader->read(8));
    }

    public function readFloat(Order $order = Order::Network): float
    {
        return $order->unpackFloat($this->reader->read(4));
    }

    public function readDouble(Order $order = Order::Network): float
    {
        return $order->unpackDouble($this->reader->read(8));
    }

    public function read(int $limit): string
    {
        return $this->reader->read($limit);
    }

    public function writeInt8(int $v, Order $order = Order::Network): self
    {
        return $this->doWrite($order->packInt8(...), $v);
    }

    public function writeUint8(int $v, Order $order = Order::Network): self
    {
        return $this->doWrite($order->packUint8(...), $v);
    }

    public function writeInt16(int $v, Order $order = Order::Network): self
    {
        return $this->doWrite($order->packInt16(...), $v);
    }

    public function writeUint16(int $v, Order $order = Order::Network): self
    {
        return $this->doWrite($order->packUint16(...), $v);
    }

    public function writeInt32(int $v, Order $order = Order::Network): self
    {
        return $this->doWrite($order->packInt32(...), $v);
    }

    public function writeUint32(int $v, Order $order = Order::Network): self
    {
        return $this->doWrite($order->packUint32(...), $v);
    }

    public function writeInt64(Number $v, Order $order = Order::Network): self
    {
        return $this->doWrite($order->packInt64(...), $v);
    }

    public function writeUint64(Number $v, Order $order = Order::Network): self
    {
        return $this->doWrite($order->packUint64(...), $v);
    }

    public function writeFloat(float $v, Order $order = Order::Network): self
    {
        return $this->doWrite($order->packFloat(...), $v);
    }

    public function writeDouble(float $v, Order $order = Order::Network): self
    {
        return $this->doWrite($order->packDouble(...), $v);
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
