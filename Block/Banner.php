<?php
namespace Weverson83\Banner\Block;

use Weverson83\Banner\Api\BannerRepositoryInterface;
use Weverson83\Banner\Api\Data\BannerInterface;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\View\Element\Template;

class Banner extends Template implements IdentityInterface
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
     * @var BannerInterface
     */
    private $banner;

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

    /**
     * Retrieves the first active banner
     *
     * @return BannerInterface|null
     */
    public function getActiveBanner(): ?BannerInterface
    {
        if (!$this->banner) {
            $this->searchCriteriaBuilder->addFilter(BannerInterface::ENABLED, 1);
            $this->searchCriteriaBuilder->setPageSize(1);
            $bannerList = $this->bannerRepository->getList($this->searchCriteriaBuilder->create());

            foreach ($bannerList->getItems() as $banner) {
                $this->banner = $banner;

                return $this->banner;
            }
        }

        return null;
    }

    /**
     * Return unique ID(s) for each object in system
     *
     * @return string[]
     */
    public function getIdentities()
    {
        $banner = $this->getActiveBanner();

        if ($banner) {
            return ['banner_id_' . $banner->getId()];
        }

        return ['banner_no_banner'];
    }
}
