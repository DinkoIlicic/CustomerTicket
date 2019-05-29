<?php declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: inchoo
 * Date: 5/13/19
 * Time: 11:54 AM
 */

namespace Inchoo\Ticket\Model;

use Inchoo\Ticket\Api\Data\TicketReplyInterface;
use Inchoo\Ticket\Api\Data\TicketReplySearchResultsInterface;
use Inchoo\Ticket\Api\TicketReplyRepositoryInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

class TicketReplyRepository implements TicketReplyRepositoryInterface
{
    /**
     * @var \Inchoo\Ticket\Api\Data\TicketReplyInterfaceFactory
     */
    private $ticketReplyModelFactory;

    /**
     * @var ResourceModel\TicketReply
     */
    private $ticketReplyResource;

    /**
     * @var ResourceModel\TicketReply\CollectionFactory
     */
    private $ticketReplyCollectionFactory;

    /**
     * @var \Inchoo\Ticket\Api\Data\TicketReplySearchResultsInterfaceFactory
     */
    private $searchResultsFactory;

    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;

    /**
     * TicketReplyRepository constructor.
     * @param \Inchoo\Ticket\Api\Data\TicketReplyInterfaceFactory $ticketReplyModelFactory
     * @param ResourceModel\TicketReply $ticketReplyResource
     * @param ResourceModel\TicketReply\CollectionFactory $ticketReplyCollectionFactory
     * @param \Inchoo\Ticket\Api\Data\TicketReplySearchResultsInterfaceFactory $searchResultsFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        \Inchoo\Ticket\Api\Data\TicketReplyInterfaceFactory $ticketReplyModelFactory,
        \Inchoo\Ticket\Model\ResourceModel\TicketReply $ticketReplyResource,
        \Inchoo\Ticket\Model\ResourceModel\TicketReply\CollectionFactory $ticketReplyCollectionFactory,
        \Inchoo\Ticket\Api\Data\TicketReplySearchResultsInterfaceFactory $searchResultsFactory,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->ticketReplyModelFactory = $ticketReplyModelFactory;
        $this->ticketReplyResource = $ticketReplyResource;
        $this->ticketReplyCollectionFactory = $ticketReplyCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * Retrieve reply.
     *
     * @param int $replyId
     * @return \Inchoo\Ticket\Api\Data\TicketReplyInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($replyId)
    {
        $reply = $this->ticketReplyModelFactory->create();
        $this->ticketReplyResource->load($reply, $replyId);
        if (!$reply->getId()) {
            throw new NoSuchEntityException(__('News with id "%1" does not exist.', $replyId));
        }

        return $reply;
    }

    /**
     * Save reply.
     *
     * @param \Inchoo\Ticket\Api\Data\TicketReplyInterface $reply
     * @return \Inchoo\Ticket\Api\Data\TicketReplyInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(TicketReplyInterface $reply)
    {
        try {
            $this->ticketReplyResource->save($reply);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }

        return $reply;
    }

    /**
     * Delete reply.
     *
     * @param \Inchoo\Ticket\Api\Data\TicketReplyInterface $reply
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(TicketReplyInterface $reply)
    {
        try {
            $this->ticketReplyResource->delete($reply);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }

        return true;
    }

    /**
     * DeleteById reply.
     *
     * @param int $replyId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($replyId)
    {
        try {
            $reply = $this->getById($replyId);
            $this->delete($reply);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }

        return true;
    }

    /**
     * Retrieve customer ticket reply matching the specified search criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Inchoo\Ticket\Api\Data\TicketReplySearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        /** @var \Inchoo\Ticket\Model\ResourceModel\TicketReply\Collection $collection */
        $collection = $this->ticketReplyCollectionFactory->create();

        $this->collectionProcessor->process($searchCriteria, $collection);

        /** @var TicketReplySearchResultsInterface $searchResults */
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }
}
