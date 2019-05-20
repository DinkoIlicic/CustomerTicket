<?php
/**
 * Created by PhpStorm.
 * User: inchoo
 * Date: 5/13/19
 * Time: 11:54 AM
 */

namespace Inchoo\Ticket\Model\ResourceModel\Ticket;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * Initialize ticket Collection
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            \Inchoo\Ticket\Model\Ticket::class,
            \Inchoo\Ticket\Model\ResourceModel\Ticket::class
        );
    }
}
