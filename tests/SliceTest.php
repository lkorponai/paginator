<?php


namespace lkorponai\Tests;


use lkorponai\Paginator\Slice;

class SliceTest extends \PHPUnit_Framework_TestCase
{

    public function testSlice()
    {
        $slice = new Slice(range(1, 30), 6, 50, 1);
        $this->assertSlice($slice, 9, range(1, 30), 6, 50, 1, true, false);

        $slice = new Slice(range(1, 30), 30, 30, 1);
        $this->assertSlice($slice, 1, range(1, 30), 30, 30, 1, true, true);

    }

    public function testTraversability()
    {
        $slice = new Slice(range(1, 5), 1, 5, 1);

        $expected = 1;
        foreach($slice as $item){
            $this->assertEquals($expected, $item);
            $expected++;
        }
    }

    protected function assertSlice(Slice $slice, $numberOfPages, $items, $itemsPerPage, $totalNumberOfItems, $currentPage, $first, $last)
    {
        $this->assertEquals($numberOfPages, $slice->getNumberOfPages());
        $this->assertEquals($items, $slice->getItems());
        $this->assertEquals($itemsPerPage, $slice->getItemsPerPage());
        $this->assertEquals($totalNumberOfItems, $slice->getTotalNumberOfItems());
        $this->assertEquals($currentPage, $slice->getCurrentPage());
        $this->assertEquals($first, $slice->isFirst());
        $this->assertEquals($last, $slice->isLast());
    }

}
