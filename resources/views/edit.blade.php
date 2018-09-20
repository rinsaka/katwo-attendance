@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{{ $name }}&nbsp;さんの{{ $year }}年{{ $month }}月の予定を変更します</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif


                    <form method="post" action="{{ route('update') }}" enctype='multipart/form-data'>
                      {{ csrf_field() }}
                      {{ method_field('patch') }}
                      <input type="hidden" name="year" value="{{ $year }}">
                      <input type="hidden" name="month" value="{{ $month }}">
                      <input type="hidden" name="n_act" value="{{ $n_act }}">
                      <input type="hidden" name="aid" value="{{ $aid }}">
                      <input type="hidden" name="name" value="{{ $name }}">
                      <p>
                        <label for="part">パート: </label>
                        <select name="part" class="form-control">
                          @foreach ($parts as $part)
                            <option value="{{ $part->id }}"
                              @if ($part_id == $part->id)
                              selected
                              @endif
                              >{{ $part->part }}</option>
                          @endforeach
                        </select>
                      </p>

                      <p>


                      <hr>
                      @foreach ($attendances as $attendance)
                        <p>

                          <label for="atten{{$attendance->attendance_id}}">{{ $attendance->activity->act_at }} &nbsp; </label>{{ $attendance->activity->time->jikan }} {{ $attendance->activity->place->place }}
                          <select name="atten{{$attendance->attendance_id}}" class="form-control">
                              <option value="0"
                                @if ($errors->any())
                                  @if(old("atten$attendance->attendance_id") == "0") selected @endif
                                @else
                                  @if ($attendance->attendance == 0)
                                    selected
                                  @endif
                                @endif
                              >- （未定）</option>
                              <option value="3"
                              @if ($errors->any())
                                @if(old("atten$attendance->attendance_id") == "3") selected @endif
                              @else
                                @if ($attendance->attendance == 3)
                                  selected
                                @endif
                              @endif
                              >○ （参加）</option>
                              <option value="2"
                              @if ($errors->any())
                                @if(old("atten$attendance->attendance_id") == "2") selected @endif
                              @else
                                @if ($attendance->attendance == 2)
                                  selected
                                @endif
                              @endif
                              >△ （行けないかも）</option>
                              <option value="1"
                              @if ($errors->any())
                                @if(old("atten$attendance->attendance_id") == "1") selected @endif
                              @else
                                @if ($attendance->attendance == 1)
                                  selected
                                @endif
                              @endif
                              >× （欠席）</option>
                          </select>

                        </p>


                        <p>
                          <label for="comment{{$attendance->attendance_id}}">コメント: </label>
                          <input type="text" name="comment{{$attendance->attendance_id}}"
                          value=
                            @if ($errors->any())
                              "{{ old("comment$attendance->attendance_id") }}"
                            @else
                              "{{ $attendance->comment }}"
                            @endif
                           class="form-control">
                          @if ($errors->has("comment$attendance->attendance_id"))
                            <span class="error">{{ $errors->first("comment$attendance->attendance_id") }}</span>
                          @endif
                        </p>

                      @endforeach

                      <hr>
                      <p>
                        <input type="submit" value="　　　予定を変更　　　" class="form-control">
                      </p>
                    </form>




                </div>
                <div  class="panel-footer">
                  <a href="{{ action('HomeController@show', [$year, $month]) }}">戻る</a>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
