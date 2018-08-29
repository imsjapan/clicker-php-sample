<?php

namespace App\Http\Controllers;

use App\Lib\CaliperSession;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use IMSGlobal\LTI\ToolProvider\DataConnector\DataConnector;
use IMSGlobal\LTI\ToolProvider\ToolProvider;

class LaunchController extends Controller
{
    // POST /launch
    // LTI で LMS から起動する際のエンドポイント
    public function index()
    {
        // データベースのパラメータを取得
        $db_connection = Config::get('database.default');
        $db_host = Config::get('database.connections.mysqli.host');
        $db_database = Config::get('database.connections.'.$db_connection.'.database');
        $db_username = Config::get('database.connections.'.$db_connection.'.username');
        $db_password = Config::get('database.connections.'.$db_connection.'.password');
        // データベースに接続
        $db = mysqli_connect($db_host, $db_username, $db_password);
        $db =  mysqli_select_db($db ,$db_database);
        // LTI のためにデータベースコネクターオブジェクトを取得
        $dataConnector = DataConnector::getDataConnector('', $db);
        // LTI におけるパラメータを LtiLaunch オブジェクトとして取得
        $ltiLaunch = new ImsToolProvider($dataConnector);
        // チェックするパラメータをセット
        $ltiLaunch->setParameterConstraint('resource_link_id');
        $ltiLaunch->setParameterConstraint('user_id');
        $ltiLaunch->setParameterConstraint('roles');
        // LTI Launch リクエストをチェック
        $ltiLaunch->handleRequest();

        return redirect('clicker'); // クリッカーのメイン画面にリダイレクトします
    }

}

class ImsToolProvider extends ToolProvider {

    function onLaunch() {
        // 最初に残っているセッションがあれば破棄
        Session::start();
        Session::flush();   // 削除 (全データ)
        // LMS から遷移したときしかパラメータは取得できないためセッションに格納して利用
        Session::start();
        Session::put("ltiLaunch", $this);   // LtiLaunch オブジェクトをセッションに保存

        // Logging with Caliper
        $caliperSession = new CaliperSession(Config::get('caliper.endpoint'), Config::get('caliper.apikey'), Config::get('caliper.sensorid'), Config::get('caliper.clientid'), Config::get('caliper.appid'), Config::get('app.name'));
        // Get current DateTime
        $login_time = new \DateTime();

        if($caliperSession->sendSessionLoggedIn($this->user->getId(), Session::getId(), $login_time)) {
            // イベント送信成功メッセージをセッションに保存
            Session::put("message", 'SessionEvent(Logged In) was sent successfully.');
        } else {
            // イベント送信失敗メッセージをセッションに保存
            Session::put("message", 'Failed to send SessionEvent(Logged In).');
        }

        Session::put("login_time", $login_time);    // ログイン時間をセッションに保存
    }

    function onError() {
//        return false;
    }

}