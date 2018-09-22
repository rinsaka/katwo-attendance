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
                          <label for="name">日にち: </label>
                          <input type="text" name="act_at" value=
                          @if ($errors->any())
                            "{{ old("act_at") }}"
                          @else
                            ""
                          @endif
                          class="form-control" placeholder="【必須】2020/01/01, 2020-01-01, 20200101 のいずれかで">
                          @if ($errors->has('act_at'))
                            <span class="error">{{ $errors->first('act_at') }}</span>
                          @endif
                        </p>

                        <p>
                          <label for="time">時間: </label>
                          <select name="time" class="form-control">
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


                        <hr>
                        <p>
                          <input type="submit" value="　　　活動予定を登録　　　" class="form-control submit_button">
                        </p>
                      </form>
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
