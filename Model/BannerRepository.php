<?php
namespace Weverson83\Banner\Model;

use Weverson83\Banner\Api\BannerRepositoryInterface;
use Weverson83\Banner\Api\Data\BannerInterface;
use Weverson83\Banner\Api\Data\BannerSearchResultsInterfaceFactory;
use Weverson83\Banner\Model\ResourceModel\Banner as BannerResourceModel;
use Weverson83\Banner\Model\ResourceModel\Banner\CollectionFactory;

use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class BannerRepository implements BannerRepositoryInterface
{
    /**
     * @var BannerResourceModel
     */
    private $resourceModel;

    /**
     * @var BannerFactory
     */
    private $bannerFactory;

    /**
     * @var BannerSearchResultsInterfaceFactory
     */
    private $searchResultsFactory;

    /**
     * @var \Magento\Framework\Api\FilterBuilder
     */
    private $filterBuilder;

    /**
     * @var \Magento\Framework\Api\SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * @var \Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface
     */
    private $collectionProcessor;

    /**
     * @param BannerResourceModel $bannerFactory
     * @param BannerFactory $resourceModel
     * @param FilterBuilder $filterBuilder
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param BannerSearchResultsInterfaceFactory $searchResultsFactory
     * @param CollectionFactory $collectionFactory
     * @param CollectionProcessorInterface | null $collectionProcessor
     */
    public function __construct(
        BannerResourceModel $resourceModel,
        BannerFactory $bannerFactory,
        FilterBuilder $filterBuilder,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        BannerSearchResultsInterfaceFactory $searchResultsFactory,
        CollectionFactory $collectionFactory,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->resourceModel = $resourceModel;
        $this->bannerFactory = $bannerFactory;
        $this->filterBuilder = $filterBuilder;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->collectionFactory = $collectionFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * {@inheritdoc}
     */
    public function get($bannerId)
    {
        $banner = $this->bannerFactory->create();
        $this->resourceModel->load($banner, $bannerId, 'entity_id');
        return $banner;
    }

    /**
     * {@inheritdoc}
     */
    public function getById($entityId)
    {
        $banner = $this->bannerFactory->create();
        $this->resourceModel->load($banner, $entityId);
        return $banner;
    }

    /**
     * {@inheritdoc}
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria)
    {
        $collection = $this->collectionFactory->create();
        $this->collectionProcessor->process($searchCriteria, $collection);
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        return $searchResults;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(BannerInterface $banner)
    {
        try {
            $this->resourceModel->delete($banner);
        } catch (\Exception $exception) {
            throw new \Magento\Framework\Exception\CouldNotDeleteException(__($exception->getMessage()));
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById($entityId)
    {
        return $this->delete($this->getById($entityId));
    }

    /**
     * {@inheritdoc}
     */
    public function save(BannerInterface $banner)
    {
        try {
            $this->resourceModel->save($banner);
        } catch (\Exception $exception) {
            throw new \Magento\Framework\Exception\CouldNotSaveException(
                __('Could not save banner: %1', $exception->getMessage()),
                $exception
            );
        }
        return $banner;
    }
}
