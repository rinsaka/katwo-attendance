@extends('layouts.app-jquery')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{{ $this_year }}年{{ $this_month }}月の予定</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="link_container">
                      <table border="0" width="100%" cellspacing="0" cellpadding="5" bordercolor="#333333">
                        <tr>
                          <td width="30%" align="center">
                            <span class="next_prev link_left" ontouchstart="">
                              <a href="{{ action('HomeController@show', [$prev_year, $prev_month]) }}">
                                <i class="fas fa-angle-double-left fa-2x my-white"></i> &nbsp;
                                {{ $prev_month }}月
                              </a>
                            </span>
                          </td>
                          <td align="center">
                            <span class="next_prev link_center" ontouchstart="">
                              <a href="{{ action('HomeController@index') }}">
                                <i class="fas fa-home fa-2x my-white"></i> &nbsp;
                                今月
                              </a>
                            </span>
                          </td>
                          <td width="30%" align="center">
                            <span class="next_prev link_right" ontouchstart="">
                              <a href="{{ action('HomeController@show', [$next_year, $next_month]) }}">
                                <i class="fas fa-angle-double-right fa-2x my-white"></i> &nbsp;
                                {{ $next_month }}月
                              </a>
                            </span>
                          </td>
                        </tr>
                      </table>
                    </div>

                    @if (count($activities) > 0)
                      <div class="create_link" ontouchstart="">
                        <p>
                          <a href="{{ action('HomeController@create', [$this_year, $this_month]) }}">
                            <i class="fas fa-plus-circle fa-2x"></i>
                            {{ $this_year }}年{{ $this_month }}月の<br>自分の予定を登録
                          </a>
                        </p>
                      </div>
                    @endif

                    <div>
                      @forelse ($activities as $activity)
                        <h3 class="act_at">{{ $activity->act_at }}</h3>
                          <div class="detail">
                            <p class="time_place">
                              {{ $activity->time->jikan }}
                              {{ $activity->place->place }}
                            </p>
                            <p class="results">
                              参加： <span class="n_attendance">{{ $activity->n_atten3 }}</span>/{{ $activity->n_atten }}, &nbsp;
                              △： <span class="n_attendance">{{ $activity->n_atten2 }}</span>/{{ $activity->n_atten }}, &nbsp;
                              欠席： <span class="n_attendance">{{ $activity->n_atten1 }}</span>/{{ $activity->n_atten }}, &nbsp;
                              未定： <span class="n_attendance">{{ $activity->n_atten0 }}</span>/{{ $activity->n_atten }} &nbsp;
                            </p>
                            <p class="attendance vertical" ontouchstart="">
                              <span class="expansion_link">回答者リストの表示／非表示を切り替える</span><br>
                            @foreach ($activity->attendances as $attendance)
                              <a href="{{ action('HomeController@edit', [$this_year, $this_month, $attendance->id]) }}" ontouchstart="">
                                {{ $attendance->part->part }}  {{ $attendance->name }}
                                @if ($attendance->attendance == 3)
                                  ○
                                @elseif ($attendance->attendance == 2)
                                  △
                                @elseif ($attendance->attendance == 1)
                                  ×
                                @else
                                  -
                                @endif
                              </a><br>
                            @endforeach
                            </p>
                        </div>
                      @empty
                      <p>活動予定がまだ登録されていません!</p>
                      @endforelse
                    </div>


                    @if (count($activities) > 0)
                      <div class="create_link" ontouchstart="">
                        <p>
                          <a href="{{ action('HomeController@create', [$this_year, $this_month]) }}">
                            <i class="fas fa-plus-circle fa-2x"></i>
                            {{ $this_year }}年{{ $this_month }}月の<br>自分の予定を登録
                          </a>
                        </p>
                      </div>
                    @endif

                    @if (count($activities) > 0)
                    <div class="link_container">
                      <table border="0" width="100%" cellspacing="0" cellpadding="5" bordercolor="#333333">
                        <tr>
                          <td width="30%" align="center">
                            <span class="next_prev link_left" ontouchstart="">
                              <a href="{{ action('HomeController@show', [$prev_year, $prev_month]) }}">
                                <i class="fas fa-angle-double-left fa-2x my-white"></i> &nbsp;
                                {{ $prev_month }}月
                              </a>
                            </span>
                          </td>
                          <td align="center">
                            <span class="next_prev link_center" ontouchstart="">
                              <a href="{{ action('HomeController@index') }}">
                                <i class="fas fa-home fa-2x my-white"></i> &nbsp;
                                今月
                              </a>
                            </span>
                          </td>
                          <td width="30%" align="center">
                            <span class="next_prev link_right" ontouchstart="">
                              <a href="{{ action('HomeController@show', [$next_year, $next_month]) }}">
                                <i class="fas fa-angle-double-right fa-2x my-white"></i> &nbsp;
                                {{ $next_month }}月
                              </a>
                            </span>
                          </td>
                        </tr>
                      </table>
                    </div>
                    @endif

                </div>
                <div  class="panel-footer">
                  &nbsp;
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
