@extends('layouts.app-2026')

@inject('myController', 'App\Http\Controllers\Controller')

@section('content')

<main>
@include('layouts.flash')

<div class="card my-3 border-0 shadow-lg">
  <div class="card-header bg-primary text-white h5 mb-0">
    {{ $this_year }}年{{ $this_month }}月の活動予定
  </div>
  <div class="card-body">

    <!-- 上段：前月／今月／翌月（カード幅いっぱい＋ボタン間に隙間） -->
    <div class="row g-2 mb-3">
      <div class="col-4">
        <a href="{{ action('HomeController@show', [$prev_year, $prev_month]) }}" class="btn btn-outline-secondary w-100">« {{ $prev_month }}月</a>
      </div>
      <div class="col-4">
        <a href="{{ action('HomeController@index') }}" class="btn btn-primary w-100">今月</a>
      </div>
      <div class="col-4">
        <a href="{{ action('HomeController@show', [$next_year, $next_month]) }}" class="btn btn-outline-secondary w-100">{{ $next_month }}月 »</a>
      </div>
    </div>

    <!-- 下段：自分のスケジュールを新規登録（中央寄せ・カード幅の約66%） -->
    <div class="d-grid gap-2 col-8 mx-auto">
      <a href="{{ action('HomeController@create', [$this_year, $this_month]) }}" class="btn btn-success btn-lg">
        {{ $this_year }}年{{ $this_month }}月の<br>自分の予定を登録
      </a>
    </div>
  </div>
</div>

<!-- ここから活動予定カード群 -->

@forelse ($activities as $activity)
  @if ($activity->meeting == "1")
      <div class="card text-bg-info mb-3 shadow-lg">
      <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-2">
        <div class="d-flex flex-wrap align-items-baseline gap-3">
          <h3 class="h5 mb-0">{{ $activity->act_at }} {{ $myController->get_youbi($activity->act_at) }}</h3>
          <div class="text-body-secondary">
            {{ $activity->note }}
            <span class="badge text-bg-secondary ms-0 me-2">{{ $activity->time->jikan }}</span>
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
        <p class="mb-3 menu">
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
              <span class="menu_edit">[練習メニューを編集する]</span>
            </a>
          @else
            <span class="menu_edit text-body-tertiary">
              練習メニューはまだ登録されていません
              <a href="{{ action('MenusController@create', ["aid" => $activity->id]) }}">
                [登録する]
              </a>
            </span>
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
    <div class="card mb-3 shadow-lg">
      <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-2">
        <div class="d-flex flex-wrap align-items-baseline gap-3">
          <h3 class="h5 mb-0">{{ $activity->act_at }} {{ $myController->get_youbi($activity->act_at) }}</h3>
          <div class="text-body-secondary">
            {{ $activity->note }}
            <span class="badge text-bg-secondary ms-0 me-2">{{ $activity->time->jikan }}</span>
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
        <p class="mb-3 menu">
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
              <span class="menu_edit">[練習メニューを編集する]</span>
            </a>
          @else
            <span class="menu_edit text-body-tertiary">
              練習メニューはまだ登録されていません
              <a href="{{ action('MenusController@create', ["aid" => $activity->id]) }}">
                [登録する]
              </a>
            </span>
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
                        <span class="badge rounded-pill text-bg-success mt-1">
                          <span class="d-inline d-sm-none" aria-hidden="true">○</span>
                          <span class="d-none d-sm-inline">参加</span>
                        </span>
                      @elseif ($attendance->attendance == 1)
                        <span class="badge rounded-pill text-bg-danger mt-1">
                          <span class="d-inline d-sm-none" aria-hidden="true">×</span>
                          <span class="d-none d-sm-inline">欠席</span>
                        </span>
                      @else
                        <span class="badge rounded-pill text-bg-secondary mt-1">
                          <span class="d-inline d-sm-none" aria-hidden="true">-</span>
                          <span class="d-none d-sm-inline">未定</span>
                        </span>
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

<div class="card text-bg-light text-body-tertiary mb-3 shadow-lg">
  <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-2">
    <div class="d-flex flex-wrap align-items-baseline gap-3">
      <h3 class="h5 mb-0">未登録</h3>
    </div>
  </div>

  <div class="card-body">
    活動予定はまだ登録されていません!
  </div>
</div>


@endforelse

<div class="card my-3 border-0 shadow-lg">
  <div class="card-body">

    <!-- 下段：自分のスケジュールを新規登録（中央寄せ・カード幅の約66%） -->
    <div class="d-grid gap-2 col-8 mx-auto mb-3">
      <a href="{{ action('HomeController@create', [$this_year, $this_month]) }}" class="btn btn-success btn-lg">
        {{ $this_year }}年{{ $this_month }}月の<br>自分の予定を登録
      </a>
    </div>

    <!-- 上段：前月／今月／翌月（カード幅いっぱい＋ボタン間に隙間） -->
    <div class="row g-2">
      <div class="col-4">
        <a href="{{ action('HomeController@show', [$prev_year, $prev_month]) }}" class="btn btn-outline-secondary w-100">« {{ $prev_month }}月</a>
      </div>
      <div class="col-4">
        <a href="{{ action('HomeController@index') }}" class="btn btn-primary w-100">今月</a>
      </div>
      <div class="col-4">
        <a href="{{ action('HomeController@show', [$next_year, $next_month]) }}" class="btn btn-outline-secondary w-100">{{ $next_month }}月 »</a>
      </div>
    </div>


  </div>
</div>

<div class="mb-4">
<a href="{{ action('HomeController@all_act') }}">練習予定の一覧を表示する</a>
</div>
</main>
@include('layouts.footer')
@endsection
