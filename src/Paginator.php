<?php

namespace lkorponai\Paginator;


use lkorponai\Paginator\Driver\DriverInterface;

class Paginator
{

    /** @var DriverInterface[] */
    private $drivers;

    public function __construct(array $drivers = [])
    {
        $this->drivers = $drivers;
    }

    public function paginate($subject, $currentPage = 1, $itemsPerPage = 20, DriverInterface $driver = null)
    {
        $driver = $driver instanceof DriverInterface ? $driver : $this->getSupportingDriver($subject);

        if(!$driver instanceof DriverInterface){
            throw new \LogicException('No driver could find to paginate the subject.');
        }

        $slice = $driver->paginate($subject, $currentPage, $itemsPerPage);

        if(!$slice instanceof Slice){
            throw new \LogicException(sprintf('A driver must return an instance of %s', Slice::class));
        }

        return $slice;
    }

    protected function getSupportingDriver($subject)
    {
        foreach($this->drivers as $driver){
            if($driver->supports($subject)){
                return $driver;
            }
        }

        return null;
    }

}
