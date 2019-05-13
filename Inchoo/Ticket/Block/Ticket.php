<?php
/**
 * Created by PhpStorm.
 * User: inchoo
 * Date: 5/13/19
 * Time: 1:26 PM
 */

namespace Inchoo\Ticket\Block;

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

    public function getPostUrl()
    {
        return $this->getUrl('ticket/ticket/new');
    }

    public function getTickets()
    {
        try {
            $customerId = $this->session->getCustomerId();
            $websiteId = $this->storeManager->getStore()->getWebsiteId();
            $this->searchCriteriaBuilder->addFilter('customer_id', $customerId);
            $this->searchCriteriaBuilder->addFilter('website_id', $websiteId);
            $searchCriteria = $this->searchCriteriaBuilder->create();
            $tickets = $this->ticketRepository->getList($searchCriteria)->getItems();
            return $tickets;
        } catch (\Exception $exception) {
            return $tickets = null;
        }
    }
}
