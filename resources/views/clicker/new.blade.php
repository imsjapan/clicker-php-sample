<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Clicker</title>

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

  <!-- Styles -->
  <style>
    html, body {
      background-color: #fff;
      color: #636b6f;
      font-family: 'Raleway', sans-serif;
      font-weight: 100;
      height: 100vh;
      margin: 0;
    }

    .full-height {
      height: 100vh;
    }

    .flex-center {
      align-items: center;
      display: flex;
      justify-content: center;
    }

    .position-ref {
      position: relative;
    }

    .top-right {
      position: absolute;
      right: 10px;
      top: 18px;
    }

    .content {
      text-align: center;
    }

    .title {
      font-size: 84px;
    }

    .links > a {
      color: #636b6f;
      padding: 0 25px;
      font-size: 12px;
      font-weight: 600;
      letter-spacing: .1rem;
      text-decoration: none;
      text-transform: uppercase;
    }

    .m-b-md {
      margin-bottom: 30px;
    }
  </style>
  <!-- Styles -->
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div class="container">
  <div class="row">
    <div class="col">
      <a href="/clicker">&lt; 戻る</a>
    </div>
  </div>

  <p class="h3">新規作成</p>

  <form action="/clicker" method="post">
    {{ csrf_field() }}
    <div class="form-group">
      <label for="clickerItemBody">質問項目</label>
      <textarea class="form-control" id="clickerItemBody" name="clickerItems_body" rows="3"></textarea>
    </div>

    <div class="form-group">
      <label for="clickerOption1">選択肢①</label>
      <input type="text" class="form-control" id="clickerOption1" name="clickerOptions1_title">
    </div>
    <div class="form-group">
      <label for="clickerOption2">選択肢②</label>
      <input type="text" class="form-control" id="clickerOption2" name="clickerOptions2_title">
    </div>
    <button class="btn btn-primary" type="submit">作成</button>
  </form>
</div>
<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>