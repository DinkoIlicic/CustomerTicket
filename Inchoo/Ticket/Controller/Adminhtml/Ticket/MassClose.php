<?php
/**
 * Created by PhpStorm.
 * User: inchoo
 * Date: 5/15/19
 * Time: 10:55 AM
 */

namespace Inchoo\Ticket\Controller\Adminhtml\Ticket;

use Inchoo\Ticket\Api\TicketRepositoryInterface;
use Magento\Backend\App\Action;

class MassClose extends Action
{
    /**
     * @var TicketRepositoryInterface
     */
    private $ticketRepository;

    public function __construct(
        Action\Context $context,
        TicketRepositoryInterface $ticketRepository
    ) {
        parent::__construct($context);
        $this->ticketRepository = $ticketRepository;
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|string
     */
    public function execute()
    {
        $message = null;
        $data = $this->getRequest()->getParam('selected');
        if (empty($data)) {
            return $this->_redirect('ticket/ticket/');
        }

        foreach ($data as $id) {
            try {
                $ticket = $this->ticketRepository->getById($id);
                $ticket->setStatus(true);
                $this->ticketRepository->save($ticket);
            } catch (\Exception $e) {
                return $message = $e->getMessage();
            }
        }

        if ($message === true) {
            $this->messageManager->addSuccessMessage('Tickets closed');
        } elseif ($message !== null and $message !== true) {
            $this->messageManager->addErrorMessage($message);
        }

        return $this->_redirect('ticket/ticket/');
    }
}
