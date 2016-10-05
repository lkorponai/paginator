<?php

namespace lkorponai\Paginator\Helper;


use lkorponai\Paginator\Slice;

class ViewHelper
{

    /** @var Slice */
    private $slice;

    /** @var string */
    private $url;

    /** @var array */
    private $parameters;

    /** @var string */
    private $pagingParameter;

    public function __construct(Slice $slice, $baseUrl, array $parameters = array(), $pagingParameter = 'page')
    {
        $this->slice = $slice;
        $this->url = $baseUrl;
        $this->parameters = $parameters;
        $this->pagingParameter = $pagingParameter;
    }

    public function getSummary($format = null)
    {
        $format = null !== $format ? $format : 'Showing :min-:max (:perPage) of :total';

        return strtr($format, array(
            ':min' => $this->slice->getBottomRange(),
            ':max' => $this->slice->getTopRange(),
            ':perPage' => $this->slice->getItemsPerPage(),
            ':total' => $this->slice->getTotalNumberOfItems(),
        ));
    }

    /**
     * todo make it possible to create sliding pagination (... in the middle)
     */
    public function getPages()
    {
        $pages = array();

        for($i = 1; $i <= $this->slice->getNumberOfPages(); $i++){
            $pages[] = array(
                'url' => $this->getUrl($i),
                'page' => $i,
            );
        }

        return $pages;
    }

    public function getNext()
    {
        if(!$this->hasNext()){
            return null;
        }

        $nextPage = $this->slice->getCurrentPage() + 1;

        return array(
            'url' => $this->getUrl($nextPage),
            'page' => $nextPage,
        );
    }

    public function getPrev()
    {
        if(!$this->hasPrev()){
            return null;
        }

        $prevPage = $this->slice->getCurrentPage() - 1;

        return array(
            'url' => $this->getUrl($prevPage),
            'page' => $prevPage,
        );
    }

    public function hasNext()
    {
        return !$this->slice->isLast();
    }

    public function hasPrev()
    {
        return !$this->slice->isFirst();
    }

    public function getFirst()
    {
        return array(
            'url' => $this->getUrl(1),
            'page' => 1
        );
    }

    public function getLast()
    {
        $lastPage = $this->slice->getNumberOfPages();

        return array(
            'url' => $this->getUrl($lastPage),
            'page' => $lastPage,
        );
    }

    public function getUrl($pageNumber)
    {
        $parameters = $this->parameters;

        if(null === $this->pagingParameter){
            $url = $this->url.'/'.$pageNumber;
        }else{
            $parameters[$this->pagingParameter] = $pageNumber;
            $url = $this->url;
        }

        $url .= $parameters ? '?'.http_build_query($parameters) : '';

        return $url;
    }

}
