<?php

namespace Vgroup\SafetyHubApp\Model;

use Vgroup\SafetyHubApp\Api\SafetyItemsRepositoryInterface;
use Vgroup\SafetyHubApp\Api\Data\SafetyItemsInterface;
use Vgroup\SafetyHubApp\Model\SafetyItemsFactory;
use Vgroup\SafetyHubApp\Api\Data\SafetyItemsSearchResultsInterfaceFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessor;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

class SafetyItemsRepository implements SafetyItemsRepositoryInterface
{

    /**
     * @var SafetyItemsFactory
     */
    private $safetyItemsFactory;

    /**
     * @var SafetyItemsSearchResultsInterfaceFactory
     */
    private $searchResultsFactory;

    /**
     * @var CollectionProcessor
     */
    private $collectionProcessor;

    /**
     * @var ExtensibleDataObjectConverter
     */
    protected $extensibleDataObjectConverter;

    /**
     * @param SafetyItemsFactory $safetyItemsFactory
     * @param SafetyItemsSearchResultsInterfaceFactory $searchResultsFactory
     * @param ExtensibleDataObjectConverter $extensibleDataObjectConverter
     * @param CollectionProcessorInterface $collectionProcessor
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(\Magento\Framework\Api\ExtensibleDataObjectConverter $extensibleDataObjectConverter, SafetyItemsFactory $safetyItemsFactory, SafetyItemsSearchResultsInterfaceFactory $searchResultsFactory, CollectionProcessor $collectionProcessor)
    {
        $this->extensibleDataObjectConverter = $extensibleDataObjectConverter;
        $this->safetyItemsFactory = $safetyItemsFactory;
        $this->collectionProcessor = $collectionProcessor;
        $this->searchResultsFactory = $searchResultsFactory;
    }

    /**
     * Retrieve User SafetyItems List which match a specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @param int $customerId
     * @param int $isApi
     * @return \Vgroup\SafetyHubApp\Api\Data\SafetyItemsSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria, $customerId, $isApi)
    {
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        /** @var \Vgroup\SafetyHubApp\Model\ResourceModel\SafetyItems\Collection $collection */
        $collection = $this->safetyItemsFactory->create()->getCollection();
        //echo $collection->getSelect();
        $this->collectionProcessor->process($searchCriteria, $collection);
        $searchResults->setTotalCount($collection->getSize());
        $safetyItems = [];
        /** @var \Vgroup\SafetyHubApp\Model\SafetyItems $safetyItemsModel */
        foreach ($collection as $safetyItemsModel) {
            if ($isApi == 1) {
                $otherData = $safetyItemsModel->getMetaData($safetyItemsModel, $customerId);
                $safetyItemsModel->setLocations($otherData['locations']);
                $safetyItemsModel->setNicknames($otherData['nicknames']);
                $safetyItemsModel->setSerialNumbers($otherData['serial_numbers']);
            }
            $safetyItemData = $safetyItemsModel->getData();
            unset($safetyItemData['description']);
            $safetyItems[] = $safetyItemData;
        }
        $searchResults->setItems($safetyItems);
        return $searchResults;
    }

    /**
     * Get User SafetyItem by SafetyItem ID.
     * @param int $id 
     * @return \Vgroup\SafetyHubApp\Api\Data\SafetyItemsInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException If SafetyItem with the specified ID does not exist.
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($id)
    {
        $safetyItem = $this->safetyItemsFactory->create()->load($id);
        if (!$safetyItem->getId()) {
            throw new NoSuchEntityException(__('Unable to find Safety Item with ID "%1"', $id));
        }
        return $safetyItem;
    }

    /**
     * Save User Safety Item
     * @param \Vgroup\SafetyHubApp\Api\Data\SafetyItemsInterface $safetyItem 
     * @return \Vgroup\SafetyHubApp\Api\Data\SafetyItemsInterface
     * @throws CouldNotSaveException
     */
    public function save(SafetyItemsInterface $safetyItem)
    {

        try {
            $safetyItemData = $this->extensibleDataObjectConverter->toNestedArray(
                $safetyItem,
                [],
                '\Vgroup\SafetyHubApp\Api\Data\SafetyItemsInterface'
            );

            $safetyItemModel = $this->safetyItemsFactory->create(['data' => $safetyItemData]);
            $safetyItemModel->setId($safetyItem->getId());
            //return $safetyItemData;
            //$newSafetyItem->setData($safetyItemData);
            $safetyItemModel->save();
        } catch (\Exception $exception) {

            throw new CouldNotSaveException(
                __('Could not save the safety item: %1', $exception->getMessage()),
                $exception
            );
        }
        return $safetyItemModel;
    }

    /**
     * Delete Users Safety Item Id.
     *
     * @param int $id
     * @return bool true on success
     */
    public function deleteById($id)
    {

        try {
            $safetyItem = $this->safetyItemsFactory->create();
            $safetyItem->load($id)->delete();
            return true;
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__('Could not delete the safety item: %1', $exception->getMessage()), $exception);
        }
    }

    public function getByModelNumber($code, $type)
    {
        $collection = $this->safetyItemsFactory->create()->getCollection()
            ->addFieldToSelect(['entity_id', 'title'])
            ->addFieldToFilter('model_number', array('finset' => $code))
            ->addFieldToFilter('type', array('eq' => $type)); //Add condition if you wish
        if ($collection->getSize() > 0) {
            return $collection->getFirstItem();
        } else {
            return false;
        }
    }
}
