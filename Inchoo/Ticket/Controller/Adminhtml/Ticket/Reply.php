<?php
/**
 * Created by PhpStorm.
 * User: inchoo
 * Date: 5/15/19
 * Time: 1:24 PM
 */

namespace Inchoo\Ticket\Controller\Adminhtml\Ticket;

use Magento\Backend\App\Action;

class Reply extends Action
{
    /**
     * @var \Magento\Framework\App\Request\Http
     */
    private $request;
    /**
     * @var \Inchoo\Ticket\Model\TicketReplyFactory
     */
    private $ticketReplyFactory;
    /**
     * @var \Inchoo\Ticket\Model\ResourceModel\TicketReply
     */
    private $ticketReplyResource;
    /**
     * @var \Magento\Framework\Escaper
     */
    private $escaper;
    /**
     * @var \Magento\Backend\Model\Auth\Session
     */
    private $authSession;

    public function __construct(
        Action\Context $context,
        \Magento\Framework\App\Request\Http $request,
        \Inchoo\Ticket\Model\TicketReplyFactory $ticketReplyFactory,
        \Inchoo\Ticket\Model\ResourceModel\TicketReply $ticketReplyResource,
        \Magento\Framework\Escaper $escaper,
        \Magento\Backend\Model\Auth\Session $authSession
    ) {
        parent::__construct($context);
        $this->request = $request;
        $this->ticketReplyFactory = $ticketReplyFactory;
        $this->ticketReplyResource = $ticketReplyResource;
        $this->escaper = $escaper;
        $this->authSession = $authSession;
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|string
     */
    public function execute()
    {
        $ticketId = (int) $this->request->getPostValue('ticket_id');
        $replyMessage = $this->escaper->escapeHtml($this->request->getPostValue('reply'));
        if (empty($replyMessage)) {
            $this->messageManager->addErrorMessage('Reply message empty!');
            return $this->_redirect('ticket/ticket/');
        }

        try {
            $reply = $this->ticketReplyFactory->create();
            $reply->setMessage($replyMessage);
            $reply->setTickedId($ticketId);
            $reply->setAdminId((int)$this->authSession->getUser()->getId());
            $this->ticketReplyResource->save($reply);
            $this->messageManager->addSuccessMessage('Replied!');
        } catch (\Exception $exception) {
            $this->messageManager->addErrorMessage('Reply not sent!');
        }

        return $this->_redirect('ticket/ticket/details/id/', ['id' => $ticketId]);
    }
}
