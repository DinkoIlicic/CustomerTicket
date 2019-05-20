<?php
/**
 * Created by PhpStorm.
 * User: inchoo
 * Date: 5/14/19
 * Time: 1:05 PM
 */

namespace Inchoo\Ticket\Controller\Ticket;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;

abstract class CustomerAction extends Action
{
    /**
     * @var \Magento\Customer\Model\Session
     */
    private $session;

    /**
     * @var \Magento\Framework\UrlInterface
     */
    private $url;

    /**
     * @var \Inchoo\Ticket\Api\TicketRepositoryInterface
     */
    private $ticketRepository;

    public function __construct(
        Context $context,
        \Magento\Customer\Model\Session $session,
        \Magento\Framework\UrlInterface $url,
        \Inchoo\Ticket\Api\TicketRepositoryInterface $ticketRepository
    ) {
        parent::__construct($context);
        $this->session = $session;
        $this->url = $url;
        $this->ticketRepository = $ticketRepository;
    }

    protected function isCustomerLoggedIn()
    {
        if (!$this->session->isLoggedIn()) {
            $this->session->setAfterAuthUrl($this->url->getCurrentUrl());
            $this->session->authenticate();
        }
    }

    protected function redirectToIndex()
    {
        $this->_redirect('ticket/ticket/');
    }

    protected function redirectToTicket($id)
    {
        $this->_redirect('ticket/ticket/detail/id/', ['id' => $id]);
    }

    protected function validateAndReturnTicket($id)
    {
        try {
            $customerId = (int) $this->session->getCustomerId();
            $ticket = $this->ticketRepository->getById((int) $id);
            if (!($customerId === (int) $ticket->getCustomerId()) || empty($ticket)) {
                $this->messageManager->addErrorMessage(__('Something went wrong, contact admin.'));
                return false;
            }
        } catch (\Exception $exception) {
            $this->messageManager->addErrorMessage(__('Something went wrong, contact admin.'));
            return false;
        }

        return $ticket;
    }
}
