<?php


namespace lkorponai\Paginator\Driver;


use lkorponai\Paginator\Slice;

class ArrayDriver implements DriverInterface
{

    public function paginate($subject, $currentPage = 1, $itemsPerPage = 20)
    {
        $numberOfItems = count($subject);

        $items = array_slice($subject, ($currentPage-1)*$itemsPerPage, $itemsPerPage);

        return new Slice($items, $itemsPerPage, $numberOfItems, $currentPage);
    }

    public function supports($subject)
    {
        return is_array($subject);
    }

}
