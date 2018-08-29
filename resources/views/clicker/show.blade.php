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

  <p class="h3">詳細</p>

  <div class="jumbotron">
    @if($clicker_items[0]->status == 'NEW')
      <span class="badge badge-primary">新規</span>
    @elseif($clicker_items[0]->status == 'ONGOING')
      <span class="badge badge-danger">実施中</span>
    @elseif($clicker_items[0]->status == 'COMPLETED')
      <span class="badge badge-dark">完了</span>
    @endif
    <p class="lead">{{ $clicker_items[0]->body }}</p>
  </div>

  <table class="table">
    <thead>
    <tr>
      <th scope="col">選択肢</th>
      <th scope="col">回答数</th>
    </tr>
    </thead>
    <tbody>
    @foreach($clicker_items[0]->clicker_options as $clicker_option)
    <tr>
      <td>{{ $clicker_option->title }}</td>
      <td th:text="${clickerOption.answers.size()}">{{ $clicker_option->answers->count() }}</td>
    </tr>
    @endforeach
    </tbody>
  </table>
</div>
<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>