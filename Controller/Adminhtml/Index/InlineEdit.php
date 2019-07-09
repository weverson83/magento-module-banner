<?php
namespace Weverson83\Banner\Controller\Adminhtml\Index;

use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Weverson83\Banner\Api\BannerRepositoryInterface;
use Weverson83\Banner\Api\Data\BannerInterface;

class InlineEdit extends \Magento\Backend\App\Action
{
    /**
     * Authorization level of a basic admin session
     */
    const ADMIN_RESOURCE = 'Weverson83_Banner::save';

    /**
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    protected $jsonFactory;

    /**
     * @var BannerRepositoryInterface
     */
    private $bannerRepository;

    public function __construct(
        Context $context,
        BannerRepositoryInterface $bannerRepository,
        JsonFactory $jsonFactory
    ) {
        parent::__construct($context);
        $this->bannerRepository = $bannerRepository;
        $this->jsonFactory = $jsonFactory;
    }

    /**
     * @return \Magento\Framework\Controller\ResultInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function execute()
    {
        /** @var \Magento\Framework\Controller\Result\Json $resultJson */
        $resultJson = $this->jsonFactory->create();
        $error = false;
        $messages = [];

        $postItems = $this->getRequest()->getParam('items', []);
        if (!($this->getRequest()->getParam('isAjax') && count($postItems))) {
            return $resultJson->setData([
                'messages' => [__('Please correct the data sent.')],
                'error' => true,
            ]);
        }

        foreach (array_keys($postItems) as $bannerId) {
            $banner = $this->bannerRepository->getById($bannerId);
            try {
                $bannerData = $postItems[$bannerId];
                $extendedBannerData = $banner->getData();
                $this->setBannerData($banner, $extendedBannerData, $bannerData);
                $this->bannerRepository->save($banner);
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $messages[] = $e->getMessage();
                $error = true;
            } catch (\RuntimeException $e) {
                $messages[] = $e->getMessage();
                $error = true;
            } catch (\Exception $e) {
                $messages[] = __('Something went wrong while saving the page.');
                $error = true;
            }
        }

        return $resultJson->setData([
            'messages' => $messages,
            'error' => $error
        ]);
    }

    /**
     * @param BannerInterface $banner
     * @param array $extendedBannerData
     * @param array $mannerData
     * @return $this
     */
    public function setBannerData(BannerInterface $banner, array $extendedBannerData, array $mannerData)
    {
        $banner->setData(array_merge($banner->getData(), $extendedBannerData, $mannerData));
        return $this;
    }
}
