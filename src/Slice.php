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

    public function __construct(array $items, $itemsPerPage, $totalNumberOfItems, $currentPage)
    {
        $this->items = $items;
        $this->numberOfPages = intval(ceil($totalNumberOfItems / $itemsPerPage));
        $this->currentPage = $currentPage <= $this->numberOfPages ? $currentPage : $this->numberOfPages;
        $this->totalNumberOfItems = $totalNumberOfItems;
        $this->itemsPerPage = $itemsPerPage;
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

}
