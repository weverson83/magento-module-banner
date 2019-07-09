<?php
namespace Weverson83\Banner\Block\Adminhtml\Banner\Edit;

use Magento\Backend\Block\Widget\Context;
use Magento\Framework\Exception\NoSuchEntityException;
use Weverson83\Banner\Api\BannerRepositoryInterface;

class GenericButton
{
    /**
     * @var Context
     */
    protected $context;

    /**
     * @var BannerRepositoryInterface
     */
    private $bannerRepository;

    /**
     * @param Context $context
     */
    public function __construct(
        Context $context,
        BannerRepositoryInterface $bannerRepository
    ) {
        $this->context = $context;
        $this->bannerRepository = $bannerRepository;
    }

    /**
     * Return Banner ID
     *
     * @return int|null
     */
    public function getBannerId()
    {
        try {
            return $this->bannerRepository->getById(
                $this->context->getRequest()->getParam('entity_id')
            )->getId();
        } catch (NoSuchEntityException $e) {
        }
        return null;
    }

    /**
     * Generate url by route and parameters
     *
     * @param   string $route
     * @param   array $params
     * @return  string
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
