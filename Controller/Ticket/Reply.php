<?php
/**
 * Created by PhpStorm.
 * User: inchoo
 * Date: 5/14/19
 * Time: 9:27 AM
 */

namespace Inchoo\Ticket\Controller\Ticket;

use Inchoo\Ticket\Api\TicketReplyRepositoryInterface;
use Magento\Framework\App\Action\Context;
use Magento\Customer\Model\Session;

class Reply extends CustomerAction
{
    /**
     * @var TicketReplyRepositoryInterface
     */
    private $replyRepository;

    /**
     * @var \Magento\Framework\Data\Form\FormKey\Validator
     */
    private $formKeyValidator;

    /**
     * @var \Magento\Framework\App\Request\Http\Proxy
     */
    private $request;
    /**
     * @var \Inchoo\Ticket\Api\Data\TicketReplyInterfaceFactory
     */
    private $ticketReplyModelFactory;

    /**
     * Reply constructor.
     * @param Context $context
     * @param Session $session
     * @param TicketReplyRepositoryInterface $replyRepository
     * @param \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator
     * @param \Magento\Framework\UrlInterface $url
     * @param \Inchoo\Ticket\Api\TicketRepositoryInterface $ticketRepository
     * @param \Magento\Framework\App\Request\Http\Proxy $request
     * @param \Inchoo\Ticket\Api\Data\TicketReplyInterfaceFactory $ticketReplyModelFactory
     */
    public function __construct(
        Context $context,
        Session $session,
        TicketReplyRepositoryInterface $replyRepository,
        \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator,
        \Magento\Framework\UrlInterface $url,
        \Inchoo\Ticket\Api\TicketRepositoryInterface $ticketRepository,
        \Magento\Framework\App\Request\Http\Proxy $request,
        \Inchoo\Ticket\Api\Data\TicketReplyInterfaceFactory $ticketReplyModelFactory
    ) {
        parent::__construct($context, $session, $url, $ticketRepository);
        $this->replyRepository = $replyRepository;
        $this->formKeyValidator = $formKeyValidator;
        $this->request = $request;
        $this->ticketReplyModelFactory = $ticketReplyModelFactory;
    }

    /**
     * Function checks if customer is logged in, form key is valid and if reply message is not empty. If everything is
     * right, create reply object and save it. Redirect customer back to ticket details page.
     *
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     */
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
            $ticketMessage = $this->request->getPostValue('content');
            if (empty($ticketMessage)) {
                $this->messageManager->addErrorMessage(__('Message cannot be empty!'));
                return $this->redirectToTicket($ticketId);
            }
            $reply = $this->ticketReplyModelFactory->create();
            $reply->setMessage($ticketMessage);
            $reply->setTickedId($ticketId);
            $this->replyRepository->save($reply);
            $this->messageManager->addSuccessMessage(__('Replied!'));
        } catch (\Exception $exception) {
            $this->messageManager->addErrorMessage(__('Not replied!'));
        }

        return $this->redirectToTicket($ticketId);
    }
}
