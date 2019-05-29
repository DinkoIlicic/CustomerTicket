<?php declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: inchoo
 * Date: 5/14/19
 * Time: 11:05 AM
 */

namespace Inchoo\Ticket\Controller\Ticket;

use Inchoo\Ticket\Api\TicketRepositoryInterface;
use Magento\Framework\App\Action\Context;
use Magento\Customer\Model\Session;

class Close extends CustomerAction
{
    /**
     * Close constructor.
     * @param Context $context
     * @param TicketRepositoryInterface $ticketRepository
     * @param Session $session
     * @param \Magento\Framework\UrlInterface $url
     */
    public function __construct(
        Context $context,
        TicketRepositoryInterface $ticketRepository,
        Session $session,
        \Magento\Framework\UrlInterface $url
    ) {
        parent::__construct($context, $session, $url, $ticketRepository);
        $this->ticketRepository = $ticketRepository;
    }

    /**
     * Closes ticket for customer and returns him to my tickets section
     *
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $this->isCustomerLoggedIn();
        $ticket = $this->validateAndReturnTicket((int)$this->getRequest()->getParam('id'));
        if (!$ticket) {
            return $this->redirectToIndex();
        }

        try {
            $ticket->setStatus(true);
            $this->ticketRepository->save($ticket);
            $this->messageManager->addSuccessMessage(__('Ticket closed!'));
        } catch (\Exception $exception) {
            $this->messageManager->addErrorMessage(__('Ticket not closed, contact admin!'));
        }

        return $this->redirectToIndex();
    }
}
