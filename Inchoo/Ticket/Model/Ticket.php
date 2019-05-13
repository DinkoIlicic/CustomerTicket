<?php
/**
 * Created by PhpStorm.
 * User: inchoo
 * Date: 5/13/19
 * Time: 11:53 AM
 */

namespace Inchoo\Ticket\Model;

use Inchoo\Ticket\Api\Data\TicketInterface;

class Ticket extends \Magento\Framework\Model\AbstractModel implements TicketInterface
{
    /**
     * Initialize ticket Model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\Inchoo\Ticket\Model\ResourceModel\Ticket::class);
    }

    /**
     * Get Ticket ID
     *
     * @return int
     */
    public function getId()
    {
        return $this->getData(self::TICKET_ID);
    }

    /**
     * Get subject
     *
     * @return string|null
     */
    public function getSubject()
    {
        return $this->getData(self::SUBJECT);
    }

    /**
     * Get message
     *
     * @return string|null
     */
    public function getMessage()
    {
        return $this->getData(self::MESSAGE);
    }

    /**
     * Get Customer ID
     *
     * @return int|null
     */
    public function getCustomerId()
    {
        return $this->getData(self::CUSTOMER_ID);
    }

    /**
     * Get Website ID
     *
     * @return int|null
     */
    public function getWebsiteId()
    {
        return $this->getData(self::WEBSITE_ID);
    }

    /**
     * Get Created At
     *
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->getData(self::CREATED_AT);
    }

    /**
     * Get Created At
     *
     * @return mixed
     */
    public function getUpdateAt()
    {
        return $this->getData(self::UPDATED_AT);
    }

    /**
     * Get Status
     *
     * @return boolean|null
     */
    public function getStatus()
    {
        return $this->getData(self::STATUS);
    }

    /**
     * @param int $id
     * @return TicketInterface
     */
    public function setId($id)
    {
        return $this->setData(self::TICKET_ID, $id);
    }

    /**
     * @param string $subject
     * @return TicketInterface
     */
    public function setSubject($subject)
    {
        return $this->setData(self::SUBJECT, $subject);
    }

    /**
     * @param string $message
     * @return TicketInterface
     */
    public function setMessage($message)
    {
        return $this->setData(self::MESSAGE, $message);
    }

    /**
     * @param int $customerId
     * @return TicketInterface
     */
    public function setCustomerId($customerId)
    {
        return $this->setData(self::CUSTOMER_ID, $customerId);
    }

    /**
     * @param int $websiteId
     * @return TicketInterface
     */
    public function setWebsiteId($websiteId)
    {
        return $this->setData(self::WEBSITE_ID, $websiteId);
    }

    /**
     * @param $createdAt
     * @return TicketInterface
     */
    public function setCreatedAt($createdAt)
    {
        return $this->setData(self::CREATED_AT, $createdAt);
    }

    /**
     * @param $updatedAt
     * @return TicketInterface
     */
    public function setUpdatedAt($updatedAt)
    {
        return $this->setData(self::UPDATED_AT, $updatedAt);
    }

    /**
     * @param $status
     * @return TicketInterface
     */
    public function setStatus($status)
    {
        return $this->setData(self::STATUS, $status);
    }
}
