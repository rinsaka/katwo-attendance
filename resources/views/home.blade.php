@extends('layouts.app')

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
                            <span class="next_prev link_left">
                              <a href="{{ action('HomeController@show', [$prev_year, $prev_month]) }}">
                                <i class="fas fa-angle-double-left fa-2x my-white"></i> &nbsp;
                                {{ $prev_month }}月
                              </a>
                            </span>
                          </td>
                          <td align="center">
                            <span class="next_prev link_center">
                              <a href="{{ action('HomeController@index') }}">
                                <i class="fas fa-home fa-2x my-white"></i> &nbsp;
                                今月
                              </a>
                            </span>
                          </td>
                          <td width="30%" align="center">
                            <span class="next_prev link_right">
                              <a href="{{ action('HomeController@show', [$next_year, $next_month]) }}">
                                <i class="fas fa-angle-double-right fa-2x my-white"></i> &nbsp;
                                {{ $next_month }}月
                              </a>
                            </span>
                          </td>
                        </tr>
                      </table>
                    </div>

                    <div class="create_link">
                      <p>
                        <a href="{{ action('HomeController@create', [$this_year, $this_month]) }}">
                          <i class="fas fa-plus-circle fa-2x"></i>
                          {{ $this_year }}年{{ $this_month }}月の<br>自分の予定を登録
                        </a>
                      </p>
                    </div>

                    <div>
                      @forelse ($activities as $activity)
                        <h3>{{ $activity->act_at }}</h3>
                          <p>
                            {{ $activity->time->jikan }}
                            {{ $activity->place->place }}
                          </p>
                          @foreach ($activity->attendances as $attendance)
                            <p>
                              <a href="{{ action('HomeController@edit', [$this_year, $this_month, $attendance->id]) }}">
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
                              </a>
                            </p>
                          @endforeach
                      @empty
                      <p>活動予定がまだ登録されていません!</p>
                      @endforelse
                    </div>


                    <div class="create_link">
                      <p>
                        <a href="{{ action('HomeController@create', [$this_year, $this_month]) }}">
                          <i class="fas fa-plus-circle fa-2x"></i>
                          {{ $this_year }}年{{ $this_month }}月の<br>自分の予定を登録
                        </a>
                      </p>
                    </div>

                    <div class="link_container">
                      <table border="0" width="100%" cellspacing="0" cellpadding="5" bordercolor="#333333">
                        <tr>
                          <td width="30%" align="center">
                            <span class="next_prev link_left">
                              <a href="{{ action('HomeController@show', [$prev_year, $prev_month]) }}">
                                <i class="fas fa-angle-double-left fa-2x my-white"></i> &nbsp;
                                {{ $prev_month }}月
                              </a>
                            </span>
                          </td>
                          <td align="center">
                            <span class="next_prev link_center">
                              <a href="{{ action('HomeController@index') }}">
                                <i class="fas fa-home fa-2x my-white"></i> &nbsp;
                                今月
                              </a>
                            </span>
                          </td>
                          <td width="30%" align="center">
                            <span class="next_prev link_right">
                              <a href="{{ action('HomeController@show', [$next_year, $next_month]) }}">
                                <i class="fas fa-angle-double-right fa-2x my-white"></i> &nbsp;
                                {{ $next_month }}月
                              </a>
                            </span>
                          </td>
                        </tr>
                      </table>
                    </div>

                </div>
                <div  class="panel-footer">
                  &nbsp;
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
