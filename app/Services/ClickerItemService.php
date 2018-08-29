<?php

namespace App\Services;

use App\Repositories\{ClickerItemRepositoryInterface};

/**
 * Class ClickerItemService
 */
class ClickerItemService
{
    /** @var ClickerItemRepositoryInterface */
    protected $clickerItem;

    /**
     * @param ClickerItemRepositoryInterface $clickerItem
     */
    public function __construct(ClickerItemRepositoryInterface $clickerItem)
    {
        $this->clickerItem = $clickerItem;
    }

    /**
     *
     * @return mixed
     */
    public function getAllClickerItems()
    {
        return $this->clickerItem->get();
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function getClickerItem($id)
    {
        return $this->clickerItem->findById($id);
    }

    /**
     * @param $resourceLinkId
     *
     * @return mixed
     */
    public function getClickerItemByResourceLinkId($resourceLinkId)
    {
        $result = $this->clickerItem->findByResourceLinkId($resourceLinkId);
        return $result;
    }

    /**
     * @param $resourceLinkId, $status
     *
     * @return mixed
     */
    public function getClickerItemByResourceLinkIdAndStatus($resourceLinkId, $status)
    {
        $result = $this->clickerItem->findByResourceLinkIdAndStatus($resourceLinkId, $status);
        return $result;
    }

    /**
     * @param $params
     *
     * @return mixed
     */
    public function saveClickerItem($params)
    {
        return $this->clickerItem->save($params);
    }

    /**
     * @param $status
     *
     * @return mixed
     */
    public function updateStatus($clicker_items_id, $status)
    {
        return $this->clickerItem->updateStatus($clicker_items_id, $status);
    }
}
