@extends('layouts.admin')

@inject('myController', 'App\Http\Controllers\Controller')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">活動施設の削除（管理者モード）</div>

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
                        次の情報を削除しますか？この操作は元に戻せません．
                      </p>
                    <form method="post" action="{{ action('Admin\HomeController@place_destroy', $place->id) }}">
                        {{ csrf_field() }}
                        {{ method_field('delete') }}
                        <p>
                          施設名：{{ $place->place }}<br>
                          登録日時：{{ $place->created_at }}<br>
                          最終更新：{{ $place->updated_at }}<br>
                          登録済み活動回数：{{ $cnt }}
                        </p>

                        <hr>
                        <p>
                          <input type="submit" value="　　　活動施設情報を削除　　　" class="form-control submit_button">
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
