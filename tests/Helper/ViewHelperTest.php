<?php


namespace lkorponai\Paginator\Tests\Helper;

use lkorponai\Paginator\Driver\ArrayDriver;
use lkorponai\Paginator\Helper\ViewHelper;

class ViewHelperTest extends \PHPUnit_Framework_TestCase
{

    public function testGetSummary()
    {
        $view = new ViewHelper($this->getTestData(), '/', array());
        $summary = $view->getSummary();

        $this->assertEquals('Showing 50-100 (50) of 500', $summary);
    }

    public function testGetPages()
    {
        $view = new ViewHelper($this->getTestData(), '/', array());
        $pages = $view->getPages();

        $this->assertEquals(array_map(function($i){
            return array('url' => '/?page='.$i, 'page' => $i);
        }, range(1, 10)), $pages);
    }

    public function testGetPagesSliding()
    {
        $view = new ViewHelper($this->getTestData(), '/', array());
        $pages = $view->getPages(6);

        $this->assertEquals(array(
            array('url'=> '/?page=1', 'page' => 1),
            array('url'=> '/?page=2', 'page' => 2),
            array('url'=> '/?page=3', 'page' => 3),
            array('url'=> null, 'page' => null),
            array('url'=> '/?page=9', 'page' => 9),
            array('url'=> '/?page=10', 'page' => 10),
        ), $pages);
    }

    public function testGetNext()
    {
        $view = new ViewHelper($this->getTestData(2), '/', array());

        $this->assertEquals(
            array('url' => '/?page=3', 'page' => 3),
            $view->getNext()
        );

        $view = new ViewHelper($this->getTestData(10), '/', array());

        $this->assertEquals(
            null,
            $view->getNext()
        );
    }

    public function testGetPrev()
    {
        $view = new ViewHelper($this->getTestData(2), '/', array());

        $this->assertEquals(
            array('url' => '/?page=1', 'page' => 1),
            $view->getPrev()
        );

        $view = new ViewHelper($this->getTestData(1), '/', array());

        $this->assertEquals(
            null,
            $view->getPrev()
        );
    }

    public function testBoundaries()
    {
        $view = new ViewHelper($this->getTestData(2), '/', array());

        $this->assertEquals(
            array('url' => '/?page=1', 'page' => 1),
            $view->getFirst()
        );

        $this->assertEquals(
            array('url' => '/?page=10', 'page' => 10),
            $view->getLast()
        );
    }

    public function testGetUrl()
    {
        $view = new ViewHelper($this->getTestData(), '/', array());
        $this->assertEquals('/?page=1', $view->getUrl(1));

        $view = new ViewHelper($this->getTestData(), 'test/', array());
        $this->assertEquals('test/?page=1', $view->getUrl(1));

        $view = new ViewHelper($this->getTestData(), 'test/', array('query1' => 'test'));
        $this->assertEquals('test/?query1=test&page=1', $view->getUrl(1));

        $view = new ViewHelper($this->getTestData(), 'test/', array('query1' => 'test'), null);
        $this->assertEquals('test/1?query1=test', $view->getUrl(1));
    }


    protected function getTestData($currentPage = 2, $itemsPerPage = 50)
    {
        $subject = range(1, 500);
        $driver = new ArrayDriver();

        $slice = $driver->paginate($subject, $currentPage, $itemsPerPage);

        return $slice;
    }


}
