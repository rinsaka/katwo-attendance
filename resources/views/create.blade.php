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
                          <option value=""> 【必須】パートを選択してください </option>
                          @foreach ($parts as $part)
                            <option value="{{ $part->id }}" @if(old("part") == "$part->id") selected @endif>{{ $part->part }}</option>
                          @endforeach
                        </select>
                        @if ($errors->has('part'))
                          <span class="error">{{ $errors->first('part') }}</span>
                        @endif
                      </p>

                      <p>
                        <label for="name">名前: </label>
                        <input type="text" name="name" value="{{ old('name') }}" class="form-control" placeholder="【必須】ニックネームを30文字以内で入力してください">
                        @if ($errors->has('name'))
                          <span class="error">{{ $errors->first('name') }}</span>
                        @endif
                      </p>

                      <hr>
                      @foreach ($activities as $activity)
                        <div class="form_atten">
                        <p>

                          <label for="act{{$activity->id}}">{{ $activity->act_at }}</label> &nbsp;
                          {{ $activity->time->jikan }}
                          {{ $activity->place->place }}
                          <select name="act{{$activity->id}}" class="form-control">
                              <option value="0" @if(old("act$activity->id") == "0") selected @endif>- （未定） ---- 予定を選択してください ---- </option>
                              <option value="3" @if(old("act$activity->id") == "3") selected @endif>○ （参加）</option>
                              <option value="2" @if(old("act$activity->id") == "2") selected @endif>△ （行けないかも）</option>
                              <option value="1" @if(old("act$activity->id") == "1") selected @endif>× （欠席）</option>
                          </select>
                        </p>

                        <p>
                          <label for="comment{{$activity->id}}">コメント: </label>
                          <input type="text" name="comment{{$activity->id}}"
                          value=
                            @if ($errors->any())
                              "{{ old("comment$activity->id") }}"
                            @else
                              ""
                            @endif
                           class="form-control" placeholder="［任意］「遅刻します」など，{{ $activity->act_at }}についてメッセージがあれば140文字以内で入力してください">
                          @if ($errors->has("comment$activity->id"))
                            <span class="error">{{ $errors->first("comment$activity->id") }}</span>
                          @endif
                        </p>
                        </div>
                      @endforeach

                      <hr>
                      <p>
                        <input type="submit" value="　　　予定を登録　　　" class="form-control submit_button">
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
