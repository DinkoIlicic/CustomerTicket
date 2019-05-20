<?php
/**
 * Created by PhpStorm.
 * User: inchoo
 * Date: 5/13/19
 * Time: 10:40 AM
 */

namespace Inchoo\Ticket\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface TicketSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get ticket list.
     *
     * @return \Inchoo\Ticket\Api\Data\TicketInterface[]
     */
    public function getItems();

    /**
     * Set ticket list.
     *
     * @param \Inchoo\Ticket\Api\Data\TicketInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
