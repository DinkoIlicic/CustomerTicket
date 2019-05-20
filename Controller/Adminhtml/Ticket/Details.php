<?php
/**
 * Created by PhpStorm.
 * User: inchoo
 * Date: 5/15/19
 * Time: 12:24 PM
 */

namespace Inchoo\Ticket\Controller\Adminhtml\Ticket;

use Magento\Backend\App\Action;
use Magento\Framework\Controller\ResultFactory;

class Details extends Action
{
    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * Details constructor.
     * @param Action\Context $context
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        Action\Context $context,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    ) {
        parent::__construct($context);
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * Details action
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);

        $resultPage->setActiveMenu('Inchoo_Ticket::ticket');
        $resultPage->getConfig()->getTitle()->prepend(__('Replies'));

        return $resultPage;
    }
}
