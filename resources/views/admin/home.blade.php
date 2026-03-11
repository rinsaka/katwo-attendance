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
  <div class="card-header bg-primary text-white h5 mb-0">
    活動予定一覧（管理者モード）
  </div>
  <div class="card-body">

    <ul class="list-group">
      @forelse ($activities as $activity)
        <li
          @if ($activity->meeting == 1)
            class="list-group-item list-group-item-info"
          @else
            class="list-group-item"
          @endif
        >
          <a href="{{ action('Admin\HomeController@edit', [$activity->id]) }}">
            @if ($activity->meeting == 1)
              【一部団員に限定】
            @endif
            {{ $activity->act_at }} {{ $myController->get_youbi($activity->act_at) }} &nbsp; {{ $activity->time->jikan }} &nbsp; {{ $activity->place->place }}
                            @if (strlen($activity->note)) <span>&nbsp; {{ $activity->note }}</span>@endif
          </a>
        </li>
      @empty
        <li class="list-group-item list-group-item-warning">活動予定がまだ登録されていません</li>
      @endforelse
    </ul>

  </div>
</div>
</main>
<footer class="text-bg-info p-3">

  <div class="">
    <a href="{{ action('Admin\HomeController@create') }}">
      活動予定を新規登録
    </a>
  </div>

  <div class="text-end">
    <a href="{{ action('Admin\MailinfosController@edit') }}">
      メールフッタを編集
    </a>
  </div>

  <div class="text-end">
    <a href="{{ action('Admin\HomeController@place') }}">
      活動施設の一覧表示
    </a>
  </div>

  <div class="text-end">
    <a href="{{ action('Admin\HomeController@time') }}">
      活動時間の一覧表示
    </a>
  </div>

  <div class="">
    This system is developed with <a href="https://laravel.com/" target="_blank">Laravel</a>, <a href="https://lolipop.jp/" target="_blank">LOLIPOP!</a> and <a href="https://github.com/rinsaka/katwo-attendance" target="_blank">GitHub</a>.
  </div>

  <div class="">
    <a href="https://rinsaka.com/rinsaka/">
      rinsaka.com
    </a>
  </div>

</footer>
@endsection
