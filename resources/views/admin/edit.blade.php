@extends('layouts.admin-2026')

@section('content')

<main>
@include('layouts.flash')

  <div class="card my-3 border-0 shadow-lg">
    <div class="card-header bg-primary text-white h5 mb-0">
      {{ $activity->act_at }} &nbsp; 活動予定の表示と編集（管理者モード）
    </div>
    <div class="card-body">

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
        <label for="meeting">活動形態: （変更できません：変更したい場合は一旦活動予定を削除してください）
        </label>
        <select name="meeting" class="form-control" disabled>
          <option value="0"
            @if ($activity->meeting != 1)
              selected
            @endif
          >
            練習，演奏会，打ち上げなど全員が対象（通常はこちら）
          </option>
          <option value="1"
            @if ($activity->meeting == 1)
              selected
            @endif
          >
            演奏会実行委員会など一部の団員のみが対象（集計方法が異なる）
          </option>
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

      <!-- 送信 -->
      <div class="d-grid d-sm-flex justify-content-sm-end gap-2 mt-4">
        <button type="submit" class="btn btn-primary btn-lg">
          活動予定を変更
        </button>
      </div>
      <!-- テキストリンク（中央寄せ） -->
      <p class="text-center mt-2 mb-0">
        <a href="{{ action('Admin\HomeController@index') }}">戻る</a>
      </p>
    </form>


    <div class="card my-3 border-1 shadow-lg bg-warning bg-gradient mt-4">
      <div class="card-header text-bg-warning h5 mb-0">
        活動予定の削除
      </div>
      <div class="card-body text-bg-warning">
        <form action="{{ url('/admin/activity', $activity->id) }}" method="post">
          {{ csrf_field() }}
          {{ method_field('DELETE') }}
          <p class="text-bg-warning">
            このページ({{ $activity->act_at }})の活動予定を削除するには下の確認用の文字列のボックスに「<strong>yakuin</strong>」と入力してボタンをクリック（またはタップ）してください．なお，活動予定を削除すると，その活動に関連付けられた団員それぞれの出欠情報も同時に削除されます．
          </p>
          <p>
            <p>
              <label for="confirmation">確認用の文字列: </label>
              <input type="text" name="confirmation" value=""
              class="form-control" placeholder="yakuin と入力してください">
            </p>
          </p>
          <div class="d-grid d-sm-flex justify-content-sm-end gap-2 mt-4">
            <button type="submit" class="btn btn-danger btn-lg">
              活動予定の削除
            </button>
          </div>
          <p>&nbsp;</p>
        </form>
      </div>
    </div>
    <!-- テキストリンク（中央寄せ） -->
    <p class="text-center mt-2 mb-0">
      <a href="{{ action('Admin\HomeController@index') }}">戻る</a>
    </p>
  </div>

</main>

@include('layouts.admin-footer')
@endsection
