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
    protected $session;

    /**
     * @var \Magento\Framework\UrlInterface
     */
    protected $url;

    /**
     * @var \Inchoo\Ticket\Api\TicketRepositoryInterface
     */
    protected $ticketRepository;

    /**
     * CustomerAction constructor.
     * @param Context $context
     * @param \Magento\Customer\Model\Session $session
     * @param \Magento\Framework\UrlInterface $url
     * @param \Inchoo\Ticket\Api\TicketRepositoryInterface $ticketRepository
     */
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

    /**
     * Checks if user is logged in. If not, send him to login page and return him to where he was
     */
    protected function isCustomerLoggedIn()
    {
        if (!$this->session->isLoggedIn()) {
            $this->session->setAfterAuthUrl($this->url->getCurrentUrl());
            $this->session->authenticate();
        }
    }

    /**
     * Return redirect to ticket index
     *
     * @return \Magento\Framework\App\ResponseInterface
     */
    protected function redirectToIndex()
    {
        return $this->_redirect('ticket/ticket/');
    }

    /**
     * Return redirect to ticket detail index
     *
     * @param $id
     * @return \Magento\Framework\App\ResponseInterface
     */
    protected function redirectToTicket($id)
    {
        return $this->_redirect('ticket/ticket/detail/id/', ['id' => $id]);
    }

    /**
     * Checks if ticket exists and if it belongs to the customer. Return the ticket if statements are true.
     *
     * @param $id
     * @return bool|\Inchoo\Ticket\Api\Data\TicketInterface
     */
    protected function validateAndReturnTicket($id)
    {
        try {
            $customerId = (int) $this->session->getCustomerId();
            $ticket = $this->ticketRepository->getById((int) $id);
            if (!($customerId === (int) $ticket->getCustomerId())) {
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
