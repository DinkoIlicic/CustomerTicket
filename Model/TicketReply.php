<?php declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: inchoo
 * Date: 5/13/19
 * Time: 11:53 AM
 */

namespace Inchoo\Ticket\Model;

use Inchoo\Ticket\Api\Data\TicketReplyInterface;

class TicketReply extends \Magento\Framework\Model\AbstractModel implements TicketReplyInterface
{
    /**
     * Initialize ticket Model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\Inchoo\Ticket\Model\ResourceModel\TicketReply::class);
    }

    /**
     * Get Ticket Reply ID
     *
     * @return int
     */
    public function getId()
    {
        return $this->getData(self::REPLY_ID);
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
     * Get Ticket ID
     *
     * @return int|null
     */
    public function getTickedId()
    {
        return $this->getData(self::TICKET_ID);
    }

    /**
     * Get Admin ID
     *
     * @return int|null
     */
    public function getAdminId()
    {
        return $this->getData(self::ADMIN_ID);
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
     * @param int $id
     * @return TicketReplyInterface
     */
    public function setId($id)
    {
        return $this->setData(self::REPLY_ID, $id);
    }

    /**
     * @param string $message
     * @return TicketReplyInterface
     */
    public function setMessage($message)
    {
        return $this->setData(self::MESSAGE, $message);
    }

    /**
     * @param int $tickedId
     * @return TicketReplyInterface
     */
    public function setTickedId($tickedId)
    {
        return $this->setData(self::TICKET_ID, $tickedId);
    }

    /**
     * @param int $adminId
     * @return TicketReplyInterface
     */
    public function setAdminId($adminId)
    {
        return $this->setData(self::ADMIN_ID, $adminId);
    }

    /**
     * @param $createdAt
     * @return TicketReplyInterface
     */
    public function setCreatedAt($createdAt)
    {
        return $this->setData(self::CREATED_AT, $createdAt);
    }

    /**
     * @param $updatedAt
     * @return TicketReplyInterface
     */
    public function setUpdatedAt($updatedAt)
    {
        return $this->setData(self::UPDATED_AT, $updatedAt);
    }
}
