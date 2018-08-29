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
  <p class="h3">クリッカー</p>
  @if($isInstructor)
    管理者
  @else
    ユーザ
  @endif

  @if($active_clicker_item != null)
  <div class="jumbotron">
    <p class="lead">{{ $active_clicker_item->body }}</p>
    <form action="/clicker/{{ $active_clicker_item->id }}/answer" method="post">
      {{ csrf_field() }}
      <div class="form-group">
        @foreach($active_clicker_item->clicker_options as $clicker_option)
        <div class="form-check">
          <input class="form-check-input" type="radio" name="clickerOptions_id"
                 id="{{ $clicker_option->id }}"
                 value="{{ $clicker_option->id }}"
                 @if($isInstructor)
                 disabled
                 @endif
                 @if(count($answers)>0)
                   @if($answers[0]->clicker_options_id == $clicker_option->id)
                   checked="true"
                   @endif
                @endif
          >
          <label class="form-check-label" for="{{ $clicker_option->id }}">{{$clicker_option->title}}</label>
          <input type="hidden" id="{{ $clicker_option->clicker_items_id }}" name="clickerItems_id" value="{{ $clicker_option->clicker_items_id }}">
        </div>
        @endforeach
      </div>
      <button class="btn btn-primary" type="submit"
              @if($isInstructor)
              disabled
              @endif
      >回答</button>
    </form>
  </div>
  @endif
  @if($active_clicker_item == null)
    <div class="jumbotron">
      <p class="lead">実施中のアンケートはありません</p>
    </div>
  @endif
  @if($isInstructor)
  <div>
    <p class="h3">管理</p>

    <div class="row">
      <div class="col">
        <a class="btn btn-primary" href="/clicker/new" role="button">新規作成</a>
      </div>
    </div>

    <table class="table">
      <thead>
      <tr>
        <th scope="col">質問項目</th>
        <th scope="col">状態</th>
        <th scope="col">操作</th>
      </tr>
      </thead>
      <tbody>
      @foreach($clicker_items as $clicker_item)
      <tr>
        <td><a href="/clicker/{{ $clicker_item->id }}">{{ $clicker_item->body }}</a></td>
        @if($clicker_item->status == 'NEW')
        <td>新規</td>
        @elseif($clicker_item->status == 'ONGOING')
        <td>実施中</td>
        @elseif($clicker_item->status == 'COMPLETED')
        <td>完了</td>
        @endif
        <td>
          @if($clicker_item->isNew())
          <form action="/clicker/{{ $clicker_item->id }}/start" method="post">
            {{ csrf_field() }}
            <button class="btn btn-danger" type="submit">開始</button>
          </form>
          @endif
          @if($clicker_item->isActive())
          <form action="/clicker/{{ $clicker_item->id }}/stop" method="post">
            {{ csrf_field() }}
            <button class="btn btn-dark" type="submit">終了</button>
          </form>
          @endif
        </td>
      </tr>
      @endforeach
      </tbody>
    </table>
  </div>
  @endif
</div>
<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
