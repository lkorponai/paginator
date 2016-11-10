<?php

namespace lkorponai\Paginator\Helper;


use lkorponai\Paginator\Slice;

class ViewHelper
{

    /** @var Slice */
    private $slice;

    /** @var string */
    private $baseUrl;

    /** @var array */
    private $parameters;

    /** @var string */
    private $pagingParameter;

    public function __construct(Slice $slice, $baseUrl, array $parameters = array(), $pagingParameter = 'page')
    {
        $this->slice = $slice;
        $this->baseUrl = $baseUrl;
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

    public function getPages($maxNumberOfItems = null)
    {
        $pages = array();

        $delta = null !== $maxNumberOfItems ? ($maxNumberOfItems -1) / 2 : null;

        for($i = 1; $i <= $this->slice->getNumberOfPages(); $i++){
            if(null !== $delta){
                if($i == ceil($delta)+1){
                    $pages[] = array(
                        'url' => null,
                        'page' => null,
                    );
                    continue;
                }

                if($i > ceil($delta) && $i <= $this->slice->getNumberOfPages() - floor($delta)){
                    continue;
                }
            }

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
            $url = rtrim($this->baseUrl, '/').'/'.$pageNumber;
        }else{
            $parameters[$this->pagingParameter] = $pageNumber;
            $url = $this->baseUrl;
        }

        $url .= $parameters ? '?'.http_build_query($parameters) : '';

        return $url;
    }

    public function getSlice()
    {
        return $this->slice;
    }

    public function getBaseUrl()
    {
        return $this->baseUrl;
    }

    public function getParameters()
    {
        return $this->parameters;
    }

    public function getPagingParameter()
    {
        return $this->pagingParameter;
    }

}
