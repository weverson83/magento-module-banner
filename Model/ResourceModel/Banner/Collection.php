<?php
namespace Weverson83\Banner\Model\ResourceModel\Banner;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected function _construct()
    {
        $this->_init(\Weverson83\Banner\Model\Banner::class, \Weverson83\Banner\Model\ResourceModel\Banner::class);
    }
}
