@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{{ $year }}年{{ $month }}月の予定を登録してください</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif


                    <form method="post" action="{{ url('/home') }}" enctype='multipart/form-data'>
                      {{ csrf_field() }}
                      <input type="hidden" name="year" value="{{ $year }}">
                      <input type="hidden" name="month" value="{{ $month }}">
                      <input type="hidden" name="n_act" value="{{ $n_act }}">
                      <p>
                        <label for="part">パート: </label>
                        <select name="part" class="form-control">
                          <option value=""> パートを選択してください </option>
                          @foreach ($parts as $part)
                            <option value="{{ $part->id }}">{{ $part->part }}</option>
                          @endforeach
                        </select>
                        @if ($errors->has('part'))
                          <span class="error">{{ $errors->first('part') }}</span>
                        @endif
                      </p>

                      <p>
                        <label for="name">名前: </label>
                        <input type="text" name="name" value="{{ old('name') }}" class="form-control">
                        @if ($errors->has('name'))
                          <span class="error">{{ $errors->first('name') }}</span>
                        @endif
                      </p>

                      <hr>
                      @foreach ($activities as $activity)
                        <p>

                          <label for="act{{$activity->id}}">{{ $activity->act_at }}</label> &nbsp;
                          {{ $activity->time->jikan }}
                          {{ $activity->place->place }}
                          <select name="act{{$activity->id}}" class="form-control">
                              <option value="0" @if(old("act$activity->id") == "0") selected @endif>- （未定）</option>
                              <option value="3" @if(old("act$activity->id") == "3") selected @endif>○ （参加）</option>
                              <option value="2" @if(old("act$activity->id") == "2") selected @endif>△ （行けないかも）</option>
                              <option value="1" @if(old("act$activity->id") == "1") selected @endif>× （欠席）</option>
                          </select>

                        </p>

                      @endforeach

                      <hr>
                      <p>
                        <input type="submit" value="　　　予定を登録　　　" class="form-control">
                      </p>
                    </form>




                </div>
                <div  class="panel-footer" >
                  <a href="{{ action('HomeController@show', [$year, $month]) }}">戻る</a>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
