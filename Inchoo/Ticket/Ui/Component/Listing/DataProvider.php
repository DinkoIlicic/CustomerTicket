<?php
/**
 * Created by PhpStorm.
 * User: inchoo
 * Date: 5/15/19
 * Time: 10:22 AM
 */

namespace Inchoo\Ticket\Ui\Component\Listing;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param \Inchoo\Ticket\Model\ResourceModel\Ticket\CollectionFactory $collectionFactory
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        \Inchoo\Ticket\Model\ResourceModel\Ticket\CollectionFactory $collectionFactory,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);

        $this->collection = $collectionFactory->create();
    }

    /**
     * This class can be declared with virtualType
     *
     * {@inheritdoc}
     */
    public function getData()
    {
        $data = $this->getCollection()->toArray();
        return $data;
    }
}
