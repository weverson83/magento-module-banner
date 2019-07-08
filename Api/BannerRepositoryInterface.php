<?php
namespace Weverson83\Banner\Api;

use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * @api
 */
interface BannerRepositoryInterface
{
    /**
     * Lists banners that match specified search criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria The search criteria.
     * @return \Weverson83\Banner\Api\Data\BannerSearchResultsInterface search result interface.
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);

    /**
     * Loads by Entity ID.
     *
     * @param int $bannerId The banner ID.
     * @return \Weverson83\Banner\Api\Data\BannerInterface Banner interface.
     */
    public function get($bannerId);

    /**
     * Loads by Entity ID.
     *
     * @param int $entityId The banner entity ID.
     * @return \Weverson83\Banner\Api\Data\BannerInterface Banner interface.
     */
    public function getById($entityId);

    /**
     * Delete customer link.
     *
     * @param \Weverson83\Banner\Api\Data\BannerInterface Banner interface.
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(Data\BannerInterface $banner);

    /**
     * Delete banner by entity id
     *
     * @param string $entityId
     * @return bool
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById($entityId);

    /**
     * Save banner
     *
     * @param \Weverson83\Banner\Api\Data\BannerInterface Banner interface.
     * @return \Weverson83\Banner\Api\Data\BannerInterface
     * @throws CouldNotSaveException
     */
    public function save(Data\BannerInterface $banner);
}
