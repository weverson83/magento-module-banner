<?php
namespace Weverson83\Banner\Model\Cache\Tag;

use Weverson83\Banner\Model\Banner;

class Strategy implements \Magento\Framework\App\Cache\Tag\StrategyInterface
{
    /**
     * Return invalidation tags for specified object
     *
     * @param Banner $object
     * @return array
     */
    public function getTags($object)
    {
        if (!$object->getOrigData('enabled') && $object->isEnabled()) {
            return ['banner_no_banner'];
        }

        return $object->getIdentities();
    }
}
