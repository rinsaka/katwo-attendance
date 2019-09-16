@extends('layouts.app')

@inject('myController', 'App\Http\Controllers\Controller')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{{ $menu->activity->act_at }} {{ $myController->get_youbi($menu->activity->act_at) }} @if (strlen($menu->activity->note)) <span class="note">&nbsp; {{ $menu->activity->note }}</span>@endif の練習メニュー</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="post" action="{{ route('menu_update') }}" enctype='multipart/form-data'>
                      {{ csrf_field() }}
                      {{ method_field('patch') }}
                      <input type="hidden" name="mid" value="{{ $menu->id }}">
                      <input type="hidden" name="url" value="{{ url()->previous()}}">

                      <p>
                        <label for="name">投稿者名: </label>
                        <input type="text" name="name" value="{{ $menu->name }}" placeholder="投稿者の名前を入れてください" class="form-control" required>
                        @if ($errors->has('name'))
                          <span class="error">{{ $errors->first('name') }}</span>
                        @endif
                      </p>

                      <p>
                        <label for="menu">練習メニュー: </label>
                        <textarea name="menu" rows="10" class="form-control" placeholder="練習メニューやお知らせ事項を入力して下さい" required>{{ $menu->menu }}</textarea>
                        @if ($errors->has('menu'))
                          <span class="error">{{ $errors->first('menu') }}</span>
                        @endif
                      </p>
                      <p>
                        投稿日時：{{ $menu->created_at }}<br>
                        最終更新：{{ $menu->updated_at }}<br>
                      </p>
                      <p>
                        <input type="submit" value="　　　練習メニューを更新　　　" class="form-control submit_button">
                      </p>
                    </form>
                    <p class="pull-right">
                      <a href="{{ action('MenusController@mail', $menu->id) }}">
                        案内メールの文面を生成する
                      </a>
                    </p>

                </div>
                <div  class="panel-footer">
                  <p>
                    <a href="{{ url()->previous() }}">戻る</a>
                    &nbsp;
                    <a href="{{ action('HomeController@index') }}">今月へ</a>
                  </p>

                  <p>&nbsp;</p>
                  {{-- フッターの表示 --}}
                  @include('layouts.footer')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
