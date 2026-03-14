@extends('layouts.admin-2026')

@inject('myController', 'App\Http\Controllers\Controller')

@section('content')

<main>
@include('layouts.flash')

<div class="card my-3 border-0 shadow-lg">
  <div class="card-header h5 mb-0">
    主な活動時間一覧（管理者モード）
  </div>
  <div class="card-body">
    <div class="mb-4">
        活動予定の登録時にリストに表示する活動時間の一覧です。
    </div>

    <ol class="list-group list-group-numbered mb-4">
      @forelse ($times as $time)
        <li
          @if ($time->default_jikan == 1)
            class="list-group-item list-group-item-primary"
          @else
            class="list-group-item"
          @endif
        >
          <a href="{{ action('Admin\HomeController@time_edit', [$time->id]) }}">
            {{ $time->jikan }}
          </a>
          @if ($time->default_jikan == 1)
            【<span class="fw-bold">デフォルト時間</span>】
          @endif
        </li>
      @empty
      @endforelse
    </ol>

    <!-- テキストリンク -->
    <p class="text-start mt-2 mb-0">
       <a href="{{ action('Admin\HomeController@time_create') }}">
        活動時間を新規に登録する
      </a>
    </p>

    <!-- テキストリンク（中央寄せ） -->
    <p class="text-center mt-2 mb-0">
       <a href="{{ action('Admin\HomeController@index') }}">
        活動予定一覧（管理者モード）に戻る
      </a>
    </p>

  </div>
</div>
</main>

@include('layouts.admin-footer')
@endsection
