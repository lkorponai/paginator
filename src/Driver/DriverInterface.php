<?php


namespace lkorponai\Paginator\Driver;


use lkorponai\Paginator\Slice;

interface DriverInterface
{

    /**
     * @param mixed $subject
     * @param int $currentPage
     * @param int $itemsPerPage
     * @return Slice
     */
    public function paginate($subject, $currentPage = 1, $itemsPerPage = 20);

    /**
     * @param mixed $subject
     * @return bool
     */
    public function supports($subject);

}
