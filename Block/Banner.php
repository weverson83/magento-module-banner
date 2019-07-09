<?php
namespace Weverson83\Banner\Block;

use Magento\Cms\Model\Template\FilterProvider;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\View\Element\Template;
use Weverson83\Banner\Api\BannerRepositoryInterface;
use Weverson83\Banner\Api\Data\BannerInterface;

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
    /**
     * @var FilterProvider
     */
    private $filterProvider;

    public function __construct(
        BannerRepositoryInterface $bannerRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        FilterProvider $filterProvider,
        Template\Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->bannerRepository = $bannerRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->filterProvider = $filterProvider;
    }

    /**
     * Retrieves the first active banner
     *
     * @return BannerInterface|\Weverson83\Banner\Model\Banner
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

        return $this->banner;
    }

    /**
     * Return unique ID(s) for each object in system
     *
     * @return string[]
     */
    public function getIdentities()
    {
        if (!($this->getActiveBanner())) {
            return ['banner_no_banner'];
        }

        return $this->getActiveBanner()->getIdentities();
    }

    protected function _toHtml()
    {
        if (!($this->getActiveBanner())) {
            return '';
        }

        return $this->filterProvider->getPageFilter()->filter($this->getActiveBanner()->getContent());
    }
}
