<?php

namespace Application\Common;

class Paginator extends \Phalcon\Paginator\Adapter\QueryBuilder {

    public function __construct(array $config) {
        parent::__construct($config);
    }

    public function getPaginate($pageRange = 10) {
        $p = parent::getPaginate();

        $data = $this->getPaginationData($pageRange, $p->current, intval($this->getLimit()), $p->total_items);

        $p->start = intval(array_shift($data));
        $p->end = intval(array_pop($data));

        return $p;
    }

    public function getPaginationData($pageRange, $currentPageNumber, $numItemsPerPage, $totalCount)
    {
        /**
         *  $result = $this->getPaginationData(
        $this->config->application->pager_length,
        $curr_page,
        $this->config->application->pager,
        $page->total_items
        );
        $this->view->pager_start = array_shift($result[2]);
        $this->view->pager_end = array_pop($result[2]);
         */

        $pageCount = intval(ceil($totalCount / $numItemsPerPage));
        $current = $currentPageNumber;

        if ($pageCount < $current) {
            $currentPageNumber = $current = $pageCount;
        }

        if ($pageRange > $pageCount) {
            $pageRange = $pageCount;
        }

        $delta = ceil($pageRange / 2);

        if ($current - $delta > $pageCount - $pageRange) {
            $pages = range($pageCount - $pageRange + 1, $pageCount);
        } else {
            if ($current - $delta < 0) {
                $delta = $current;
            }

            $offset = $current - $delta;
            $pages = range($offset + 1, $offset + $pageRange);
        }

        $proximity = floor($pageRange / 2);

        $startPage = $current - $proximity;
        $endPage = $current + $proximity;

        if ($startPage < 1) {
            $endPage = min($endPage + (1 - $startPage), $pageCount);
            $startPage = 1;
        }

        if ($endPage > $pageCount) {
            $startPage = max($startPage - ($endPage - $pageCount), 1);
            $endPage = $pageCount;
        }

        return $pages;
    }
}
