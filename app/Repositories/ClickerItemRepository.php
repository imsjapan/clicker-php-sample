<?php

namespace App\Repositories;

use App\ClickerItems;

/**
 * Class ClickerItemRepositoryInterface
 */
class ClickerItemRepository implements ClickerItemRepositoryInterface
{
    /** @var ClickerItems */
    protected $eloquent;

    /**
     * @param $eloquent
     */
    public function __construct(ClickerItems $eloquent)
    {
        $this->eloquent = $eloquent;
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function get()
    {
        $result = $this->eloquent->get();
        return $result;
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function findById($id)
    {
        $result = $this->eloquent->where('id',$id)->get();
        return $result;
    }

    /**
     * @param $resourceLinkId
     *
     * @return mixed
     */
    public function findByResourceLinkId($resourceLinkId)
    {
        $result = $this->eloquent->where('resource_link_id',$resourceLinkId)->get();
        return $result;
    }

    /**
     * @param $resourceLinkId, $status
     *
     * @return mixed
     */
    public function findByResourceLinkIdAndStatus($resourceLinkId, $status)
    {
        $result = $this->eloquent->where('resource_link_id',$resourceLinkId)->where('status',$status)->orderBy('updated_at', 'desc')->get()->first();
        return $result;
    }

    /**
     * @param array $params
     *
     * @return mixed
     */
    public function save($params)
    {
        $result = $this->eloquent->fill($params)->save();
        $clicker_item = $this->eloquent->orderBy('updated_at', 'desc')->get()->first();
        $clicker_item->clicker_options()->create([
            'title' => $params['clickerOptions1_title']
        ]);
        $clicker_item->clicker_options()->create([
            'title' => $params['clickerOptions2_title']
        ]);
        return $result;
    }

    /**
     * @param $status
     *
     * @return mixed
     */
    public function updateStatus($clicker_items_id, $status)
    {
        $result = $this->eloquent->where('id', '=', $clicker_items_id )->update([
            'status' => $status
        ]);
        return $result;
    }
}
