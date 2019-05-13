<?php
/**
 * Created by PhpStorm.
 * User: inchoo
 * Date: 5/13/19
 * Time: 1:26 PM
 */

namespace Inchoo\Ticket\Block;

use Magento\Framework\View\Element\Template;

class Ticket extends Template
{
    public function __construct(
        Template\Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
    }
}
