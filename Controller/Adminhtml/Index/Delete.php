<?php
namespace Weverson83\Banner\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Weverson83\Banner\Api\BannerRepositoryInterface;

class Delete extends \Magento\Backend\App\Action implements HttpPostActionInterface
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Weverson83_Banner::delete';
    /**
     * @var BannerRepositoryInterface
     */
    private $bannerRepository;

    public function __construct(Action\Context $context, BannerRepositoryInterface $bannerRepository)
    {
        parent::__construct($context);
        $this->bannerRepository = $bannerRepository;
    }

    /**
     * Delete action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        $bannerId = $this->getRequest()->getParam('entity_id');
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();

        if ($bannerId) {
            try {
                $this->bannerRepository->deleteById($bannerId);
                $this->messageManager->addSuccessMessage(__('The banner has been deleted.'));

                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['page_id' => $bannerId]);
            }
        }

        $this->messageManager->addErrorMessage(__('We can\'t find a banner to delete.'));

        return $resultRedirect->setPath('*/*/');
    }
}
