## 共通

1. 任意の場所にリポジトリをクローンします

    ~~~
    $ cd path/to/imsjapan
    $ git clone https://github.com/IMSJapan/clicker-php-sample.git
    $ cd ../imsglobal
    $ git clone https://github.com/IMSGlobal/caliper-php.git
    ~~~

## mysqli データコネクタの追加

    $ move DataConnector_mysqli.php.addme vendor/imsglobal/lti/src/ToolProvider/DataConnector/

## LTI修正ファイルで上書き

    $ mv OAuthSignatureMethod.php.moveme vendor/imsglobal/lti/src/OAuth/OAuthSignatureMethod.php

## PhpStorm を用いた環境構築

### 環境

 * [PhpStorm](https://www.jetbrains.com/phpstorm/ "体験版(30日)のダウンロードはこちら")

### 手順

1. PhpStorm を起動し、プロジェクトをオープンします
    * Welcome で "Open" を選択し、clicker をクローンしたディレクトリを選択
1. ウィンドウの左側にある "1:Project" をクリックしてプロジェクトツリーを表示
1. [Tool] - [Composer] - [Install] で vendor ライブラリ群を取得
1. もし，Coposer Setting が表示された場合は，PHP interpreter を設定 (例 /usr/bin/php)
1. .env.example を .env にリネームして，DB接続などをローカル用に変更
1. ウィンドウ下部にある "Terminal" をクリックしてターミナルを表示
1. 下記のコマンドでアプリケーションキーの初期化
    ~~~
    $ php artisan key:generate
    ~~~
1. データベースのテーブルを初期化
    ~~~
    $ php artisan migrate
    ~~~
1. テーブルにテストデータを挿入
    ~~~
    $ php artisan db:seed
    ~~~
1. PHP組み込みサーバを起動(デフォルトのポート番号8000)
    ~~~
    $ php artisan serve
    ~~~
    ポート番号に80を指定して起動
    ~~~
    $ php artisan serve --port=80
    ~~~

## Canvas での LTI 設定

1. 講師権限でコースを開きます
1. コース内メニュー [設定] - [アプリ] - [アプリ設定の表示] とクリックします
1. "外部アプリ" の一覧において、 [+アプリ] をクリックします
1. "アプリの追加" ダイアログで LTI アプリの追加設定をおこないます
    * 設定のタイプ: XML を貼り付け
    * 名前: アプリ名
    * コンシューマ鍵: key
    * 共有シークレット: secret
    * XML設定: https://canvas.instructure.com/doc/api/file.tools_xml.html を参考に XML を作成し貼り付けます
        * <blti:launch_url>: ローンチURL
        * <blti:title>: コース内メニューに表示されるアプリ名
        * <blti:description>: アプリの説明
    例）コース内メニューに表示する場合
    ~~~
    <?xml version="1.0" encoding="UTF-8"?>
    <cartridge_basiclti_link xmlns="http://www.imsglobal.org/xsd/imslticc_v1p0"
        xmlns:blti = "http://www.imsglobal.org/xsd/imsbasiclti_v1p0"
        xmlns:lticm ="http://www.imsglobal.org/xsd/imslticm_v1p0"
        xmlns:lticp ="http://www.imsglobal.org/xsd/imslticp_v1p0"
        xmlns:xsi = "http://www.w3.org/2001/XMLSchema-instance"
        xsi:schemaLocation = "http://www.imsglobal.org/xsd/imslticc_v1p0 http://www.imsglobal.org/xsd/lti/ltiv1p0/imslticc_v1p0.xsd
        http://www.imsglobal.org/xsd/imsbasiclti_v1p0 http://www.imsglobal.org/xsd/lti/ltiv1p0/imsbasiclti_v1p0.xsd
        http://www.imsglobal.org/xsd/imslticm_v1p0 http://www.imsglobal.org/xsd/lti/ltiv1p0/imslticm_v1p0.xsd
        http://www.imsglobal.org/xsd/imslticp_v1p0 http://www.imsglobal.org/xsd/lti/ltiv1p0/imslticp_v1p0.xsd">
        <blti:launch_url>http://localhost:8000/launch</blti:launch_url>
        <blti:title>Clicker</blti:title>
        <blti:description>Provides a clicker tool</blti:description>
        <blti:extensions platform="canvas.instructure.com">
          <lticm:property name="privacy_level">public</lticm:property>
          <lticm:options name="course_navigation">
            <lticm:property name="enabled">true</lticm:property>
          </lticm:options>
        </blti:extensions>
    </cartridge_basiclti_link>
    ~~~
    * 設定できたら [提出] をクリックします
