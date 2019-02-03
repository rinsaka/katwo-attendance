@extends('layouts.app')

@inject('myController', 'App\Http\Controllers\Controller')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">削除の確認</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif


                    <form method="post" action="{{ route('destroy') }}" enctype='multipart/form-data'>
                      {{ csrf_field() }}
                      {{ method_field('delete') }}
                      <input type="hidden" name="delete_token" value="katwo">
                      <input type="hidden" name="name" value="{{ $name }}">
                      <input type="hidden" name="year" value="{{ $year }}">
                      <input type="hidden" name="month" value="{{ $month }}">
                      <input type="hidden" name="aid" value="{{ $aid }}">
                      @foreach ($attens as $atten)
                        <input type="hidden" name="attens[]" value="{{ $atten }}">
                      @endforeach
                      <p>
                        {{ $name }}&nbsp;さんの{{ $year }}年{{ $month }}月の予定（{{ count($attens) }}回）を削除してよろしいですか？ 本当に削除してよければ，下の確認用の文字列ボックスに「<b>katwo</b>」と入力してボタンをクリック（またはタップ）してください．
                      </p>

                      <p>
                        <label for="confirmation">確認用の文字列: </label>
                        <input type="text" name="confirmation" value=""
                        class="form-control" placeholder="katwo と入力してください">
                      </p>

                      <p>
                        <input type="submit" value="　　　予定を削除　　　" class="form-control submit_button">
                      </p>
                    </form>




                </div>
                <div  class="panel-footer">
                  <p>
                    <a href="{{ action('HomeController@show', [$year, $month]) }}">戻る</a>
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
