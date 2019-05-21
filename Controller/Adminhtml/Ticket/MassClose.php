<?php
/**
 * Created by PhpStorm.
 * User: inchoo
 * Date: 5/15/19
 * Time: 10:55 AM
 */

namespace Inchoo\Ticket\Controller\Adminhtml\Ticket;

use Inchoo\Ticket\Api\Data\TicketInterface;
use Inchoo\Ticket\Api\TicketRepositoryInterface;
use Magento\Backend\App\Action;

class MassClose extends Action
{
    const ADMIN_RESOURCE = 'Inchoo_Ticket::ticket';

    /**
     * @var TicketRepositoryInterface
     */
    private $ticketRepository;
    /**
     * @var \Inchoo\Ticket\Model\ResourceModel\Ticket\CollectionFactory
     */
    private $ticketCollectionFactory;

    /**
     * MassClose constructor.
     * @param Action\Context $context
     * @param TicketRepositoryInterface $ticketRepository
     * @param \Inchoo\Ticket\Model\ResourceModel\Ticket\CollectionFactory $ticketCollectionFactory
     */
    public function __construct(
        Action\Context $context,
        TicketRepositoryInterface $ticketRepository,
        \Inchoo\Ticket\Model\ResourceModel\Ticket\CollectionFactory $ticketCollectionFactory
    ) {
        parent::__construct($context);
        $this->ticketRepository = $ticketRepository;
        $this->ticketCollectionFactory = $ticketCollectionFactory;
    }

    /**
     * Closes all selected tickets and redirects to ticket index
     *
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|string
     */
    public function execute()
    {
        $message = null;
        $data = $this->getRequest()->getParam('selected');
        if (empty($data)) {
            return $this->_redirect('ticket/ticket/');
        }

        $allTickets = $this->ticketCollectionFactory->create()
            ->addFieldToFilter(
                TicketInterface::TICKET_ID,
                ['ticket_id', $data]
            );
        foreach ($allTickets->getItems() as $ticket) {
            try {
                /**
                 * @var $ticket TicketInterface
                 */
                $ticket->setStatus(true);
                $this->ticketRepository->save($ticket);
            } catch (\Exception $e) {
                return $message = $e->getMessage();
            }
        }

        if ($message) {
            $this->messageManager->addSuccessMessage('Tickets closed');
        } elseif ($message !== null && !$message) {
            $this->messageManager->addErrorMessage($message);
        }

        return $this->_redirect('ticket/ticket/');
    }
}
