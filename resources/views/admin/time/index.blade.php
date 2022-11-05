@extends('layouts.admin')

@inject('myController', 'App\Http\Controllers\Controller')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">主な活動施設一覧（管理者モード）</div>

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
                            活動予定の登録時にリストに表示する活動時間の一覧です．
                        </p>
                    </div>

                    <div>
                        <ol>
                            @forelse ($times as $time)
                                <li>
                                    {{ $time->jikan }}
                                    @if ($time->default_jikan == 1)
                                        【<span class="default">デフォルト時間</span>】
                                    @endif
                                </li>
                            @empty
                            @endforelse
                        </ol>
                    </div>


                </div>

                <div  class="panel-footer">
                  <p>
                    <a href="{{ action('Admin\HomeController@place_create') }}">
                      活動施設を新規に登録する
                    </a>
                  </p>
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
