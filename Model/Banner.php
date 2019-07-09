<?php
namespace Weverson83\Banner\Model;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;
use Weverson83\Banner\Api\Data\BannerInterface;
use Weverson83\Banner\Model\ResourceModel\Banner as BannerResourceModel;

class Banner extends AbstractModel implements BannerInterface, IdentityInterface
{
    protected function _construct()
    {
        $this->_init(BannerResourceModel::class);
    }

    /**
     * Get banner html content
     *
     * @return string|null
     */
    public function getContent()
    {
        return $this->getData(self::CONTENT);
    }

    /**
     * Set banner html content
     *
     * @param string $content
     * @return $this
     */
    public function setContent($content)
    {
        return $this->setData(self::CONTENT, $content);
    }

    /**
     * Check if banner is enabled
     *
     * @return bool
     */
    public function isEnabled()
    {
        return (bool) $this->getData(self::ENABLED);
    }

    /**
     * Set enabled or disabled
     *
     * @param bool $enabled
     * @return $this
     */
    public function setEnabled($enabled)
    {
        return $this->setData(self::ENABLED, $enabled);
    }

    /**
     * Get created at time
     *
     * @return string|null
     */
    public function getCreatedAt()
    {
        return $this->getData(self::CREATED_AT);
    }

    /**
     * Set created at time
     *
     * @param string $createdAt
     * @return $this
     */
    public function setCreatedAt($createdAt)
    {
        return $this->setData(self::CREATED_AT, $createdAt);
    }

    /**
     * Get updated at time
     *
     * @return string|null
     */
    public function getUpdatedAt()
    {
        return $this->getData(self::UPDATED_AT);
    }

    /**
     * Set updated at time
     *
     * @param string $updatedAt
     * @return $this
     */
    public function setUpdatedAt($updatedAt)
    {
        return $this->setData(self::UPDATED_AT, $updatedAt);
    }

    /**
     * Return unique ID(s) for each object in system
     *
     * @return string[]
     */
    public function getIdentities()
    {
        return [
            'banner_' . $this->getId(),
        ];
    }
}
