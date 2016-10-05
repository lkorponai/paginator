<?php


namespace lkorponai\Paginator;


class Slice implements \Iterator
{
    /** @var array */
    protected $items;

    /** @var int */
    protected $numberOfPages;

    /** @var int */
    protected $currentPage;

    /** @var int */
    private $totalNumberOfItems;

    /** @var int */
    private $itemsPerPage;

    /** @var array */
    private $range;

    public function __construct(array $items, $itemsPerPage, $totalNumberOfItems, $currentPage)
    {
        $numberOfPages = intval(ceil($totalNumberOfItems / $itemsPerPage));
        $currentPage = $currentPage <= $numberOfPages ? $currentPage : $numberOfPages;

        $this->items = $items;
        $this->numberOfPages = $numberOfPages;
        $this->currentPage = $currentPage;
        $this->totalNumberOfItems = $totalNumberOfItems;
        $this->itemsPerPage = $itemsPerPage;
        $this->range = $this->calcRange($itemsPerPage, $totalNumberOfItems, $currentPage);
    }

    public function getNumberOfPages()
    {
        return $this->numberOfPages;
    }

    public function getCurrentPage()
    {
        return $this->currentPage;
    }

    public function getItems()
    {
        return $this->items;
    }

    public function getTotalNumberOfItems()
    {
        return $this->totalNumberOfItems;
    }

    public function getItemsPerPage()
    {
        return $this->itemsPerPage;
    }

    public function getRange()
    {
        return $this->range;
    }

    public function getTopRange()
    {
        return $this->range['to'];
    }

    public function getBottomRange()
    {
        return $this->range['from'];
    }

    public function current()
    {
        return current($this->items);
    }

    public function next()
    {
        return next($this->items);
    }

    public function key()
    {
        return key($this->items);
    }

    public function valid()
    {
        $key = $this->key();
        return null !== $key && false !== $key;
    }

    public function rewind()
    {
        reset($this->items);
    }

    public function isFirst()
    {
        return $this->currentPage == 1;
    }

    public function isLast()
    {
        return $this->currentPage == $this->numberOfPages;
    }

    protected function calcRange($itemsPerPage, $totalNumberOfItems, $currentPage)
    {
        $highest = ($currentPage + 1 * $itemsPerPage) - 1;
        $highest = $totalNumberOfItems > $highest ? $totalNumberOfItems : $highest;
        $range = array(
            'from' => $currentPage * $itemsPerPage,
            'to' => $highest,
        );
        return $range;
    }

}
