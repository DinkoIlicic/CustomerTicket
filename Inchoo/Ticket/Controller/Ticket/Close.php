<?php
/**
 * Created by PhpStorm.
 * User: inchoo
 * Date: 5/14/19
 * Time: 11:05 AM
 */

namespace Inchoo\Ticket\Controller\Ticket;

use Inchoo\Ticket\Api\TicketRepositoryInterface;
use Magento\Framework\App\Action\Context;

class Close extends CustomerAction
{
    /**
     * @var TicketRepositoryInterface
     */
    private $ticketRepository;

    /**
     * @var \Magento\Customer\Model\Session
     */
    private $session;

    /**
     * Close constructor.
     * @param Context $context
     * @param TicketRepositoryInterface $ticketRepository
     * @param \Magento\Customer\Model\Session $session
     * @param \Magento\Framework\UrlInterface $url
     */
    public function __construct(
        Context $context,
        TicketRepositoryInterface $ticketRepository,
        \Magento\Customer\Model\Session $session,
        \Magento\Framework\UrlInterface $url
    ) {
        parent::__construct($context, $session, $url, $ticketRepository);
        $this->ticketRepository = $ticketRepository;
        $this->session = $session;
    }

    public function execute()
    {
        $this->isCustomerLoggedIn();
        if (!$this->validateTicket((int)$this->getRequest()->getParam('id'))) {
            return $this->redirectToIndex();
        }

        try {
            $ticket = $this->ticketRepository->getById((int)$this->getRequest()->getParam('id'));
            $ticket->setStatus(true);
            $this->ticketRepository->save($ticket);
            $this->messageManager->addSuccessMessage(__('Ticket closed!'));
        } catch (\Exception $exception) {
            $this->messageManager->addErrorMessage(__('Ticket not closed, contact admin!'));
        }

        return $this->redirectToIndex();
    }
}
