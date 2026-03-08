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
     {{ $menu->activity->act_at }} {{ $myController->get_youbi($menu->activity->act_at) }} @if (strlen($menu->activity->note)) &nbsp; {{ $menu->activity->note }}@endif の案内メール文面
  </div>
  <div class="card-body">
    <form>
      <p class="mb-0 text-body-secondary">
        <label for="menu">メールの文面: </label>
        <textarea name="menu" rows="50" class="form-control">{{ $mail }}</textarea>
      </p>
    </form>


    <!-- テキストリンク（中央寄せ） -->
      <p class="text-center mt-2 mb-0">
        <a href="{{ action('HomeController@index') }}">戻る</a>
      </p>
  </div>
</div>

</main>
@include('layouts.footer')
@endsection
