<?php
/**
 * Created by PhpStorm.
 * User: inchoo
 * Date: 5/14/19
 * Time: 9:27 AM
 */

namespace Inchoo\Ticket\Controller\Ticket;

use Inchoo\Ticket\Api\Data\TicketReplyInterface;
use Inchoo\Ticket\Api\TicketReplyRepositoryInterface;
use Magento\Framework\App\Action\Context;

class Reply extends CustomerAction
{
    /**
     * @var \Magento\Customer\Model\Session
     */
    private $session;

    /**
     * @var \Magento\Framework\Escaper
     */
    private $escaper;

    /**
     * @var TicketReplyRepositoryInterface
     */
    private $replyRepository;

    /**
     * @var \Magento\Framework\Data\Form\FormKey\Validator
     */
    private $formKeyValidator;

    /**
     * @var \Inchoo\Ticket\Api\TicketRepositoryInterface
     */
    private $ticketRepository;
    /**
     * @var \Magento\Framework\App\Request\Http
     */
    private $request;

    /**
     * Reply constructor.
     * @param Context $context
     * @param \Magento\Customer\Model\Session $session
     * @param \Magento\Framework\Escaper $escaper
     * @param TicketReplyRepositoryInterface $replyRepository
     * @param \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator
     * @param \Magento\Framework\UrlInterface $url
     * @param \Inchoo\Ticket\Api\TicketRepositoryInterface $ticketRepository
     * @param \Magento\Framework\App\Request\Http $request
     */
    public function __construct(
        Context $context,
        \Magento\Customer\Model\Session $session,
        \Magento\Framework\Escaper $escaper,
        TicketReplyRepositoryInterface $replyRepository,
        \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator,
        \Magento\Framework\UrlInterface $url,
        \Inchoo\Ticket\Api\TicketRepositoryInterface $ticketRepository,
        \Magento\Framework\App\Request\Http $request
    ) {
        parent::__construct($context, $session, $url, $ticketRepository);
        $this->session = $session;
        $this->escaper = $escaper;
        $this->replyRepository = $replyRepository;
        $this->formKeyValidator = $formKeyValidator;
        $this->ticketRepository = $ticketRepository;
        $this->request = $request;
    }

    public function execute()
    {
        $this->isCustomerLoggedIn();
        if (!$this->formKeyValidator->validate($this->getRequest())) {
            return $this->redirectToIndex();
        }

        $ticketId = (int)$this->request->getPostValue('id');
        $ticket = $this->validateAndReturnTicket($ticketId);
        if (!$ticket || $ticket->getStatus()) {
            return $this->redirectToIndex();
        }

        try {
            $ticketMessage = $this->escaper->escapeHtml($this->request->getPostValue('content'));
            if (empty($ticketMessage)) {
                $this->messageManager->addErrorMessage(__('Message cannot be empty!'));
                return $this->redirectToTicket($ticketId);
            }

            $array =
                [
                    TicketReplyInterface::MESSAGE => $ticketMessage,
                    TicketReplyInterface::TICKET_ID => $ticketId
                ];
            $this->replyRepository->addReply($array);
            $this->messageManager->addSuccessMessage(__('Replied!'));
        } catch (\Exception $exception) {
            $this->messageManager->addErrorMessage(__('Not replied!'));
        }

        return $this->redirectToTicket($ticketId);
    }
}
