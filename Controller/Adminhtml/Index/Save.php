<?php
namespace Weverson83\Banner\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Cms\Model\Page;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;
use Weverson83\Banner\Api\BannerRepositoryInterface;
use Weverson83\Banner\Api\Data\BannerInterface;
use Weverson83\Banner\Model\BannerFactory;

class Save extends \Magento\Backend\App\Action implements HttpPostActionInterface
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Weverson83_Banner::save';

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var BannerFactory
     */
    private $bannerFactory;
    /**
     * @var BannerRepositoryInterface
     */
    private $bannerRepository;

    /**
     * @param Action\Context $context
     * @param DataPersistorInterface $dataPersistor
     * @param BannerFactory $bannerFactory
     * @param BannerRepositoryInterface $bannerRepository
     */
    public function __construct(
        Action\Context $context,
        DataPersistorInterface $dataPersistor,
        BannerFactory $bannerFactory,
        BannerRepositoryInterface $bannerRepository
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->bannerFactory = $bannerFactory;
        $this->bannerRepository = $bannerRepository;
        parent::__construct($context);
    }

    /**
     * Save action
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            if (isset($data['enabled']) && $data['enabled'] === 'true') {
                $data['enabled'] = Page::STATUS_ENABLED;
            }
            if (empty($data['entity_id'])) {
                $data['entity_id'] = null;
            }

            $model = $this->bannerFactory->create();

            $bannerId = $this->getRequest()->getParam('entity_id');
            if ($bannerId) {
                try {
                    $model = $this->bannerRepository->getById($bannerId);
                } catch (LocalizedException $e) {
                    $this->messageManager->addErrorMessage(__('This banner no longer exists.'));
                    return $resultRedirect->setPath('*/*/');
                }
            }

            $model->setData($data);

            try {
                $this->bannerRepository->save($model);
                $this->messageManager->addSuccessMessage(__('You saved the banner.'));
                return $this->processResultRedirect($model, $resultRedirect);
            } catch (LocalizedException $e) {
                $this->messageManager->addExceptionMessage($e->getPrevious() ?: $e);
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the banner.'));
            }

            $this->dataPersistor->set('banner', $data);

            return $resultRedirect->setPath('*/*/edit', ['entity_id' => $this->getRequest()->getParam('entity_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }

    /**
     * Process result redirect
     *
     * @param BannerInterface $model
     * @param Redirect $resultRedirect
     * @return Redirect
     */
    private function processResultRedirect($model, $resultRedirect)
    {
        $this->dataPersistor->clear('banner');
        if ($this->getRequest()->getParam('back')) {
            return $resultRedirect->setPath('*/*/edit', ['entity_id' => $model->getId(), '_current' => true]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}
