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
                        <select name="part">
                          @foreach ($parts as $part)
                            <option value="{{ $part->id }}">{{ $part->part }}</option>
                          @endforeach
                        </select>
                      </p>

                      <p>
                        <label for="name">名前: </label>
                        <input type="text" name="name">
                        @if ($errors->has('name'))
                          <span class="error">{{ $errors->first('name') }}</span>
                        @endif
                      </p>

                      <hr>
                      @foreach ($activities as $activity)
                        <p>

                          <label for="act{{$activity->id}}">{{ $activity->act_at }}: </label>
                          <select name="act{{$activity->id}}">
                              <option value="0">-</option>
                              <option value="3">○</option>
                              <option value="2">△</option>
                              <option value="1">×</option>
                          </select>
                          {{ $activity->time->jikan }}
                          {{ $activity->place->place }}
                        </p>

                      @endforeach


                      <p>
                        <input type="submit" value="　　　予定を登録　　　">
                      </p>
                    </form>




                </div>
                <div  class="panel-footer">
                  &nbsp;

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
