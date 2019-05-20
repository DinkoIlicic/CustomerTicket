<?php
/**
 * Created by PhpStorm.
 * User: inchoo
 * Date: 5/13/19
 * Time: 10:39 AM
 */

namespace Inchoo\Ticket\Api\Data;

interface TicketReplyInterface
{
    const REPLY_ID      = 'reply_id';
    const MESSAGE       = 'message';
    const TICKET_ID     = 'ticket_id';
    const ADMIN_ID      = 'admin_id';
    const CREATED_AT    = 'created_at';
    const UPDATED_AT    = 'updated_at';

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId();

    /**
     * Get message
     *
     * @return string|null
     */
    public function getMessage();

    /**
     * Get Ticket ID
     *
     * @return int|null
     */
    public function getTickedId();

    /**
     * Get Admin ID
     *
     * @return int|null
     */
    public function getAdminId();

    /**
     * Get Created At
     *
     * @return mixed
     */
    public function getCreatedAt();

    /**
     * Get Created At
     *
     * @return mixed
     */
    public function getUpdateAt();

    /**
     * @param int $id
     * @return TicketReplyInterface
     */
    public function setId($id);

    /**
     * @param string $message
     * @return TicketReplyInterface
     */
    public function setMessage($message);

    /**
     * @param int $tickedId
     * @return TicketReplyInterface
     */
    public function setTickedId($tickedId);

    /**
     * @param int $adminId
     * @return TicketReplyInterface
     */
    public function setAdminId($adminId);

    /**
     * @param $createdAt
     * @return TicketReplyInterface
     */
    public function setCreatedAt($createdAt);

    /**
     * @param $updatedAt
     * @return TicketReplyInterface
     */
    public function setUpdatedAt($updatedAt);
}
