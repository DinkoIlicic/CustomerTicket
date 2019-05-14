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
     * Reply constructor.
     * @param Context $context
     * @param \Magento\Customer\Model\Session $session
     * @param \Magento\Framework\Escaper $escaper
     * @param TicketReplyRepositoryInterface $replyRepository
     * @param \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator
     * @param \Magento\Framework\UrlInterface $url
     * @param \Inchoo\Ticket\Api\TicketRepositoryInterface $ticketRepository
     */
    public function __construct(
        Context $context,
        \Magento\Customer\Model\Session $session,
        \Magento\Framework\Escaper $escaper,
        TicketReplyRepositoryInterface $replyRepository,
        \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator,
        \Magento\Framework\UrlInterface $url,
        \Inchoo\Ticket\Api\TicketRepositoryInterface $ticketRepository
    ) {
        parent::__construct($context, $session, $url, $ticketRepository);
        $this->session = $session;
        $this->escaper = $escaper;
        $this->replyRepository = $replyRepository;
        $this->formKeyValidator = $formKeyValidator;
        $this->ticketRepository = $ticketRepository;
    }

    public function execute()
    {
        $this->isCustomerLoggedIn();
        if (!$this->formKeyValidator->validate($this->getRequest())) {
            return $this->redirectToIndex();
        }

        $ticketId = (int)$this->getRequest()->getParam('id');
        if (!$this->validateTicket($ticketId)) {
            return $this->redirectToIndex();
        }

        try {
            $message = $this->escaper->escapeHtml($this->getRequest()->getParam('content'));
            if (!$message) {
                $this->messageManager->addErrorMessage(__('Data missing!'));
                return $this->redirectToIndex();
            }

            $array =
                [
                    TicketReplyInterface::MESSAGE => $message,
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
