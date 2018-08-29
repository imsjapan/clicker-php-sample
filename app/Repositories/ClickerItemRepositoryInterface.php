<?php

namespace App\Repositories;

/**
 * Interface ClickerItemRepositoryInterface
 */
interface ClickerItemRepositoryInterface
{
    /**
     * @param $id
     *
     * @return mixed
     */
    public function get();

    /**
     * @param $id
     *
     * @return mixed
     */
    public function findById($id);

    /**
     * @param $id
     *
     * @return mixed
     */
    public function findByResourceLinkId($resourceLinkId);

    /**
     * @param $id
     *
     * @return mixed
     */
    public function findByResourceLinkIdAndStatus($resourceLinkId, $status);

    /**
     * @param array $params
     *
     * @return mixed
     */
    public function save($clickerItem);

    /**
     * @param $status
     *
     * @return mixed
     */
    public function updateStatus($clicker_items_id, $status);
}
