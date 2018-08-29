<?php

namespace App\Lib;

require_once realpath(dirname(__FILE__) . '/../../vendor/imsglobal/caliper/lib/Caliper/Sensor.php');
require_once __DIR__ . '/../../vendor/imsglobal/caliper/lib/Caliper/entities/reading/EPubVolume.php';
require_once __DIR__ . '/../../vendor/imsglobal/caliper/lib/Caliper/entities/reading/EPubSubChapter.php';
require_once __DIR__ . '/../../vendor/imsglobal/caliper/lib/Caliper/entities/reading/Frame.php';
require_once __DIR__ . '/../../vendor/imsglobal/caliper/lib/Caliper/entities/agent/Person.php';
require_once __DIR__ . '/../../vendor/imsglobal/caliper/lib/Caliper/entities/agent/SoftwareApplication.php';
require_once __DIR__ . '/../../vendor/imsglobal/caliper/lib/Caliper/entities/session/Session.php';
require_once __DIR__ . '/../../vendor/imsglobal/caliper/lib/Caliper/events/SessionEvent.php';
require_once __DIR__ . '/../../vendor/imsglobal/caliper/lib/Caliper/actions/Action.php';
require_once __DIR__ . '/../../vendor/imsglobal/caliper/lib/Caliper/entities/EntityType.php';
require_once __DIR__ . '/../../vendor/imsglobal/caliper/lib/Caliper/Options.php';
require_once __DIR__ . '/../../vendor/imsglobal/caliper/lib/Caliper/Client.php';

class CaliperSession
{

    private $endpoint = ''; // 送信先URL
    private $apikey = '';  // APIキー
    private $sensorId = '';
    private $clientId = '';
    private $appId = '';
    private $appName = '';
    private $sensor = null;
    private $app = null;

    /**
     * CaliperSession constructor.
     */
    public function __construct($endpoint, $apikey, $sensorId, $clientId, $appId, $appName)
    {
        $this->endpoint = $endpoint;
        $this->apikey = $apikey;
        $this->sensorId = $sensorId;
        $this->clientId = $clientId;
        $this->appId = $appId;
        $this->appName = $appName;

        // Sensorのインスタンス作成
        $this->sensor = new \Sensor($this->sensorId);

        $options = (new \Options())
            ->setApiKey($this->apikey)
            ->setDebug(true)
            ->setHost($this->endpoint);

        // Sensorインスタンスの設定
        $this->sensor->registerClient('http', new \Client($this->clientId, $options));

        // このアプリの情報の設定
        $this->app = (new \SoftwareApplication($this->appId))
            ->setName($this->appName);
    }

    /**
     * ログインのSessionEventを送信する。
     * 送信成功時にtrue、失敗時にfalseを返す。
     *
     * @return bool
     */
    function sendSessionLoggedIn($user_id, $sessionId, $login_time)
    {

        // 操作しているユーザの情報をセット
        // id: URL + ユーザID
        // name: ユーザID
        $actor = (new \Person($this->appId.'/users/'.$user_id))
            ->setName($user_id);

        // セッションの情報をセット
        // id: URL + セッションID
        $session = (new \Session($this->appId.'/sessions/'.$sessionId))
            ->setActor($actor)
            ->setDateCreated($login_time)
            ->setDateModified($login_time)
            ->setStartedAtTime($login_time);

        // Caliper に送信するイベントオブジェクトを作成
        $event = (new \SessionEvent())
            ->setActor($actor)
            ->setAction(new \Action(\Action::LOGGED_IN))
            ->setObject($this->app)
            ->setGenerated($session)
            ->setEventTime($login_time);

        // イベント送信
        try {
            $this->sensor->send($this->sensor, $event);
            return true;
        } catch (\RuntimeException $exception) {
            return false;
        }
    }

    /**
     * ログアウトのSessionEventを送信する。
     * 送信成功時にtrue、失敗時にfalseを返す。
     *
     * @return bool
     */
    function sendSessionLoggedOut($user_id, $login_time)
    {

        // セッションの間隔を取得する
        $now = new DateTime();
        $duration = $now->diff($login_time);

        // BEGIN: 送信用イベントの構築
        // この部分でLoggedOutイベントの構築を行う。
        // ログイン時とは異なり、session に endedAtTime, duration が必要となる


        // END: 送信用イベントの構築


        // イベント送信
        try {

            $this->sensor->send($this->sensor, $event);
            return true;

        } catch (\Exception $exception) {

            echo 'Error sending event: ' . $exception->getMessage() . PHP_EOL;
            return false;

        }
    }

    /**
     * DateIntervalを秒数に換算し、文字列にして返す。
     *
     * @param DateInterval $interval
     * @return String
     */
    function getDurationString($interval)
    {

        $seconds += $interval->s;
        $seconds += $interval->i * 60;
        $seconds += $interval->h * 60 * 60;
        $seconds += $interval->d * 60 * 60 * 24;
        $seconds += $interval->m * 60 * 60 * 24 * 30;
        $seconds += $interval->y * 60 * 60 * 24 * 30 * 365;

        return (string)$seconds;
    }
}