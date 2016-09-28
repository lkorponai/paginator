<?php


namespace lkorponai\Tests;


use lkorponai\Paginator\Driver\DriverInterface;
use lkorponai\Paginator\Paginator;
use lkorponai\Paginator\Slice;

class PaginatorTest extends \PHPUnit_Framework_TestCase
{

    public function testPagination()
    {
        $paginator = new Paginator([
            new IncorrectDummyDriver(),
            new DummyDriver(),
        ]);
        $slice = $paginator->paginate(range(1, 100), 1, 20);

        $this->assertEquals(5, $slice->getNumberOfPages());
        $this->assertEquals(range(1, 100), $slice->getItems());
        $this->assertEquals(20, $slice->getItemsPerPage());
        $this->assertEquals(100, $slice->getTotalNumberOfItems());
        $this->assertEquals(1, $slice->getCurrentPage());
        $this->assertTrue($slice->isFirst());
        $this->assertFalse($slice->isLast());

    }

    public function testDriverNotFound()
    {
        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('No driver could find to paginate the subject.');

        $paginator = new Paginator();
        $paginator->paginate(range(1, 100), 1, 20);
    }

    public function testIncorrectDriver()
    {
        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('A driver must return an instance of lkorponai\Paginator\Slice');

        $paginator = new Paginator();
        $paginator->paginate(range(1, 100), 1, 20, new IncorrectDummyDriver());
    }

}

class DummyDriver implements DriverInterface
{
    public function paginate($subject, $currentPage = 1, $itemsPerPage = 20)
    {
        //does nothing
        return new Slice($subject, $itemsPerPage, count($subject), $currentPage);
    }

    public function supports($subject)
    {
        return is_array($subject);
    }
}

class IncorrectDummyDriver implements DriverInterface
{
    public function paginate($subject, $currentPage = 1, $itemsPerPage = 20)
    {
        // incorrect because this method must return an instance of Slice
        return null;
    }

    public function supports($subject)
    {
        return $subject instanceof \ArrayAccess;
    }

}
