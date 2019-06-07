<?php declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: inchoo
 * Date: 5/15/19
 * Time: 10:38 AM
 */

namespace Inchoo\Ticket\Ui\Component\Listing\Column;

use Magento\Ui\Component\Listing\Columns\Column;

/**
 * Class DetailsActions
 * @package Inchoo\Ticket\Ui\Component\Listing\Column
 */
class DetailsActions extends Column
{
    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (!isset($dataSource['data']['items'])) {
            return $dataSource;
        }

        foreach ($dataSource['data']['items'] as & $item) {
            if (isset($item['ticket_id'])) {
                $item[$this->getData('name')] = [
                    'details' => [
                        'href' => $this->context->getUrl(
                            'ticket/ticket/details',
                            ['id' => $item['ticket_id']]
                        ),
                        'label' => __('Details')
                    ]
                ];
            }
        }

        return $dataSource;
    }
}
