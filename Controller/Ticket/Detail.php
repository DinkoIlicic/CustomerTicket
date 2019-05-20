<?php
/**
 * Created by PhpStorm.
 * User: inchoo
 * Date: 5/14/19
 * Time: 8:37 AM
 */

namespace Inchoo\Ticket\Controller\Ticket;

use Magento\Framework\App\Action\Context;

class Detail extends CustomerAction
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    private $resultPageFactory;

    /**
     * @var \Magento\Customer\Model\Session
     */
    private $session;

    /**
     * @var \Inchoo\Ticket\Api\TicketRepositoryInterface
     */
    private $ticketRepository;

    /**
     * Detail constructor.
     * @param Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magento\Customer\Model\Session $session
     * @param \Magento\Framework\UrlInterface $url
     * @param \Inchoo\Ticket\Api\TicketRepositoryInterface $ticketRepository
     */
    public function __construct(
        Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Customer\Model\Session $session,
        \Magento\Framework\UrlInterface $url,
        \Inchoo\Ticket\Api\TicketRepositoryInterface $ticketRepository
    ) {
        parent::__construct($context, $session, $url, $ticketRepository);
        $this->resultPageFactory = $resultPageFactory;
        $this->session = $session;
        $this->ticketRepository = $ticketRepository;
    }

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
