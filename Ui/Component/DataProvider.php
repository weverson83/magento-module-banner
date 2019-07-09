<?php
namespace Weverson83\Banner\Ui\Component;

use Magento\Framework\Api\SearchCriteriaBuilder;
use Weverson83\Banner\Api\BannerRepositoryInterface;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * @var BannerRepositoryInterface
     */
    private $bannerRepository;
    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * DataProvider constructor.
     * @param $name
     * @param $primaryFieldName
     * @param $requestFieldName
     * @param BannerRepositoryInterface $bannerRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        BannerRepositoryInterface $bannerRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->bannerRepository = $bannerRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    /**
     * {@inheritdoc}
     */
    public function getData()
    {
        $bannerList = $this->bannerRepository->getList($this->searchCriteriaBuilder->create());

        $items = [];
        foreach ($bannerList->getItems() as $banner) {
            $items[] = [
                'entity_id' => $banner->getId(),
                'enabled' => $banner->isEnabled() ? 1 : 0,
                'created_at' => $banner->getCreatedAt(),
                'updated_at' => $banner->getUpdatedAt(),
            ];
        }

        return [
            'totalRecords' => $bannerList->getTotalCount(),
            'items' => $items
        ];
    }

    public function setLimit($offset, $size)
    {
        $this->searchCriteriaBuilder->setPageSize($size);
    }

    public function addOrder($field, $direction)
    {
        return $this;
    }

    public function addFilter(\Magento\Framework\Api\Filter $filter)
    {
        $this->searchCriteriaBuilder->addFilter($filter->getField(), $filter->getValue(), $filter->getConditionType());
    }

    public function addField($field, $alias = null)
    {
        return $this;
    }

}
