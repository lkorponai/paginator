<?php


namespace lkorponai\Paginator\Tests\Driver;


use lkorponai\Paginator\Driver\ArrayDriver;

class ArrayDriverTest extends \PHPUnit_Framework_TestCase
{

    public function testPaginate()
    {
        $subject = range(1, 100);
        $driver = new ArrayDriver();

        $slice = $driver->paginate($subject, 3, 15);

        $this->assertEquals(range(31, 45), $slice->getItems());
        $this->assertEquals(3, $slice->getCurrentPage());
        $this->assertEquals(100, $slice->getTotalNumberOfItems());
        $this->assertEquals(15, $slice->getItemsPerPage());
        $this->assertEquals(7, $slice->getNumberOfPages());
    }

}
