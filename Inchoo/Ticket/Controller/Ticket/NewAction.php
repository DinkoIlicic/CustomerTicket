<?php
/**
 * Created by PhpStorm.
 * User: inchoo
 * Date: 5/13/19
 * Time: 2:36 PM
 */

namespace Inchoo\Ticket\Controller\Ticket;

use Inchoo\Ticket\Api\TicketRepositoryInterface;
use Magento\Framework\App\Action\Context;

class NewAction extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Magento\Customer\Model\Session
     */
    private $session;
    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    private $storeManager;
    /**
     * @var \Magento\Framework\Escaper
     */
    private $escaper;
    /**
     * @var TicketRepositoryInterface
     */
    private $ticketRepository;

    public function __construct(
        Context $context,
        \Magento\Customer\Model\Session $session,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Escaper $escaper,
        TicketRepositoryInterface $ticketRepository
    ) {
        parent::__construct($context);
        $this->session = $session;
        $this->storeManager = $storeManager;
        $this->escaper = $escaper;
        $this->ticketRepository = $ticketRepository;
    }

    public function execute()
    {
        try {
            $customerId = (int) $this->session->getCustomerId();
            $websiteId = (int) $this->storeManager->getStore()->getWebsiteId();
            $subject = $this->escaper->escapeHtml($this->getRequest()->getParam('subject'));
            $message = $this->escaper->escapeHtml($this->getRequest()->getParam('message'));
            $array = [
                'customer_id' => $customerId,
                'website_id' => $websiteId,
                'subject' => $subject,
                'message' => $message
            ];
            $this->ticketRepository->addTicket($array);
            $this->messageManager->addSuccessMessage(__('Ticket created!'));
        } catch (\Exception $exception) {
            $this->messageManager->addErrorMessage(__('Ticket not created!'));
        }
        return $this->_redirect('ticket/ticket/index');
    }
}
