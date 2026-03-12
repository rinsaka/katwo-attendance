@extends('layouts.admin-2026')

@inject('myController', 'App\Http\Controllers\Controller')

@section('content')

<main>
{{-- =========================
    Flash messages
========================= --}}
@foreach (['success' => 'success', 'error' => 'danger'] as $key => $bs)
  @if (session($key))
    <div class="alert alert-{{ $bs }} alert-dismissible fade show my-3" role="alert">
      {{ session($key) }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="閉じる"></button>
    </div>
  @endif
@endforeach

<div class="card my-3 border-0 shadow-lg">
  <div class="card-header h5 mb-0">
    主な活動施設一覧（管理者モード）
  </div>
  <div class="card-body">
    <div class="mb-4">
      活動予定の登録時にリストに表示する活動施設の一覧です．このページで活動施設の名称を変更したり，新規登録・削除ができます．また，デフォルト施設に設定すると，練習登録の新規作成時にその施設が自動的に選択されるようになります．
    </div>

    <ol class="list-group list-group-numbered mb-4">
      @forelse ($places as $place)
      <li
        @if (($place->default_place == 1))
          class="list-group-item list-group-item-primary"
        @else
          class="list-group-item"
        @endif
      >
        <a href="{{ action('Admin\HomeController@place_edit', [$place->id]) }}">
          {{ $place->place }}
        </a>
        @if ($place->default_place == 1)
        【<span class="fw-bold">デフォルト施設</span>】
        @endif
      </li>
      @empty
      @endforelse
    </ol>

    <!-- テキストリンク（中央寄せ） -->
    <p class="text-center mt-2 mb-0">
       <a href="{{ action('Admin\HomeController@place_create') }}">
        活動施設を新規に登録する
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
