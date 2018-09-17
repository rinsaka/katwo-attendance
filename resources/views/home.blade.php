@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div>
                      <span class="center">
                        <p>
                          <a href="{{ action('HomeController@create', [$this_year, $this_month]) }}">
                            {{ $this_year }}年{{ $this_month }}月の自分の予定を登録
                          </a>
                        </p>
                      </span>
                    </div>

                    <div>
                      @forelse ($activities as $activity)
                        <h3>{{ $activity->act_at }}</h3>
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
                      <p>No Activity Yet!</p>
                      @endforelse
                    </div>


                    <div>
                      <span class="center">
                        <p>
                          <a href="{{ action('HomeController@create', [$this_year, $this_month]) }}">
                            {{ $this_year }}年{{ $this_month }}月の自分の予定を登録
                          </a>
                        </p>
                      </span>
                    </div>
                </div>
                <div  class="panel-footer">
                  <span class="pull-left">
                    <p>
                      <a href="{{ action('HomeController@show', [$prev_year, $prev_month]) }}">
                        {{ $prev_year }}年{{ $prev_month }}月
                      </a>
                    </p>
                  </span>
                  <span class="pull-right">
                    <p>
                      <a href="{{ action('HomeController@show', [$next_year, $next_month]) }}">
                        {{ $next_year }}年{{ $next_month }}月
                      </a>
                    </p>
                  </span>
                  <span class="center">
                    <p>
                      <a href="{{ action('HomeController@index') }}">
                        今月
                      </a>
                    </p>
                  </span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
