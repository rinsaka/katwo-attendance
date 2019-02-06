@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">活動予定を新規登録（管理者モード）</div>

                <div class="panel-body">
                    {{-- フラッシュメッセージの表示 --}}
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div>
                      <form method="post" action="{{ route('admin_act_store') }}" enctype='multipart/form-data'>
                        {{ csrf_field() }}

                        <p>
                          <label for="act_at">日にち: </label>
                          <input type="date" name="act_at" value=
                          @if ($errors->any())
                            "{{ old("act_at") }}"
                          @else
                            ""
                          @endif
                          class="form-control">
                          @if ($errors->has('act_at'))
                            <span class="error">{{ $errors->first('act_at') }}</span>
                          @endif
                        </p>

                        <p>
                          <label for="time">時間: </label>
                          <select name="time" class="form-control">
                            <option value="0"
                              @if ($errors->any())
                                @if (old('time') == "0") selected @endif
                              @endif >
                              未定（または，その他）</option>
                            @foreach ($times as $time)
                              <option value="{{ $time->id }}"
                                @if ($errors->any())
                                  @if (old('time') == "$time->id") selected @endif
                                @else
                                  @if ($time->default_jikan == true) selected @endif
                                @endif
                                >{{ $time->jikan }}</option>
                            @endforeach
                          </select>
                        </p>

                        <p>
                          <label for="place">場所: </label>
                          <select name="place" class="form-control">
                            <option value="0"
                              @if ($errors->any())
                                @if (old('place') == "0") selected @endif
                              @endif >
                              未定（または，その他）</option>
                            @foreach ($places as $place)
                              <option value="{{ $place->id }}"
                                @if ($errors->any())
                                  @if (old('place') == "$place->id") selected @endif
                                @else
                                  @if ($place->default_place == true ) selected @endif
                                @endif
                                 >
                                {{ $place->place }}</option>
                            @endforeach
                          </select>
                        </p>

                        <p>
                          <label for="note">内容: </label>
                          <input type="text" name="note" value=
                          @if ($errors->any())
                            "{{ old("note") }}"
                          @else
                            ""
                          @endif
                          class="form-control" placeholder="【任意】運営会議，本番，打ち上げ など通常練習以外の項目があれば（140文字以内）">
                          @if ($errors->has('note'))
                            <span class="error">{{ $errors->first('note') }}</span>
                          @endif
                        </p>


                        <hr>
                        <p>
                          <input type="submit" value="　　　活動予定を登録　　　" class="form-control submit_button">
                        </p>
                      </form>
                    </div>


                </div>

                <div  class="panel-footer">
                  <p><a href="{{ action('Admin\HomeController@index') }}">
                    戻る
                  </a></p>
                  <p>&nbsp;</p>
                  <p>
                    This system is developed with <a href="https://laravel.com/">Laravel</a>, <a href="https://aws.amazon.com/jp/">AWS</a> and <a href="https://github.com/rinsaka/katwo-attendance">GitHub</a>.
                  </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
