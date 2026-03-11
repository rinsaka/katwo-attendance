@extends('layouts.admin-2026')

@section('content')
<main>
{{-- =========================
    Flash messages
========================= --}}
@foreach (['success' => 'success', 'error' => 'danger'] as $key => $bs)
  @if (session($key))
    <div class="alert alert-{{ $bs }} alert-dismissible fade show my-3" role="alert">
      {{ session($key) }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="閉じる"></button>
    </div>
  @endif
@endforeach

<div class="card my-3 border-0 shadow-lg">
  <div class="card-header bg-primary text-white h5 mb-0">
    活動予定を新規登録（管理者モード）
  </div>
  <div class="card-body">

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
        <label for="meeting">活動形態（※ 新項目！）: </label>
        <select name="meeting" class="form-control">
          <option value="0">
            練習，演奏会，打ち上げなど全員が対象（通常はこちら）
          </option>
          <option value="1">
            演奏会実行委員会など一部の団員のみが対象（集計方法などが異なります）
          </option>
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

      <!-- 送信 -->
      <div class="d-grid d-sm-flex justify-content-sm-end gap-2 mt-4">
        <button type="submit" class="btn btn-primary btn-lg">
          登録する
        </button>
      </div>
      <!-- テキストリンク（中央寄せ） -->
      <p class="text-center mt-2 mb-0">
        <a href="{{ action('Admin\HomeController@index') }}">戻る</a>
      </p>
    </form>

  </div>
</div>

</main>

@include('layouts.admin-footer')
@endsection
