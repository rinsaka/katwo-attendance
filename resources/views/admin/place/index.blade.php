@extends('layouts.admin')

@inject('myController', 'App\Http\Controllers\Controller')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">主な活動場所一覧（管理者モード）</div>

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
                            活動予定の登録時にリストに表示する活動施設の一覧です．このページで活動施設の名称を変更したり，新規登録・削除ができます．また，デフォルト施設に設定すると，練習登録の新規作成時に自動的に選択されるようになります．
                        </p>
                    </div>

                    <div>
                        <ol>
                            @forelse ($places as $place)
                                <li>
                                    {{ $place->place }}
                                    @if ($place->default_place == 1)
                                        【<span class="default">デフォルト施設</span>】
                                    @endif
                                </li>
                            @empty
                            @endforelse
                        </ol>
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
