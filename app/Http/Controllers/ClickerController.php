<?php

namespace App\Http\Controllers;

use App\Services\AnswerService;
use App\Services\ClickerItemService;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use PhpParser\Node\Expr\Cast\Object_;

class ClickerController extends Controller
{
    /** @var AnswerService */
    protected $answerService;
    /** @var ClickerItemService */
    protected $clickerItemService;

    /**
     * @param AnswerService   $answerService
     * @param ClickerItemService   $clickerService
     */
    public function __construct(AnswerService $answerService, ClickerItemService $clickerItemService)
    {
        $this->answerService = $answerService;
        $this->clickerItemService = $clickerItemService;
    }

    // GET /clicker
    // クリッカーのメイン画面
    public function index()
    {
        // Get launch params
        $ltiLaunch = Session::get('ltiLaunch');  // launch params をセッションから復元
        $resourceLinkId = $ltiLaunch->resourceLink->getId();

        // Check user's role
        $isInstructor = (bool)$ltiLaunch->user->isStaff();

        // Get active item
        $active_clicker_item = $this->clickerItemService->getClickerItemByResourceLinkIdAndStatus($resourceLinkId, 'ONGOING'); // Only first item
        $answers = array();
//        die(var_dump($ltiLaunch));
//        die($active_clicker_item);
        if (!empty($active_clicker_item))
        {
            // If active items exists
            $user_id = $ltiLaunch->user->getId(); // LMS 側のユーザIDを取得
            $answers = $this->answerService->getAnswerByUserIdAndClickerItem($user_id, $active_clicker_item->id);
        }
        // Get all items
        $clicker_items = $this->clickerItemService->getAllClickerItems();
        return view('clicker/index', [
            'isInstructor' => $isInstructor, 'answers' => $answers, 'active_clicker_item' => $active_clicker_item, 'clicker_items' => $clicker_items
        ]);
    }

    // GET /clicker/new
    // 新規作成画面
    public function newClickerItem()
    {
        return view('clicker/new');
    }

    // POST /clicker/create
    // 新規作成処理
    public function create()
    {
        // Get launch params
        $ltiLaunch = Session::get('ltiLaunch');  // launch params をセッションから復元

        // Persist a clicker item
        $params = array();
        $params['body'] = Input::get('clickerItems_body');
        $params['resource_link_id'] = $ltiLaunch->resourceLink->getId();  // LTI 経由で起動したコースのリソースIDを取得
        $params['status'] = 'NEW';
        $params['clickerOptions1_title'] = Input::get('clickerOptions1_title');
        $params['clickerOptions2_title'] = Input::get('clickerOptions2_title');
        $this->clickerItemService->saveClickerItem($params);

        return redirect('clicker');
    }

    // GET /clicker/{clickerItemId}
    // 設問の個別画面
    public function show($clickerItemId)
    {
        // Get a clicker item
        $clicker_items = $this->clickerItemService->getClickerItem($clickerItemId);
        return view('clicker/show', ['clicker_items' => $clicker_items]);

    }

    // POST /clicker/{clickerItemId}/answer
    // 回答処理
    public function answer($clicker_items_id)
    {
        // Get launch params
        $ltiLaunch = Session::get('ltiLaunch'); // launch params をセッションから復元
        $user_id = $ltiLaunch->user->getId(); // LMS 側のユーザIDを取得

        // Get a clicker item
        $params['user_id'] = $user_id;
        $params['clicker_items_id'] = $clicker_items_id;
        $params['clicker_options_id'] = Input::get('clickerOptions_id');
        $this->answerService->saveAnswer($params);
        return redirect('clicker');
    }

    // POST /clicker/{clickerItemId}/start
    // 開始処理
    public function start($clickerItemId)
    {
        // Set status ONGOING (enabled)
        $this->clickerItemService->updateStatus($clickerItemId, 'ONGOING');
        return redirect('clicker');
    }

    // POST /clicker/{clickerItemId}/stop
    // 終了処理
    public function stop($clickerItemId)
    {
        // Set status COMPLETED (disabled)
        $this->clickerItemService->updateStatus($clickerItemId, 'COMPLETED');
        return redirect('clicker');
    }

}
