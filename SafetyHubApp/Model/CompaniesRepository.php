<?php

namespace Vgroup\SafetyHubApp\Model;

use Vgroup\SafetyHubApp\Api\CompanyRepositoryInterface;
use Vgroup\SafetyHubApp\Api\Data\CompanyInterface;
use Vgroup\SafetyHubApp\Model\CompaniesFactory;
use Vgroup\SafetyHubApp\Model\CompanyDefaultLabelsFactory;
use Vgroup\SafetyHubApp\Model\ResourceModel\Companies;
use Vgroup\SafetyHubApp\Api\Data\CompaniesSearchResultsInterfaceFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessor;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

class CompaniesRepository implements CompanyRepositoryInterface
{

    /**
     * @var companiesFactory
     */
    private $companiesFactory;

    /**
     * @var companies
     */
    private $companies;

    /**
     * @param SafetyUsersItemsFactory $safetyUsersItemsFactory
     * @param SafetyUsersItems $safetyUsersItems
     */
    public function __construct(
        \Magento\Framework\Api\ExtensibleDataObjectConverter $extensibleDataObjectConverter,
        CollectionProcessor $collectionProcessor,
        CompaniesFactory $companiesFactory,
        Companies $companies,
        CompanyDefaultLabelsFactory $companyDefaultLabelsFactory,
        CompaniesSearchResultsInterfaceFactory $searchResultsFactory
    ) {
        $this->extensibleDataObjectConverter = $extensibleDataObjectConverter;
        $this->companiesFactory = $companiesFactory;
        $this->companies = $companies;
        $this->companyDefaultLabelsFactory = $companyDefaultLabelsFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * Get Company by Company Id.
     *
     * @param int $companyId
     * @return \Vgroup\SafetyHubApp\Api\Data\CompanyInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException If customer with the specified ID does not exist.
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($companyId)
    {
        $company = $this->companiesFactory->create()->load($companyId);
        return $company;
    }

    /**
     * Retrieve Company Labels List which match a specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @param int $companyId
     * @return \Vgroup\SafetyHubApp\Api\Data\CompaniesSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getLabels(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria, $companyId)
    {
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        /** @var \Vgroup\SafetyHubApp\Model\ResourceModel\CompanyDefaultLabels\Collection $collection */
        $collection = $this->companyDefaultLabelsFactory->create()->getCollection();
        $this->collectionProcessor->process($searchCriteria, $collection);

        $collection->getSelect()
            ->reset(\Zend_Db_Select::COLUMNS)
            ->columns(
                array(
                    'main_table.identifier',
                    'IF(cl.company_label IS NULL, main_table.default_label, cl.company_label) as label'
                )
            )
            ->joinLeft(
                array("cl" => 'safetyhubapp_companies_labels'),
                "( cl.identifier = main_table.identifier "
                    . "AND (cl.company_id =" . $companyId . " OR cl.company_id is null ) )",
                array()
            )
            ->where("main_table.device_type = 0 OR main_table.device_type=2");

        $collection->getSelect()->order('main_table.id DESC');
        $searchResults->setTotalCount($collection->getSize());
        $dataItems = [];
        foreach ($collection as $dataItemsModel) {
            $dataItems[$dataItemsModel->getData('identifier')] = $dataItemsModel->getData('label');
        }
        $searchResults->setItems([$dataItems]);
        return $searchResults;
    }

    public function getByCode($code)
    {
        $collection = $this->companiesFactory->create()->getCollection()
            ->addFieldToSelect(['entity_id', 'name'])
            ->addFieldToFilter('codes', array('finset' => $code)); //Add condition if you wish
        if ($collection->getSize() > 0) {
            return $collection->getFirstItem();
        } else {
            return false;
        }
    }
}
