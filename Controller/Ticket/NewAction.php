<?php
/**
 * Created by PhpStorm.
 * User: inchoo
 * Date: 5/13/19
 * Time: 2:36 PM
 */

namespace Inchoo\Ticket\Controller\Ticket;

use Inchoo\Ticket\Api\Data\TicketInterface;
use Magento\Framework\App\Action\Context;
use Magento\Customer\Model\Session;

class NewAction extends CustomerAction
{
    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var \Magento\Framework\Data\Form\FormKey\Validator
     */
    private $formKeyValidator;
    /**
     * @var \Magento\Framework\App\Request\Http\Proxy
     */
    private $request;
    /**
     * @var \Inchoo\Ticket\Api\Data\TicketInterfaceFactory
     */
    private $ticketModelFactory;

    /**
     * NewAction constructor.
     * @param Context $context
     * @param Session $session
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Inchoo\Ticket\Api\TicketRepositoryInterface $ticketRepository
     * @param \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator
     * @param \Magento\Framework\UrlInterface $url
     * @param \Magento\Framework\App\Request\Http\Proxy $request
     * @param \Inchoo\Ticket\Api\Data\TicketInterfaceFactory $ticketModelFactory
     */
    public function __construct(
        Context $context,
        Session $session,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Inchoo\Ticket\Api\TicketRepositoryInterface $ticketRepository,
        \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator,
        \Magento\Framework\UrlInterface $url,
        \Magento\Framework\App\Request\Http\Proxy $request,
        \Inchoo\Ticket\Api\Data\TicketInterfaceFactory $ticketModelFactory
    ) {
        parent::__construct($context, $session, $url, $ticketRepository);
        $this->storeManager = $storeManager;
        $this->formKeyValidator = $formKeyValidator;
        $this->request = $request;
        $this->ticketModelFactory = $ticketModelFactory;
    }

    /**
     * Function checks if customer is logged in, if the form key is valid and if subject and message are not empty.
     * If everything is right, create ticket object, set the parameters, save the ticket and dispatch event when
     * ticket is saved. Redirect customer back to ticket index page.
     *
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $this->isCustomerLoggedIn();
        if (!$this->formKeyValidator->validate($this->getRequest())) {
            return $this->redirectToIndex();
        }

        try {
            $customerId = (int) $this->session->getCustomerId();
            $websiteId = (int) $this->storeManager->getStore()->getWebsiteId();
            $subject = $this->request->getPostValue('title');
            $message = $this->request->getPostValue('content');
            if (empty($subject) || empty($message)) {
                $this->messageManager->addErrorMessage('Form fields cannot be empty!');
                return $this->redirectToIndex();
            }

            $ticket = $this->ticketModelFactory->create();
            $ticket->setCustomerId($customerId);
            $ticket->setWebsiteId($websiteId);
            $ticket->setSubject($subject);
            $ticket->setMessage($message);
            $this->ticketRepository->save($ticket);
            $this->_eventManager->dispatch(
                'inchoo_ticket_created',
                ['ticketData' => $ticket]
            );
            $this->messageManager->addSuccessMessage(__('Ticket created!'));
        } catch (\Exception $exception) {
            $this->messageManager->addErrorMessage(__('Ticket not created!'));
        }

        return $this->redirectToIndex();
    }
}
