<?php
/**
 * Created by JetBrains PhpStorm.
 * User: jsiciarek
 * Date: 21.07.14
 * Time: 12:02
 * To change this template use File | Settings | File Templates.
 */

namespace Application\Common\Paginator;


class Pager extends \Phalcon\Paginator\Pager {

    /**
     * Return total number of items.
     *
     * @return boolean
     */
    public function getTotalItems()
    {
        return $this->paginateResult->total_items;
    }
}