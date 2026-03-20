@extends('layouts.app-2026')

@inject('myController', 'App\Http\Controllers\Controller')

@section('content')

<main class="container-md">
@include('layouts.flash')


<div class="card my-3 border-0 shadow-lg">
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
</main>
@endsection
