@extends('layouts.admin')

@inject('myController', 'App\Http\Controllers\Controller')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">活動時間の編集（管理者モード）</div>

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
                      <p>
                        ここで時間を変更すると「{{ $time->jikan }}」で登録されている全ての活動予定の時間が更新されます．
                      </p>
                    <form method="post" action="{{ route('admin_time_update') }}" enctype='multipart/form-data'>
                        {{ csrf_field() }}
                        {{ method_field('patch') }}
                        <input type="hidden" name="tid" value="{{ $time->id }}">

                        <p>
                          <label for="jikan">活動時間: </label>
                          <input type="text" name="jikan" required value=
                          @if ($errors->any())
                            "{{ old('jikan') }}"
                          @else
                            "{{ $time->jikan }}"
                          @endif
                          class="form-control" placeholder="18:00 - 22:00">
                          @if ($errors->has('jikan'))
                            <span class="error">{{ $errors->first('jikan') }}</span>
                          @endif
                        </p>

                        <p>
                          <label for="default_jikan">
                            <input type="checkbox" name="default_jikan" id="default_jikan" class=""
                            @if ($time->default_jikan)
                              checked disabled
                            @endif
                            >
                            @if ($time->default_jikan)
                              デフォルト活動時間に設定されています
                            @else
                              デフォルト活動時間に設定する
                            @endif
                          </label>
                        </p>
                        <p>
                          登録日時：{{ $time->created_at }}<br>
                          最終更新：{{ $time->updated_at }}
                        </p>

                        <hr>
                        <p>
                          <input type="submit" value="　　　活動時間を変更　　　" class="form-control submit_button">
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
                  <p class='pull-right'>
                    <a href="{{ action('Admin\HomeController@time_delete', $time->id) }}">
                      活動時間情報を削除する
                    </a>
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
