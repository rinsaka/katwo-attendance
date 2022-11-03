@extends('layouts.admin')

@inject('myController', 'App\Http\Controllers\Controller')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">活動施設の編集（管理者モード）</div>

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
                        ここで施設名を変更すると「{{ $place->place }}」で登録されている全ての活動予定の施設名が更新されます．
                      </p>
                    <form method="post" action="{{ route('admin_place_update') }}" enctype='multipart/form-data'>
                        {{ csrf_field() }}
                        {{ method_field('patch') }}
                        <input type="hidden" name="pid" value="{{ $place->id }}">

                        <p>
                          <label for="place">活動施設名: </label>
                          <input type="text" name="place" required value=
                          @if ($errors->any())
                            "{{ old("place") }}"
                          @else
                            "{{ $place->place }}"
                          @endif
                          class="form-control" placeholder="活動施設名を入力してください．（100文字以内）">
                          @if ($errors->has('place'))
                            <span class="error">{{ $errors->first('place') }}</span>
                          @endif
                        </p>

                        <p>
                          <label for="default_place">
                            <input type="checkbox" name="default_place" id="default_place" class=""
                            @if ($place->default_place)
                              checked disabled
                            @endif
                            >
                            @if ($place->default_place)
                              デフォルト活動施設に設定されています
                            @else
                              デフォルト活動施設に設定する
                            @endif
                          </label>
                        </p>
                        <p>
                          登録日時：{{ $place->created_at }}<br>
                          最終更新：{{ $place->updated_at }}
                        </p>

                        <hr>
                        <p>
                          <input type="submit" value="　　　活動施設名を変更　　　" class="form-control submit_button">
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
