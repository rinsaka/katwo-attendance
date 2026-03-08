@extends('layouts.app-2026')

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


<div class="card my-3 border-0 shadow-sm">
  <div class="card-header bg-primary text-white h5 mb-0">
    すべての予定（一覧表示）
  </div>
  <div class="card-body">
    <p class="mb-0 text-body-secondary">
       @foreach ($month_acts as $act)
          {{ $act }}<br>
        @endforeach
    </p>

    <!-- テキストリンク（中央寄せ） -->
      <p class="text-center mt-2 mb-0">
        <a href="{{ action('HomeController@index') }}">戻る</a>
      </p>
  </div>
</div>

@endsection
