<?php
/**
 * Created by PhpStorm.
 * User: inchoo
 * Date: 5/13/19
 * Time: 10:41 AM
 */

namespace Inchoo\Ticket\Api;

use Inchoo\Ticket\Api\Data\TicketReplyInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

interface TicketReplyRepositoryInterface
{
    /**
     * Retrieve reply.
     *
     * @param int $replyId
     * @return \Inchoo\Ticket\Api\Data\TicketReplyInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($replyId);

    /**
     * Save reply.
     *
     * @param \Inchoo\Ticket\Api\Data\TicketReplyInterface $reply
     * @return \Inchoo\Ticket\Api\Data\TicketReplyInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(TicketReplyInterface $reply);

    /**
     * Delete reply.
     *
     * @param \Inchoo\Ticket\Api\Data\TicketReplyInterface $reply
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(TicketReplyInterface $reply);

    /**
     * DeleteById reply.
     *
     * @param int $replyId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($replyId);

    /**
     * Retrieve customer ticket reply matching the specified search criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Inchoo\Ticket\Api\Data\TicketReplyInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

    /**
     * @param array $array
     * @return bool true on success
     */
    public function addReply($array = []);
}
