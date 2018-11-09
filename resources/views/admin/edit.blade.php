@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{{ $activity->act_at }} &nbsp; 活動予定の表示と編集（管理者モード）</div>

                <div class="panel-body">
                    {{-- フラッシュメッセージの表示 --}}
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div>
                      <form method="post" action="{{ route('admin_act_update') }}" enctype='multipart/form-data'>
                        {{ csrf_field() }}
                        {{ method_field('patch') }}
                        <input type="hidden" name="aid" value="{{ $activity->id }}">

                        <p>
                          <label for="act_at">日にち: </label>
                          <input type="date" name="act_at" value=
                          @if ($errors->any())
                            "{{ old("act_at") }}"
                          @else
                            "{{ $activity->act_at }}"
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
                              @if ($activity->time_id == 0)
                              selected
                              @endif
                              >未定（または，その他）</option>
                            @foreach ($times as $time)
                              <option value="{{ $time->id }}"
                                @if ($activity->time_id == $time->id)
                                selected
                                @endif
                                >{{ $time->jikan }}</option>
                            @endforeach
                          </select>
                        </p>

                        <p>
                          <label for="place">場所: </label>
                          <select name="place" class="form-control">
                            <option value="0"
                              @if ($activity->place_id == 0)
                              selected
                              @endif
                              >未定（または，その他）</option>
                            @foreach ($places as $place)
                              <option value="{{ $place->id }}"
                                @if ($activity->place_id == $place->id)
                                selected
                                @endif
                                >{{ $place->place }}</option>
                            @endforeach
                          </select>
                        </p>

                        <p>
                          <label for="note">内容: </label>
                          <input type="text" name="note" value=
                          @if ($errors->any())
                            "{{ old("note") }}"
                          @else
                            "{{ $activity->note }}"
                          @endif
                          class="form-control" placeholder="【任意】運営会議，本番，打ち上げ など通常練習以外の項目があれば（140文字以内）">
                          @if ($errors->has('note'))
                            <span class="error">{{ $errors->first('note') }}</span>
                          @endif
                        </p>


                        <hr>
                        <p>
                          <input type="submit" value="　　　活動予定を変更　　　" class="form-control submit_button">
                        </p>
                      </form>
                    </div>


                </div>

                <div  class="panel-footer">
                  <p><a href="{{ action('Admin\HomeController@index') }}">
                    戻る
                  </a></p>
                  <div class="delete_form">
                    <form action="{{ url('/admin/activity', $activity->id) }}" method="post">
                          {{ csrf_field() }}
                          {{ method_field('DELETE') }}
                          <h3>活動予定の削除</h3>
                          <p>活動予定を削除するには下の確認用の文字列のボックスに「<strong>yakuin</strong>」と入力してボタンをクリック（またはタップ）してください．なお，活動予定を削除すると，その活動に関連付けられた出欠情報も同時に削除されます．</p>
                          <p>
                            <p>
                              <label for="confirmation">確認用の文字列: </label>
                              <input type="text" name="confirmation" value=""
                              class="form-control" placeholder="yakuin と入力してください">
                            </p>
                          </p>
                          <p>
                          <button class="form-control">  活動予定の削除  </button>
                          </p>
                          <p>&nbsp;</p>
                          <p>
                            This system is developed with <a href="https://laravel.com/">Laravel</a>, <a href="https://aws.amazon.com/jp/">AWS</a> and <a href="https://github.com/rinsaka/katwo-attendance">GitHub</a>.
                          </p>
                    </form>
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
