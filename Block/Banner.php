<?php
namespace Weverson83\Banner\Block;

use Weverson83\Banner\Api\BannerRepositoryInterface;
use Weverson83\Banner\Api\Data\BannerInterface;

use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\View\Element\Template;

class Banner extends Template
{
    /**
     * @var BannerRepositoryInterface
     */
    private $bannerRepository;
    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    public function __construct(
        BannerRepositoryInterface $bannerRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        Template\Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->bannerRepository = $bannerRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    public function getActiveBanner(): ?BannerInterface
    {
        $this->searchCriteriaBuilder->addFilter(BannerInterface::ENABLED, 1);
        $this->searchCriteriaBuilder->setPageSize(1);
        $bannerList = $this->bannerRepository->getList($this->searchCriteriaBuilder->create());

        foreach ($bannerList->getItems() as $banner) {
            return $banner;
        }

        return null;
    }
}
