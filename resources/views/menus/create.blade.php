@extends('layouts.app')

@inject('myController', 'App\Http\Controllers\Controller')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{{ $activity->act_at }} {{ $myController->get_youbi($activity->act_at) }} @if (strlen($activity->note)) <span class="note">&nbsp; {{ $activity->note }}</span>@endif の練習メニュー</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="post" action="{{ route('menu_store') }}" enctype='multipart/form-data'>
                      {{ csrf_field() }}
                      <input type="hidden" name="aid" value="{{ $activity->id }}">
                      <input type="hidden" name="url" value="{{ url()->previous()}}">

                      <p>
                        <label for="name">投稿者名: </label>
                        <input type="text" name="name" value="" placeholder="投稿者の名前を入れてください" class="form-control" required>
                        @if ($errors->has('name'))
                          <span class="error">{{ $errors->first('name') }}</span>
                        @endif
                      </p>

                      <p>
                        <label for="menu">練習メニュー: </label>
                        <textarea name="menu" rows="10" class="form-control" placeholder="練習メニューやお知らせ事項を入力して下さい" required></textarea>
                        @if ($errors->has('menu'))
                          <span class="error">{{ $errors->first('menu') }}</span>
                        @endif
                      </p>

                      <p>
                        <input type="submit" value="　　　練習メニューを登録　　　" class="form-control submit_button">
                      </p>
                    </form>

                </div>
                <div  class="panel-footer">
                  <p>
                    <a href="{{ url()->previous() }}">戻る</a>
                  </p>

                  <p>&nbsp;</p>
                  <p>
                    This system is developed with <a href="https://laravel.com/">Laravel</a>, <a href="https://aws.amazon.com/jp/">AWS</a> and <a href="https://github.com/rinsaka/katwo-attendance">GitHub</a>.
                  </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
