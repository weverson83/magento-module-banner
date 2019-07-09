<?php
namespace Weverson83\Banner\Model;

use Weverson83\Banner\Api\Data\BannerSearchResultsInterface;

class SearchResults extends \Magento\Framework\Api\SearchResults implements BannerSearchResultsInterface
{
    public function getTotalCount()
    {
        return sizeof($this->getItems());
    }
}
