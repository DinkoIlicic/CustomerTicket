<?php
/**
 * Created by PhpStorm.
 * User: inchoo
 * Date: 5/14/19
 * Time: 8:37 AM
 */

namespace Inchoo\Ticket\Controller\Ticket;

use Magento\Framework\App\Action\Context;
use Magento\Customer\Model\Session;

class Detail extends CustomerAction
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    private $resultPageFactory;

    /**
     * Detail constructor.
     * @param Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param Session $session
     * @param \Magento\Framework\UrlInterface $url
     * @param \Inchoo\Ticket\Api\TicketRepositoryInterface $ticketRepository
     */
    public function __construct(
        Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        Session $session,
        \Magento\Framework\UrlInterface $url,
        \Inchoo\Ticket\Api\TicketRepositoryInterface $ticketRepository
    ) {
        parent::__construct($context, $session, $url, $ticketRepository);
        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * Return page ticket detail index
     *
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|\Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $this->isCustomerLoggedIn();
        if (!$this->validateAndReturnTicket((int)$this->getRequest()->getParam('id'))) {
            return $this->redirectToIndex();
        }

        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->set(__('My Ticket Details'));
        return $resultPage;
    }
}
