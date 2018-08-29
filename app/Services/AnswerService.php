<?php

namespace App\Services;

use App\Repositories\{AnswerRepositoryInterface};

/**
 * Class AnswerService
 */
class AnswerService
{
    /** @var AnswerRepositoryInterface */
    protected $answer;

    /**
     * @param AnswerRepositoryInterface $answer
     */
    public function __construct(AnswerRepositoryInterface $answer)
    {
        $this->answer = $answer;
    }

    /**
     *
     * @return mixed
     */
    public function getAllAnswers()
    {
        return $this->answer->get();
    }

    /**
     * @param $userId
     * @param $clickerItem
     *
     * @return mixed
     */
    public function getAnswerByUserIdAndClickerItem($userId, $clickerItem)
    {
        return $this->answer->findByUserIdAndClickerItem($userId, $clickerItem);
    }

    /**
     * @param $params
     *
     * @return mixed
     */
    public function saveAnswer($params)
    {

        return $this->answer->save($params);
    }

    /**
     * @param $params
     *
     * @return mixed
     */
    public function updateAnswer($params)
    {

        return $this->answer->update($params);
    }
}
