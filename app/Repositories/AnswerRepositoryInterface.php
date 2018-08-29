<?php

namespace App\Repositories;

/**
 * Interface AnswerRepositoryInterface
 */
interface AnswerRepositoryInterface
{
    /**
     *
     * @return mixed
     */
    public function get();

    /**
     * @param $userId
     * @param $clickerItem
     *
     * @return mixed
     */
    public function findByUserIdAndClickerItem($userId, $clickerItem);

    /**
     * @param array $params
     *
     * @return mixed
     */
    public function save($params);

    /**
     * @param array $params
     *
     * @return mixed
     */
    public function update($params);
}
