<?php declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: inchoo
 * Date: 5/14/19
 * Time: 8:47 AM
 */

namespace Inchoo\Ticket\Block;

use Inchoo\Ticket\Api\Data\TicketInterface;
use Inchoo\Ticket\Api\Data\TicketReplyInterface;
use Inchoo\Ticket\Api\TicketReplyRepositoryInterface;
use Inchoo\Ticket\Api\TicketRepositoryInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\View\Element\Template;
use Magento\Customer\Model\Session;

/**
 * Class Detail
 * @package Inchoo\Ticket\Block
 */
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
     * @var Session
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
     * @var \Magento\Customer\Model\ResourceModel\CustomerRepository
     */
    private $customerRepository;
    /**
     * @var \Magento\Framework\Api\SortOrderBuilder
     */
    private $orderBuilder;

    /**
     * Detail constructor.
     * @param Template\Context $context
     * @param TicketRepositoryInterface $ticketRepository
     * @param TicketReplyRepositoryInterface $ticketReplyRepository
     * @param \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder
     * @param Session $session
     * @param \Magento\User\Model\UserFactory $userFactory
     * @param \Magento\User\Model\ResourceModel\User $userResource
     * @param \Magento\Customer\Model\ResourceModel\CustomerRepository $customerRepository
     * @param \Magento\Framework\Api\SortOrderBuilder $orderBuilder
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        TicketRepositoryInterface $ticketRepository,
        TicketReplyRepositoryInterface $ticketReplyRepository,
        \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder,
        Session $session,
        \Magento\User\Model\UserFactory $userFactory,
        \Magento\User\Model\ResourceModel\User $userResource,
        \Magento\Customer\Model\ResourceModel\CustomerRepository $customerRepository,
        \Magento\Framework\Api\SortOrderBuilder $orderBuilder,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->ticketRepository = $ticketRepository;
        $this->ticketReplyRepository = $ticketReplyRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->session = $session;
        $this->userFactory = $userFactory;
        $this->userResource = $userResource;
        $this->customerRepository = $customerRepository;
        $this->orderBuilder = $orderBuilder;
    }

    /**
     * Return formatted Date for Europe/Zagreb timezone
     *
     * @param $date
     * @return string
     */
    public function formatDateForPhtml($date)
    {
        return $this->formatDate(
            $date,
            3,
            true,
            'Europe/Zagreb'
        );
    }

    /**
     * Return Ticket Id
     *
     * @return int
     */
    public function getTickedId()
    {
        return (int) $this->getRequest()->getParam('id');
    }

    /**
     * Return all tickets
     *
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
     * Return all replies for specific ticket
     *
     * @return \Inchoo\Ticket\Api\Data\TicketReplyInterface[]|null
     */
    public function getReplies()
    {
        try {
            $this->searchCriteriaBuilder->addFilter(TicketReplyInterface::TICKET_ID, $this->getTickedId());
            $sortOrder = $this->orderBuilder->create();
            $sortOrder->setField(TicketInterface::CREATED_AT);
            $sortOrder->setDirection('DESC');
            $this->searchCriteriaBuilder->addSortOrder($sortOrder);
            $searchCriteria = $this->searchCriteriaBuilder->create();
            $replies = $this->ticketReplyRepository->getList($searchCriteria)->getItems();
            return $replies;
        } catch (LocalizedException $exception) {
            $errormsg = $exception->getMessage();
        }
        return null;
    }

    /**
     * Return customer name
     *
     * @param $id
     * @return string|null
     */
    public function getCustomerName($id)
    {
        try {
            $customer = $this->customerRepository->getById($id);
        } catch (\Exception $exception) {
            $errormsg = $exception->getMessage();
        }
        return ucfirst($customer->getFirstname()) . ' ' . ucfirst($customer->getLastname());
    }

    /**
     * Return url for form
     *
     * @return string
     */
    public function getPostUrl()
    {
        return $this->getUrl('ticket/ticket/reply');
    }

    /**
     * Return admin name
     *
     * @param $id
     * @return string
     */
    public function getAdminName($id)
    {
        $admin = $this->userFactory->create();
        $this->userResource->load($admin, (int) $id);
        return ucfirst($admin->getFirstName()) . ' ' . ucfirst($admin->getLastName());
    }
}
