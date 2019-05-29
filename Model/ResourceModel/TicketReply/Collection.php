<?php declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: inchoo
 * Date: 5/13/19
 * Time: 11:55 AM
 */

namespace Inchoo\Ticket\Model\ResourceModel\TicketReply;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * Initialize ticket reply Collection
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            \Inchoo\Ticket\Model\TicketReply::class,
            \Inchoo\Ticket\Model\ResourceModel\TicketReply::class
        );
    }
}
