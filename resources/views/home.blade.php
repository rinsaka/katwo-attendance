@extends('layouts.app-2026')

@inject('myController', 'App\Http\Controllers\Controller')

@section('content')
<main>
@forelse ($activities as $activity)
  @if ($activity->meeting == "1")
      <div class="card text-bg-info mb-3 shadow-sm">
      <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-2">
        <div class="d-flex flex-wrap align-items-baseline gap-3">
          <h3 class="h5 mb-0">{{ $activity->act_at }} {{ $myController->get_youbi($activity->act_at) }}</h3>
          <div class="text-body-secondary">
            {{ $activity->note }}
            {{ $activity->time->jikan }} /
            {{ $activity->place->place }}
          </div>
        </div>
        <div class="d-flex gap-2">
          <span class="badge text-bg-success">参加 {{ $activity->n_atten[3] }}</span>
          <span class="badge text-bg-danger">欠席 {{ $activity->n_atten[1] }}</span>
          <span class="badge text-bg-secondary">未定 {{ $activity->n_atten[0] }}</span>
          <span class="badge text-bg-info">対象外 {{ $activity->n_not_members }}</span>
        </div>
      </div>

      <div class="card-body">
        <p class="mb-3">
          <span class="meeting_type">【一部団員に限定した活動です】<br></span>
          @if ($activity->menu)
            @if ($activity->menu->new)
              <span class="badge text-bg-primary ms-2">新規</span>
            @endif
            @if ($activity->menu->update)
              <span class="badge text-bg-warning text-dark ms-1">更新</span>
            @endif
            @foreach ($activity->menus as $menu)
              {{ $menu }} <br>
            @endforeach
            <a href="{{ action('MenusController@show', $activity->menu->id) }}">
              [練習メニューを編集する]
            </a>
          @else
            練習メニュー未登録
            <a href="{{ action('MenusController@create', ["aid" => $activity->id]) }}">
              [練習メニューを登録する]
            </a>
          @endif
        </p>
        <div class="d-flex flex-wrap gap-2 mb-3">

          <button class="btn btn-outline-primary"
                  type="button"
                  onclick="document.getElementById('atten{{ $activity->id }}').classList.toggle('d-none')">
            出欠一覧の表示／非表示
          </button>
        </div>
        <div id="atten{{ $activity->id }}" class="d-none mt-2">
          <div class="border rounded p-2 bg-body">
            @foreach ($activity->attens as $key => $atten)
              <!-- 出席形態 -->
              <div class="mb-3">
                <div class="d-flex justify-content-between align-items-center mb-2">
                  <h4 class="h6 mb-0">
                    @if ($key == "0")
                      <span class="badge text-bg-success">参加 {{ $activity->n_atten[3] }}</span>
                    @elseif ($key == "1")
                      <span class="badge text-bg-danger">欠席 {{ $activity->n_atten[1] }}</span>
                    @elseif ($key == "2")
                      <span class="badge text-bg-secondary">未定 {{ $activity->n_atten[0] }}</span>
                    @else
                      <span class="badge text-bg-info">対象外 {{ $activity->n_not_members }}</span>
                    @endif
                  </h4>
                </div>

                <ul class="list-group ">
                  @foreach ($atten as $attendance)
                    <!-- 行：ニックネーム/パート/新規更新/メモ -->
                    <a href="{{ action('HomeController@edit', [$this_year, $this_month, $attendance->id]) }}" class="list-group-item list-group-item-action d-flex align-items-start gap-3 py-2">
                      <!-- ニックネーム・パート -->
                      <div class="flex-grow-1">
                        <span class="fw-semibold">
                            {{ $attendance->name }}
                        </span>
                        <span>({{ $attendance->part->s_part }})&nbsp;</span>
                        <!-- 新規更新バッジ -->
                        @if ($attendance->new)
                          <span class="badge rounded-pill text-bg-primary align-text-top me-2">
                            <span class="d-inline d-sm-none" aria-hidden="true">🆕</span>
                            <span class="d-none d-sm-inline">新規</span>
                          </span>
                        @endif
                        @if ($attendance->update)
                          <span class="badge rounded-pill text-bg-warning text-dark align-text-top me-2">
                            <span class="d-inline d-sm-none" aria-hidden="true">✎</span>
                            <span class="d-none d-sm-inline">更新</span>
                          </span>
                        @endif
                        <!-- コメント -->
                        <span class="text-body-secondary comment" >
                          <span class="d-inline d-md-none">
                            {{ $attendance->comment_trim }}
                          </span>
                          <span class="d-none d-md-inline">
                            {{ $attendance->comment }}
                          </span>
                        </span>
                      </div>
                    </a>
                  @endforeach
                </ul>
              </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  @else
    <div class="card mb-3 shadow-sm">
      <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-2">
        <div class="d-flex flex-wrap align-items-baseline gap-3">
          <h3 class="h5 mb-0">{{ $activity->act_at }} {{ $myController->get_youbi($activity->act_at) }}</h3>
          <div class="text-body-secondary">
            {{ $activity->note }}
            {{ $activity->time->jikan }} /
            {{ $activity->place->place }}
          </div>
        </div>
        <div class="d-flex gap-2">
          <span class="badge text-bg-success">参加 {{ $activity->n_atten[3] }}</span>
          <span class="badge text-bg-danger">欠席 {{ $activity->n_atten[1] }}</span>
          <span class="badge text-bg-secondary">未定 {{ $activity->n_atten[0] }}</span>
        </div>
      </div>

      <div class="card-body">
        <p class="mb-3">
          @if ($activity->menu)
            @if ($activity->menu->new)
              <span class="badge text-bg-primary ms-2">新規</span>
            @endif
            @if ($activity->menu->update)
              <span class="badge text-bg-warning text-dark ms-1">更新</span>
            @endif
            @foreach ($activity->menus as $menu)
              {{ $menu }} <br>
            @endforeach
            <a href="{{ action('MenusController@show', $activity->menu->id) }}">
              [練習メニューを編集する]
            </a>
          @else
            練習メニュー未登録
            <a href="{{ action('MenusController@create', ["aid" => $activity->id]) }}">
              [練習メニューを登録する]
            </a>
          @endif
        </p>
        <div class="d-flex flex-wrap gap-2 mb-3">

          <button class="btn btn-outline-primary"
                  type="button"
                  onclick="document.getElementById('atten{{ $activity->id }}').classList.toggle('d-none')">
            出欠一覧の表示／非表示
          </button>
        </div>
        <div id="atten{{ $activity->id }}" class="d-none mt-2">
          <div class="border rounded p-2 bg-body">
            @foreach ($activity->parts as $part)
              <!-- パート -->
              <div class="mb-3">
                <div class="d-flex justify-content-between align-items-center mb-2">
                  <h4 class="h6 mb-0">{{ $part->part }}</h4>
                  <div class="d-flex gap-2">
                    <span class="badge rounded-pill text-bg-success">参加 {{ $part->n_atten[3] }}</span>
                    <span class="badge rounded-pill text-bg-danger">欠席 {{ $part->n_atten[1] }}</span>
                    <span class="badge rounded-pill text-bg-secondary">未定 {{ $part->n_atten[0] }}</span>
                  </div>
                </div>

                <ul class="list-group ">
                  @foreach ($part->attendances as $attendance)
                    <!-- 行：左にステータス、中央にニックネーム/新規更新/メモ -->
                    <a href="{{ action('HomeController@edit', [$this_year, $this_month, $attendance->id]) }}" class="list-group-item list-group-item-action d-flex align-items-start gap-3 py-2">
                      <!-- ステータス（ニックネームの直前） -->
                      @if ($attendance->attendance == 3)
                        <span class="badge rounded-pill text-bg-success flex-shrink-0 mt-1">参加</span>
                      @elseif ($attendance->attendance == 1)
                        <span class="badge rounded-pill text-bg-danger flex-shrink-0 mt-1">欠席</span>
                      @else
                        <span class="badge rounded-pill text-bg-secondary flex-shrink-0 mt-1">未定</span>
                      @endif
                      <!-- ニックネーム -->
                      <div class="flex-grow-1">
                        <span class="fw-semibold me-2">
                            {{ $attendance->name }}
                        </span>
                        <!-- 新規更新バッジ -->
                        @if ($attendance->new)
                          <span class="badge rounded-pill text-bg-primary aign-text-top me-2">
                            <span class="d-inline d-sm-none" aria-hidden="true">🆕</span>
                            <span class="d-none d-sm-inline">新規</span>
                          </span>
                        @endif
                        @if ($attendance->update)
                          <span class="badge rounded-pill text-bg-warning text-dark align-text-top me-2">
                            <span class="d-inline d-sm-none" aria-hidden="true">✎</span>
                            <span class="d-none d-sm-inline">更新</span>
                          </span>
                        @endif
                        <!-- コメント -->
                        <span class="text-body-secondary comment" >
                          <span class="d-inline d-md-none">
                            {{ $attendance->comment_trim }}
                          </span>
                          <span class="d-none d-md-inline">
                            {{ $attendance->comment }}
                          </span>
                        </span>
                      </div>
                    </a>
                  @endforeach
                </ul>
              </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  @endif
@empty
<p>活動予定がまだ登録されていません!</p>
@endforelse
</main>

@endsection
