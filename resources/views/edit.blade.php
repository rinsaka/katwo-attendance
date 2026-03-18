@extends('layouts.app-2026')

@inject('myController', 'App\Http\Controllers\Controller')

@section('content')

<main class="container-md">
@include('layouts.flash')

<div class="card my-3 border-0 shadow-lg">
  <div class="card-header bg-primary text-white h5 mb-0">
    {{ $name }}&nbsp;さんの{{ $year }}年{{ $month }}月の予定を変更します
  </div>
  <div class="card-body">
    <p class="mb-0 text-body-secondary">
      必要事項を入力し、ページ下部の「変更する」ボタンを押してください。
    </p>
  </div>
</div>


<!-- 入力フォームカード -->
<div class="card mb-4">
  <div class="card-body">
    <form method="post" action="{{ route('update') }}" enctype='multipart/form-data'>

      {{ csrf_field() }}
      {{ method_field('patch') }}
      <input type="hidden" name="year" value="{{ $year }}">
      <input type="hidden" name="month" value="{{ $month }}">
      <input type="hidden" name="n_act" value="{{ $n_act }}">
      <input type="hidden" name="aid" value="{{ $aid }}">
      <input type="hidden" name="name" value="{{ $name }}">
      <!-- パート -->
      <div class="mb-3">
        <label for="part" class="form-label fw-semibold">パート</label>
        <select id="part" name="part" class="form-select" required>
          @foreach ($parts as $part)
            <option value="{{ $part->id }}"
              @if ($part_id == $part->id)
                selected
              @endif
            >{{ $part->part }}</option>
          @endforeach
        </select>
        <div class="form-text">【必須】所属パートを選択してください。</div>
      </div>


      <hr class="my-4">

      <!-- 出欠セクション -->
      @foreach ($attendances as $attendance)
        <section>
          <div
            @if ($attendance->activity->meeting == "1")
              class="card mb-3 text-bg-info shadow-lg"
            @else
              class="card mb-3 shadow-lg"
            @endif
          >
            <div class="h6 d-flex align-items-center gap-2 ">
                <h3 class="h6 d-flex align-items-center gap-2 px-2 pt-2">
                  {{ $attendance->activity->act_at }} {{ $myController->get_youbi($attendance->activity->act_at) }}
                  <span class="badge text-bg-secondary">{{ $attendance->activity->time->jikan }}</span>
                  {{ $attendance->activity->place->place }}
                  {{ $attendance->activity->note }}
                  @if ($attendance->activity->meeting == "1")
                    【一部団員に限定した活動です】
                  @endif
                </h3>
            </div>
          <div class="card-body">
              <div class="row g-3">
                <div class="col-12 col-md-4">
                  <label for="atten{{$attendance->attendance_id}}" class="form-label fw-semibold">出欠</label>
                  <select id="atten{{$attendance->attendance_id}}" name="atten{{$attendance->attendance_id}}"  class="form-select" required>
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
                    <option value="1"
                      @if ($errors->any())
                        @if(old("atten$attendance->attendance_id") == "1") selected @endif
                      @else
                        @if ($attendance->attendance == 1)
                          selected
                        @endif
                      @endif
                    >× （欠席）</option>
                    <option value="-1"
                      @if ($errors->any())
                        @if(old("atten$attendance->attendance_id") == "-1") selected @endif
                      @else
                        @if ($attendance->attendance == -1)
                          selected
                        @endif
                      @endif
                      @if ($attendance->activity->meeting != "1") disabled @endif
                    >対象外（この会議の参加メンバーではない）</option>
                  </select>
                </div>
                <div class="col-12 col-md-8">
                  <label for="comment{{$attendance->attendance_id}}" class="form-label fw-semibold">メッセージ</label>
                  <textarea id="comment{{$attendance->attendance_id}}" name="comment{{$attendance->attendance_id}}" class="form-control"
                            rows="1" >@if($errors->any()){{ old("comment$attendance->attendance_id") }}@else{{ $attendance->comment }}@endif</textarea>
                  <div
                    @if ($attendance->activity->meeting == "1")
                      class="form-text text-bg-secondary px-2 rounded"
                    @else
                      class="form-text text-body-secondary px-2 rounded"
                    @endif
                  >
                    任意入力。140文字以内で入力してください。
                  </div>
                  @if ($errors->has("comment$attendance->attendance_id"))
                    <div class="form-text text-bg-warning px-3">{{ $errors->first("comment$attendance->attendance_id") }}</div>
                  @endif
                </div>
              </div>
            </div>
          </div>

        </section>

        <hr class="my-4">
      @endforeach



      <!-- 送信 -->
      <div class="d-grid d-sm-flex justify-content-sm-end gap-2 mt-4">
        <button type="submit" class="btn btn-primary btn-lg">
          変更する
        </button>
      </div>
      <!-- テキストリンク（中央寄せ） -->
      <p class="text-center mt-2 mb-0">
        <a href="{{ action('HomeController@show', [$year, $month]) }}">戻る</a>
      </p>

    </form>

    <!-- 削除 -->
    <form action="{{ url('/home/confirm_delete') }}" method="post">
        {{ csrf_field() }}
        <input type="hidden" name="year" value="{{ $year }}">
        <input type="hidden" name="month" value="{{ $month }}">
        <input type="hidden" name="name" value="{{ $name }}">
        <input type="hidden" name="aid" value="{{ $aid }}">

        @foreach ($attendances as $attendance)
          <input type="hidden" name="attens[]" value="{{ $attendance->id }}">
        @endforeach
      <div class="d-grid d-sm-flex justify-content-sm-start gap-2 mt-4">
        <button type="submit" class="btn btn-danger btn-sm">
          予定を削除する
        </button>
      </div>
      </form>
  </div>
</div>


</main>
@endsection
