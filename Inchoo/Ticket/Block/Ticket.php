<?php
/**
 * Created by PhpStorm.
 * User: inchoo
 * Date: 5/13/19
 * Time: 1:26 PM
 */

namespace Inchoo\Ticket\Block;

use Inchoo\Ticket\Api\Data\TicketInterface;
use Inchoo\Ticket\Api\TicketRepositoryInterface;
use Magento\Framework\View\Element\Template;

class Ticket extends Template
{
    /**
     * @var TicketRepositoryInterface
     */
    private $ticketRepository;

    /**
     * @var \Magento\Framework\Api\SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * @var \Magento\Customer\Model\Session
     */
    private $session;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    private $storeManager;

    /**
     * Ticket constructor.
     * @param Template\Context $context
     * @param TicketRepositoryInterface $ticketRepository
     * @param \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder
     * @param \Magento\Customer\Model\Session $session
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        TicketRepositoryInterface $ticketRepository,
        \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder,
        \Magento\Customer\Model\Session $session,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->ticketRepository = $ticketRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->session = $session;
        $this->storeManager = $storeManager;
    }

    /**
     * @return string
     */
    public function getPostUrl()
    {
        return $this->getUrl('ticket/ticket/new');
    }

    /**
     * @param int $id
     * @return string
     */
    public function getCloseUrl($id)
    {
        return $this->getUrl('ticket/ticket/close/id/', ['id' => (int) $id]);
    }

    /**
     * @param int $id
     * @return string
     */
    public function getTicketDetailsUrl($id)
    {
        return $this->getUrl('ticket/ticket/detail/id/', ['id' => (int) $id]);
    }

    /**
     * @return TicketInterface[]|null
     */
    public function getTickets()
    {
        try {
            $customerId = $this->session->getCustomerId();
            $websiteId = $this->storeManager->getStore()->getWebsiteId();
            $this->searchCriteriaBuilder->addFilter(TicketInterface::CUSTOMER_ID, $customerId);
            $this->searchCriteriaBuilder->addFilter(TicketInterface::WEBSITE_ID, $websiteId);
            $searchCriteria = $this->searchCriteriaBuilder->create();
            $tickets = $this->ticketRepository->getList($searchCriteria)->getItems();
            return $tickets;
        } catch (\Exception $exception) {
            $tickets = $exception->getMessage();
        }

        return null;
    }
}
