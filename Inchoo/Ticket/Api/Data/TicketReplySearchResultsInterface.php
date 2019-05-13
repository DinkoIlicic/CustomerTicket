<?php
/**
 * Created by PhpStorm.
 * User: inchoo
 * Date: 5/13/19
 * Time: 10:40 AM
 */

namespace Inchoo\Ticket\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface TicketReplySearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get ticket reply list.
     *
     * @return \Inchoo\Ticket\Api\Data\TicketReplyInterface[]
     */
    public function getItems();

    /**
     * Set ticket reply list.
     *
     * @param \Inchoo\Ticket\Api\Data\TicketReplyInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
