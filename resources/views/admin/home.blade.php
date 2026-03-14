@extends('layouts.admin-2026')

@inject('myController', 'App\Http\Controllers\Controller')

@section('content')
<main>
@include('layouts.flash')

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
          @if ($activity->new)
            <span class="badge text-bg-primary ms-2">新規</span>
          @endif
          @if ($activity->update)
            <span class="badge text-bg-warning text-dark ms-1">更新</span>
          @endif
          <a href="{{ action('Admin\HomeController@edit', [$activity->id]) }}">
            @if ($activity->meeting == 1)
              <span class="fw-bold">【一部団員に限定】</span>
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

@include('layouts.admin-footer')
@endsection
