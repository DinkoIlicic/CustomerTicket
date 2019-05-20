<?php
/**
 * Created by PhpStorm.
 * User: inchoo
 * Date: 5/13/19
 * Time: 10:39 AM
 */

namespace Inchoo\Ticket\Api\Data;

interface TicketInterface
{
    const TICKET_ID     = 'ticket_id';
    const SUBJECT       = 'subject';
    const MESSAGE       = 'message';
    const CUSTOMER_ID   = 'customer_id';
    const WEBSITE_ID    = 'website_id';
    const CREATED_AT    = 'created_at';
    const UPDATED_AT    = 'updated_at';
    const STATUS        = 'status';

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId();

    /**
     * Get subject
     *
     * @return string|null
     */
    public function getSubject();

    /**
     * Get message
     *
     * @return string|null
     */
    public function getMessage();

    /**
     * Get Customer ID
     *
     * @return int|null
     */
    public function getCustomerId();

    /**
     * Get Website ID
     *
     * @return int|null
     */
    public function getWebsiteId();

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
     * Get Status
     *
     * @return boolean|null
     */
    public function getStatus();

    /**
     * @param int $id
     * @return TicketInterface
     */
    public function setId($id);

    /**
     * @param string $subject
     * @return TicketInterface
     */
    public function setSubject($subject);

    /**
     * @param string $message
     * @return TicketInterface
     */
    public function setMessage($message);

    /**
     * @param int $customerId
     * @return TicketInterface
     */
    public function setCustomerId($customerId);

    /**
     * @param int $websiteId
     * @return TicketInterface
     */
    public function setWebsiteId($websiteId);

    /**
     * @param $createdAt
     * @return TicketInterface
     */
    public function setCreatedAt($createdAt);

    /**
     * @param $updatedAt
     * @return TicketInterface
     */
    public function setUpdatedAt($updatedAt);

    /**
     * @param $status
     * @return TicketInterface
     */
    public function setStatus($status);
}
