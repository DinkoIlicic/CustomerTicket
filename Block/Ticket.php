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
     * @var \Inchoo\Ticket\Model\ResourceModel\Ticket\CollectionFactory
     */
    private $collection;

    /**
     * Ticket constructor.
     * @param Template\Context $context
     * @param TicketRepositoryInterface $ticketRepository
     * @param \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder
     * @param \Magento\Customer\Model\Session $session
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Inchoo\Ticket\Model\ResourceModel\Ticket\CollectionFactory $collection
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        TicketRepositoryInterface $ticketRepository,
        \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder,
        \Magento\Customer\Model\Session $session,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Inchoo\Ticket\Model\ResourceModel\Ticket\CollectionFactory $collection,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->ticketRepository = $ticketRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->session = $session;
        $this->storeManager = $storeManager;
        $this->collection = $collection;
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
     * Return url for form
     *
     * @return string
     */
    public function getPostUrl()
    {
        return $this->getUrl('ticket/ticket/new');
    }

    /**
     * Return url for form
     *
     * @param int $id
     * @return string
     */
    public function getCloseUrl($id)
    {
        return $this->getUrl('ticket/ticket/close/id/', ['id' => (int) $id]);
    }

    /**
     * Return url for specific ticket
     *
     * @param int $id
     * @return string
     */
    public function getTicketDetailsUrl($id)
    {
        return $this->getUrl('ticket/ticket/detail/id/', ['id' => (int) $id]);
    }


    /**
     * Prepare layout for pager
     *
     * @return \Inchoo\Ticket\Model\ResourceModel\Ticket\Collection|Template
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        if ($tickets = $this->getTicketCollection()) {
            $pager = $this->getLayout()->createBlock(
                \Magento\Theme\Block\Html\Pager::class,
                'ticket.pager'
            )->setAvailableLimit([5 => 5, 10 => 10, 15 => 15, 20 => 20])
                ->setShowPerPage(true)->setCollection(
                    $tickets
                );
            $this->setChild('pager', $pager);
            $tickets->load();
        }
        return $tickets;
    }

    /**
     * Return child html for pager
     *
     * @return string
     */
    public function getPagerHtml()
    {
        return $this->getChildHtml('pager');
    }

    /**
     * Return ticket collection for pager
     *
     * @return \Inchoo\Ticket\Model\ResourceModel\Ticket\Collection
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getTicketCollection()
    {
        $page = ($this->getRequest()->getParam('p')) ? $this->getRequest()->getParam('p') : 1;
        $pageSize = ($this->getRequest()->getParam('limit')) ? $this->getRequest(
        )->getParam('limit') : 5;

        $tickets = $this->collection->create()
            ->addFieldToFilter(
                TicketInterface::CUSTOMER_ID,
                ['eq' => $this->session->getCustomerId()]
            )->addFieldToFilter(
                TicketInterface::WEBSITE_ID,
                ['eq' => $this->storeManager->getStore()->getWebsiteId()]
            )->setOrder(
                TicketInterface::CREATED_AT,
                'DESC'
            );

        $tickets->setPageSize($pageSize);
        $tickets->setCurPage($page);
        return $tickets;
    }
}
