<?php declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: inchoo
 * Date: 5/15/19
 * Time: 12:33 PM
 */

namespace Inchoo\Ticket\Ui\Component\Form;

/**
 * Class DataProvider
 * @package Inchoo\Ticket\Ui\Component\Form
 */
class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * @var \Magento\Customer\Model\ResourceModel\CustomerRepository
     */
    private $customerRepository;

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param \Inchoo\Ticket\Model\ResourceModel\Ticket\CollectionFactory $collectionFactory
     * @param \Magento\Customer\Model\ResourceModel\CustomerRepository $customerRepository
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        \Inchoo\Ticket\Model\ResourceModel\Ticket\CollectionFactory $collectionFactory,
        \Magento\Customer\Model\ResourceModel\CustomerRepository $customerRepository,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);

        $this->collection = $collectionFactory->create();
        $this->customerRepository = $customerRepository;
    }

    /**
     * Returns data for the specific ticket and adds customer name to it.
     *
     * {@inheritdoc}
     */
    public function getData()
    {
        $data = [];
        $dataObject = $this->getCollection()->getFirstItem();

        if ($dataObject->getId()) {
            $data[$dataObject->getId()] = $dataObject->toArray();
        }
        $customerName = $this->getCustomerName($data[$dataObject->getId()]['customer_id']);
        $data[$dataObject->getId()]['customer_name'] = $customerName;
        return $data;
    }

    /**
     * Returns customer name
     *
     * @param $id
     * @return string
     */
    public function getCustomerName($id)
    {
        try {
            $customer = $this->customerRepository->getById($id);
        } catch (\Exception $exception) {
            $message = $exception->getMessage();
        }

        return ucfirst($customer->getFirstname()) . ' ' . ucfirst($customer->getLastname());
    }
}
