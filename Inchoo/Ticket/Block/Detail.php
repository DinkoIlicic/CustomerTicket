<?php
/**
 * Created by PhpStorm.
 * User: inchoo
 * Date: 5/14/19
 * Time: 8:47 AM
 */

namespace Inchoo\Ticket\Block;

use Inchoo\Ticket\Api\Data\TicketReplyInterface;
use Inchoo\Ticket\Api\TicketReplyRepositoryInterface;
use Inchoo\Ticket\Api\TicketRepositoryInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\View\Element\Template;

class Detail extends Template
{
    /**
     * @var TicketRepositoryInterface
     */
    private $ticketRepository;

    /**
     * @var TicketReplyRepositoryInterface
     */
    private $ticketReplyRepository;

    /**
     * @var \Magento\Framework\Api\SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * @var \Magento\Customer\Model\Session
     */
    private $session;
    /**
     * @var \Magento\User\Model\UserFactory
     */
    private $userFactory;
    /**
     * @var \Magento\User\Model\ResourceModel\User
     */
    private $userResource;

    /**
     * Detail constructor.
     * @param Template\Context $context
     * @param TicketRepositoryInterface $ticketRepository
     * @param TicketReplyRepositoryInterface $ticketReplyRepository
     * @param \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder
     * @param \Magento\Customer\Model\Session $session
     * @param \Magento\User\Model\UserFactory $userFactory
     * @param \Magento\User\Model\ResourceModel\User $userResource
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        TicketRepositoryInterface $ticketRepository,
        TicketReplyRepositoryInterface $ticketReplyRepository,
        \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder,
        \Magento\Customer\Model\Session $session,
        \Magento\User\Model\UserFactory $userFactory,
        \Magento\User\Model\ResourceModel\User $userResource,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->ticketRepository = $ticketRepository;
        $this->ticketReplyRepository = $ticketReplyRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->session = $session;
        $this->userFactory = $userFactory;
        $this->userResource = $userResource;
    }

    /**
     * @return int
     */
    public function getTickedId()
    {
        return (int) $this->getRequest()->getParam('id');
    }

    /**
     * @return \Inchoo\Ticket\Api\Data\TicketInterface|null
     */
    public function getTicketDetails()
    {
        try {
            $ticket = $this->ticketRepository->getById($this->getTickedId());
            return $ticket;
        } catch (LocalizedException $exception) {
            $errormsg = $exception->getMessage();
        }

        return null;
    }

    /**
     * @return \Inchoo\Ticket\Api\Data\TicketReplyInterface[]|null
     */
    public function getReplies()
    {
        try {
            $this->searchCriteriaBuilder->addFilter(TicketReplyInterface::TICKET_ID, $this->getTickedId());
            $searchCriteria = $this->searchCriteriaBuilder->create();
            $replies = $this->ticketReplyRepository->getList($searchCriteria)->getItems();
            return $replies;
        } catch (LocalizedException $exception) {
            $errormsg = $exception->getMessage();
        }
        return null;
    }

    /**
     * @return string
     */
    public function getCustomerName()
    {
        return ucfirst($this->session->getCustomerData()->getFirstname()) . ' ' . ucfirst($this->session->getCustomerData()->getLastname());
    }

    /**
     * @return string
     */
    public function getPostUrl()
    {
        return $this->getUrl('ticket/ticket/reply');
    }

    public function getAdminName($id)
    {
        $admin = $this->userFactory->create();
        $this->userResource->load($admin, (int) $id);
        return ucfirst($admin->getFirstName()) . ' ' . ucfirst($admin->getLastName());
    }
}