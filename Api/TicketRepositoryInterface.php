<?php
/**
 * Created by PhpStorm.
 * User: inchoo
 * Date: 5/13/19
 * Time: 10:41 AM
 */

namespace Inchoo\Ticket\Api;

use Inchoo\Ticket\Api\Data\TicketInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

interface TicketRepositoryInterface
{
    /**
     * Retrieve ticket.
     *
     * @param int $ticketId
     * @return \Inchoo\Ticket\Api\Data\TicketInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($ticketId);

    /**
     * Save ticket.
     *
     * @param \Inchoo\Ticket\Api\Data\TicketInterface $ticket
     * @return \Inchoo\Ticket\Api\Data\TicketInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(TicketInterface $ticket);

    /**
     * Delete ticket.
     *
     * @param \Inchoo\Ticket\Api\Data\TicketInterface $ticket
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(TicketInterface $ticket);

    /**
     * DeleteById ticked.
     *
     * @param int $ticketId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($ticketId);

    /**
     * Retrieve customer ticket matching the specified search criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Inchoo\Ticket\Api\Data\TicketInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria);
}
