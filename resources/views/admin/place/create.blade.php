@extends('layouts.admin')

@inject('myController', 'App\Http\Controllers\Controller')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">活動施設の新規登録（管理者モード）</div>

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

                    <form method="post" action="{{ route('admin_place_store') }}" enctype='multipart/form-data'>
                        {{ csrf_field() }}

                        <p>
                          <label for="place">活動施設名: </label>
                          <input type="text" name="place" required value=
                          @if ($errors->any())
                            "{{ old("place") }}"
                          @else
                            ""
                          @endif
                          class="form-control" placeholder="活動施設名を入力してください．（100文字以内）">
                          @if ($errors->has('place'))
                            <span class="error">{{ $errors->first('place') }}</span>
                          @endif
                        </p>

                        <p>
                          <label for="default_place">
                            <input type="checkbox" name="default_place" id="default_place" class="">
                            デフォルト活動施設に設定する
                          </label>
                        </p>


                        <hr>
                        <p>
                          <input type="submit" value="　　　活動施設を登録　　　" class="form-control submit_button">
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
