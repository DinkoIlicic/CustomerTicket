<?php
/**
 * Created by PhpStorm.
 * User: inchoo
 * Date: 5/15/19
 * Time: 11:45 AM
 */

namespace Inchoo\Ticket\Controller\Adminhtml\Ticket;

use Inchoo\Ticket\Api\TicketRepositoryInterface;
use Magento\Backend\App\Action;

class MassDelete extends Action
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
        foreach ($data as $id) {
            try {
                $this->ticketRepository->deleteById($id);
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