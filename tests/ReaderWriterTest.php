<?php

declare(strict_types=1);

namespace Thesis\ByteReaderWriter;

use BcMath\Number;
use PHPUnit\Framework\Attributes\AllowMockObjectsWithoutExpectations;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Thesis\ByteReader\Reader;
use Thesis\ByteWriter\Flushable;
use Thesis\ByteWriter\Writer;
use Thesis\Endian\Order;

/**
 * @phpstan-import-type Int8 from Order
 * @phpstan-import-type Uint8 from Order
 * @phpstan-import-type Int16 from Order
 * @phpstan-import-type Uint16 from Order
 * @phpstan-import-type Int32 from Order
 * @phpstan-import-type Uint32 from Order
 */
#[CoversClass(ReaderWriter::class)]
final class ReaderWriterTest extends TestCase
{
    #[AllowMockObjectsWithoutExpectations]
    public function testExceptionIfReaderIsNotSubtypeOfWriter(): void
    {
        $rdr = $this->createMock(Reader::class);

        self::expectException(\UnexpectedValueException::class);
        new ReaderWriter($rdr);
    }

    /**
     * @param Int8 $value
     */
    #[TestWith([Order::Network, -20])]
    public function testReadWriteInt8(Order $order, int $value): void
    {
        $rdr = $this->createReaderWriter();

        $v = $order->packInt8($value);

        $rdr->expects(self::once())->method('write')->with($v);
        $rdr->expects(self::once())->method('read')->with(1)->willReturn($v);

        $rw = new ReaderWriter($rdr);
        $rw = $rw->writeInt8($value);
        self::assertEquals($value, $rw->readInt8($order));
    }

    /**
     * @param Uint8 $value
     */
    #[TestWith([Order::Network, 20])]
    public function testReadWriteUint8(Order $order, int $value): void
    {
        $rdr = $this->createReaderWriter();

        $v = $order->packUint8($value);

        $rdr->expects(self::once())->method('write')->with($v);
        $rdr->expects(self::once())->method('read')->with(1)->willReturn($v);

        $rw = new ReaderWriter($rdr);
        $rw = $rw->writeUint8($value);
        self::assertEquals($value, $rw->readUint8($order));
    }

    /**
     * @param Int16 $value
     */
    #[TestWith([Order::Network, -30])]
    public function testReadWriteInt16(Order $order, int $value): void
    {
        $rdr = $this->createReaderWriter();

        $v = $order->packInt16($value);

        $rdr->expects(self::once())->method('write')->with($v);
        $rdr->expects(self::once())->method('read')->with(2)->willReturn($v);

        $rw = new ReaderWriter($rdr);
        $rw = $rw->writeInt16($value);
        self::assertEquals($value, $rw->readInt16($order));
    }

    /**
     * @param Uint16 $value
     */
    #[TestWith([Order::Network, 30])]
    public function testReadWriteUint16(Order $order, int $value): void
    {
        $rdr = $this->createReaderWriter();

        $v = $order->packUint16($value);

        $rdr->expects(self::once())->method('write')->with($v);
        $rdr->expects(self::once())->method('read')->with(2)->willReturn($v);

        $rw = new ReaderWriter($rdr);
        $rw = $rw->writeUint16($value);
        self::assertEquals($value, $rw->readUint16($order));
    }

    /**
     * @param Int32 $value
     */
    #[TestWith([Order::Network, -30])]
    public function testReadWriteInt32(Order $order, int $value): void
    {
        $rdr = $this->createReaderWriter();

        $v = $order->packInt32($value);

        $rdr->expects(self::once())->method('write')->with($v);
        $rdr->expects(self::once())->method('read')->with(4)->willReturn($v);

        $rw = new ReaderWriter($rdr);
        $rw = $rw->writeInt32($value);
        self::assertEquals($value, $rw->readInt32($order));
    }

    /**
     * @param Uint32 $value
     */
    #[TestWith([Order::Network, 30])]
    public function testReadWriteUint32(Order $order, int $value): void
    {
        $rdr = $this->createReaderWriter();

        $v = $order->packUint32($value);

        $rdr->expects(self::once())->method('write')->with($v);
        $rdr->expects(self::once())->method('read')->with(4)->willReturn($v);

        $rw = new ReaderWriter($rdr);
        $rw = $rw->writeUint32($value);
        self::assertEquals($value, $rw->readUint32($order));
    }

    #[TestWith([Order::Network, new Number(-40)])]
    public function testReadWriteInt64(Order $order, Number $value): void
    {
        $rdr = $this->createReaderWriter();

        $v = $order->packInt64($value);

        $rdr->expects(self::once())->method('write')->with($v);
        $rdr->expects(self::once())->method('read')->with(8)->willReturn($v);

        $rw = new ReaderWriter($rdr);
        $rw = $rw->writeInt64($value);
        self::assertEquals($value, $rw->readInt64($order));
    }

    #[TestWith([Order::Network, new Number(40)])]
    public function testReadWriteUint64(Order $order, Number $value): void
    {
        $rdr = $this->createReaderWriter();

        $v = $order->packUint64($value);

        $rdr->expects(self::once())->method('write')->with($v);
        $rdr->expects(self::once())->method('read')->with(8)->willReturn($v);

        $rw = new ReaderWriter($rdr);
        $rw = $rw->writeUint64($value);
        self::assertEquals($value, $rw->readUint64($order));
    }

    #[TestWith([Order::Network, -2.5])]
    public function testReadWriteFloat(Order $order, float $value): void
    {
        $rdr = $this->createReaderWriter();

        $v = $order->packFloat($value);

        $rdr->expects(self::once())->method('write')->with($v);
        $rdr->expects(self::once())->method('read')->with(4)->willReturn($v);

        $rw = new ReaderWriter($rdr);
        $rw = $rw->writeFloat($value);
        self::assertEquals($value, $rw->readFloat($order));
    }

    #[TestWith([Order::Network, 10.20])]
    public function testReadWriteDouble(Order $order, float $value): void
    {
        $rdr = $this->createReaderWriter();

        $v = $order->packDouble($value);

        $rdr->expects(self::once())->method('write')->with($v);
        $rdr->expects(self::once())->method('read')->with(8)->willReturn($v);

        $rw = new ReaderWriter($rdr);
        $rw = $rw->writeDouble($value);
        self::assertEquals($value, $rw->readDouble($order));
    }

    /**
     * @param non-empty-string $value
     */
    #[TestWith(['test'])]
    public function testReadWrite(string $value): void
    {
        $rdr = $this->createReaderWriter();

        $rdr->expects(self::once())->method('write')->with($value);
        $rdr->expects(self::once())->method('read')->with(\strlen($value))->willReturn($value);

        $rw = new ReaderWriter($rdr);
        $rw->write($value);
        self::assertEquals($value, $rw->read(\strlen($value)));
    }

    public function testFlush(): void
    {
        $rdr = $this->createReaderWriter();
        $rdr->expects(self::once())->method('flush');

        $rw = new ReaderWriter($rdr);
        $rw->flush();
    }

    private function createReaderWriter(): MockObject&Reader&Writer&Flushable
    {
        /** @var MockObject&Reader&Writer&Flushable */
        return $this->createMockForIntersectionOfInterfaces([
            Reader::class,
            Writer::class,
            Flushable::class,
        ]);
    }
}
