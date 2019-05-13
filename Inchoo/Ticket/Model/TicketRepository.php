<?php
/**
 * Created by PhpStorm.
 * User: inchoo
 * Date: 5/13/19
 * Time: 11:54 AM
 */

namespace Inchoo\Ticket\Model;

use Inchoo\Ticket\Api\Data\TicketInterface;
use Inchoo\Ticket\Api\Data\TicketSearchResultsInterface;
use Inchoo\Ticket\Api\TicketRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

class TicketRepository implements TicketRepositoryInterface
{
    /**
     * @var \Inchoo\Ticket\Api\Data\TicketInterfaceFactory
     */
    private $ticketModelFactory;
    /**
     * @var ResourceModel\Ticket
     */
    private $ticketResource;
    /**
     * @var ResourceModel\Ticket\CollectionFactory
     */
    private $ticketCollectionFactory;
    /**
     * @var \Inchoo\Ticket\Api\Data\TicketSearchResultsInterfaceFactory
     */
    private $searchResultsFactory;
    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;

    /**
     * TicketRepository constructor.
     * @param \Inchoo\Ticket\Api\Data\TicketInterfaceFactory $ticketModelFactory
     * @param ResourceModel\Ticket $ticketResource
     * @param ResourceModel\Ticket\CollectionFactory $ticketCollectionFactory
     * @param \Inchoo\Ticket\Api\Data\TicketSearchResultsInterfaceFactory $searchResultsFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        \Inchoo\Ticket\Api\Data\TicketInterfaceFactory $ticketModelFactory,
        \Inchoo\Ticket\Model\ResourceModel\Ticket $ticketResource,
        \Inchoo\Ticket\Model\ResourceModel\Ticket\CollectionFactory $ticketCollectionFactory,
        \Inchoo\Ticket\Api\Data\TicketSearchResultsInterfaceFactory $searchResultsFactory,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->ticketModelFactory = $ticketModelFactory;
        $this->ticketResource = $ticketResource;
        $this->ticketCollectionFactory = $ticketCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * Retrieve ticket.
     *
     * @param int $ticketId
     * @return \Inchoo\Ticket\Api\Data\TicketInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($ticketId)
    {
        $ticket = $this->ticketModelFactory->create();
        $this->ticketResource->load($ticket, $ticketId);
        if (!$ticket->getId()) {
            throw new NoSuchEntityException(__('News with id "%1" does not exist.', $ticketId));
        }

        return $ticket;
    }

    /**
     * Save ticket.
     *
     * @param \Inchoo\Ticket\Api\Data\TicketInterface $ticket
     * @return \Inchoo\Ticket\Api\Data\TicketInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(TicketInterface $ticket)
    {
        try {
            $this->ticketResource->save($ticket);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }

        return $ticket;
    }

    /**
     * Delete ticket.
     *
     * @param \Inchoo\Ticket\Api\Data\TicketInterface $ticket
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(TicketInterface $ticket)
    {
        try {
            $this->ticketResource->delete($ticket);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }

        return true;
    }

    /**
     * DeleteById ticked.
     *
     * @param int $ticketId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($ticketId)
    {
        try {
            $ticket = $this->getById($ticketId);
            $this->delete($ticket);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }

        return true;
    }

    /**
     * Retrieve customer ticket matching the specified search criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Inchoo\Ticket\Api\Data\TicketSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        /** @var \Inchoo\Ticket\Model\ResourceModel\Ticket\Collection $collection */
        $collection = $this->ticketCollectionFactory->create();

        $this->collectionProcessor->process($searchCriteria, $collection);

        /** @var TicketSearchResultsInterface $searchResults */
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * @param array $array
     * @return bool|void
     * @throws CouldNotSaveException
     */
    public function addTicket($array = [])
    {
        try {
            /**
             * @var TicketInterface $ticket
             */
            $ticket = $this->ticketModelFactory->create();
            $ticket->setCustomerId($array['customer_id']);
            $ticket->setWebsiteId($array['website_id']);
            $ticket->setSubject($array['subject']);
            $ticket->setMessage($array['message']);
            $this->save($ticket);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }
    }
}
