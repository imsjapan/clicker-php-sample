<?php

namespace App\Repositories;

use App\Answers;

/**
 * Class AnswerRepository
 */
class AnswerRepository implements AnswerRepositoryInterface
{
    /** @var Answers */
    protected $eloquent;

    /**
     * @param $eloquent
     */
    public function __construct(Answers $eloquent)
    {
        $this->eloquent = $eloquent;
    }

    /**
     *
     * @return mixed
     */
    public function get()
    {
        $result = $this->eloquent->get();
        return $result;
    }

    /**
     * @param $userId, $clickerItem
     *
     * @return mixed
     */
    public function findByUserIdAndClickerItem($userId, $clickerItem)
    {
        $result = $this->eloquent->where('user_id',$userId)->where('clicker_items_id',$clickerItem)->orderBy('updated_at', 'desc')->get();
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
        return $result;
    }
    /**
     * @param array $params
     *
     * @return mixed
     */
    public function update($params)
    {
        $result = $this->eloquent->where($params['id'])->update(['clicker_option_id' => $params['id']]);
        return $result;
    }
}
