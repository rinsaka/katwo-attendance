@extends('layouts.admin')

@inject('myController', 'App\Http\Controllers\Controller')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">活動時間の新規登録（管理者モード）</div>

                <div class="panel-body">
                    {{-- フラッシュメッセージの表示 --}}
                    @if (session('warning'))
                        <div class="alert alert-warning">
                            {{ session('warning') }}
                        </div>
                    @endif
                    @if (session('status'))
                        <div class="alert alert-info">
                            {{ session('status') }}
                        </div>
                    @endif


                    <div>

                    <form method="post" action="{{ route('admin_time_store') }}" enctype='multipart/form-data'>
                        {{ csrf_field() }}

                        <p>
                          <label for="jikan">活動時間: </label>
                          <input type="text" name="jikan" required value=
                          @if ($errors->any())
                            "{{ old("jikan") }}"
                          @else
                            ""
                          @endif
                          class="form-control" placeholder="18:00 - 22:00">
                          @if ($errors->has('jikan'))
                            <span class="error">{{ $errors->first('jikan') }}</span>
                          @endif
                        </p>

                        <p>
                          <label for="default_jikan">
                            <input type="checkbox" name="default_jikan" id="default_jikan" class="">
                            デフォルト活動時間に設定する
                          </label>
                        </p>


                        <hr>
                        <p>
                          <input type="submit" value="　　　活動時間を登録　　　" class="form-control submit_button">
                        </p>
                      </form>
                    </div>


                </div>

                <div  class="panel-footer">
                  <p>
                    <a href="{{ action('Admin\HomeController@index') }}">
                      活動予定一覧（管理者モード）に戻る
                    </a>
                  </p>

                  <!-- <p>&nbsp;</p> -->
                  <p>
                    This system is developed with <a href="https://laravel.com/">Laravel</a>, <a href="https://aws.amazon.com/jp/">AWS</a> and <a href="https://github.com/rinsaka/katwo-attendance">GitHub</a>.
                  </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
