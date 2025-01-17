<?php

declare(strict_types=1);

namespace Thesis\ReaderWriter;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Thesis\ByteReader\Reader;
use Thesis\ByteWriter\Writer;
use Thesis\Endian\endian;

#[CoversClass(ReaderWriter::class)]
final class ReaderWriterTest extends TestCase
{
    public function testExceptionIfReaderIsNotSubtypeOfWriter(): void
    {
        $rdr = $this->createMock(Reader::class);

        self::expectException(\UnexpectedValueException::class);
        new ReaderWriter($rdr);
    }

    #[TestWith([endian::network, -20])]
    public function testReadWriteInt8(endian $endian, int $value): void
    {
        $rdr = $this->createReaderWriter();

        $v = $endian->packInt8($value);

        $rdr->expects(self::once())->method('write')->with($v);
        $rdr->expects(self::once())->method('read')->with(1)->willReturn($v);

        $rw = new ReaderWriter($rdr);
        $rw = $rw->writeInt8($value);
        self::assertEquals($value, $rw->readInt8($endian));
    }

    /**
     * @param non-negative-int $value
     */
    #[TestWith([endian::network, 20])]
    public function testReadWriteUint8(endian $endian, int $value): void
    {
        $rdr = $this->createReaderWriter();

        $v = $endian->packUint8($value);

        $rdr->expects(self::once())->method('write')->with($v);
        $rdr->expects(self::once())->method('read')->with(1)->willReturn($v);

        $rw = new ReaderWriter($rdr);
        $rw = $rw->writeUint8($value);
        self::assertEquals($value, $rw->readUint8($endian));
    }

    #[TestWith([endian::network, -30])]
    public function testReadWriteInt16(endian $endian, int $value): void
    {
        $rdr = $this->createReaderWriter();

        $v = $endian->packInt16($value);

        $rdr->expects(self::once())->method('write')->with($v);
        $rdr->expects(self::once())->method('read')->with(2)->willReturn($v);

        $rw = new ReaderWriter($rdr);
        $rw = $rw->writeInt16($value);
        self::assertEquals($value, $rw->readInt16($endian));
    }

    /**
     * @param non-negative-int $value
     */
    #[TestWith([endian::network, 30])]
    public function testReadWriteUint16(endian $endian, int $value): void
    {
        $rdr = $this->createReaderWriter();

        $v = $endian->packUint16($value);

        $rdr->expects(self::once())->method('write')->with($v);
        $rdr->expects(self::once())->method('read')->with(2)->willReturn($v);

        $rw = new ReaderWriter($rdr);
        $rw = $rw->writeUint16($value);
        self::assertEquals($value, $rw->readUint16($endian));
    }

    /**
     * @param non-negative-int $value
     */
    #[TestWith([endian::network, -30])]
    public function testReadWriteInt32(endian $endian, int $value): void
    {
        $rdr = $this->createReaderWriter();

        $v = $endian->packInt32($value);

        $rdr->expects(self::once())->method('write')->with($v);
        $rdr->expects(self::once())->method('read')->with(4)->willReturn($v);

        $rw = new ReaderWriter($rdr);
        $rw = $rw->writeInt32($value);
        self::assertEquals($value, $rw->readInt32($endian));
    }

    /**
     * @param non-negative-int $value
     */
    #[TestWith([endian::network, 30])]
    public function testReadWriteUint32(endian $endian, int $value): void
    {
        $rdr = $this->createReaderWriter();

        $v = $endian->packUint32($value);

        $rdr->expects(self::once())->method('write')->with($v);
        $rdr->expects(self::once())->method('read')->with(4)->willReturn($v);

        $rw = new ReaderWriter($rdr);
        $rw = $rw->writeUint32($value);
        self::assertEquals($value, $rw->readUint32($endian));
    }

    #[TestWith([endian::network, -40])]
    public function testReadWriteInt64(endian $endian, int $value): void
    {
        $rdr = $this->createReaderWriter();

        $v = $endian->packInt64($value);

        $rdr->expects(self::once())->method('write')->with($v);
        $rdr->expects(self::once())->method('read')->with(8)->willReturn($v);

        $rw = new ReaderWriter($rdr);
        $rw = $rw->writeInt64($value);
        self::assertEquals($value, $rw->readInt64($endian));
    }

    /**
     * @param non-negative-int $value
     */
    #[TestWith([endian::network, 40])]
    public function testReadWriteUint64(endian $endian, int $value): void
    {
        $rdr = $this->createReaderWriter();

        $v = $endian->packUint64($value);

        $rdr->expects(self::once())->method('write')->with($v);
        $rdr->expects(self::once())->method('read')->with(8)->willReturn($v);

        $rw = new ReaderWriter($rdr);
        $rw = $rw->writeUint64($value);
        self::assertEquals($value, $rw->readUint64($endian));
    }

    #[TestWith([endian::network, -2.5])]
    public function testReadWriteFloat(endian $endian, float $value): void
    {
        $rdr = $this->createReaderWriter();

        $v = $endian->packFloat($value);

        $rdr->expects(self::once())->method('write')->with($v);
        $rdr->expects(self::once())->method('read')->with(4)->willReturn($v);

        $rw = new ReaderWriter($rdr);
        $rw = $rw->writeFloat($value);
        self::assertEquals($value, $rw->readFloat($endian));
    }

    #[TestWith([endian::network, 10.20])]
    public function testReadWriteDouble(endian $endian, float $value): void
    {
        $rdr = $this->createReaderWriter();

        $v = $endian->packDouble($value);

        $rdr->expects(self::once())->method('write')->with($v);
        $rdr->expects(self::once())->method('read')->with(8)->willReturn($v);

        $rw = new ReaderWriter($rdr);
        $rw = $rw->writeDouble($value);
        self::assertEquals($value, $rw->readDouble($endian));
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

    private function createReaderWriter(): MockObject&Reader&Writer
    {
        /** @var MockObject&Reader&Writer */
        return $this->createMockForIntersectionOfInterfaces([
            Reader::class,
            Writer::class,
        ]);
    }
}
