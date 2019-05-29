<?php declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: inchoo
 * Date: 5/13/19
 * Time: 11:54 AM
 */

namespace Inchoo\Ticket\Model\ResourceModel;

use Inchoo\Ticket\Api\Data\TicketReplyInterface;

class TicketReply extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Initialize ticket reply Resource
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('inchoo_customer_ticket_reply', TicketReplyInterface::REPLY_ID);
    }
}
