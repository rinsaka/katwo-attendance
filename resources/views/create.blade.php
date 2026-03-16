@extends('layouts.app-2026')

@inject('myController', 'App\Http\Controllers\Controller')

@section('content')
<main>
@include('layouts.flash')

<div class="card my-3 border-0 shadow-lg">
  <div class="card-header bg-primary text-white h5 mb-0">
    {{ $year }}年{{ $month }}月の予定を入力してください
  </div>
  <div class="card-body">
    <p class="mb-0 text-body-secondary">
      必要事項を入力し、ページ下部の「登録する」ボタンを押してください。
    </p>
  </div>
</div>

<!-- 入力フォームカード -->
<div class="card mb-4">
  <div class="card-body">
    <form method="post" action="{{ url('/home') }}" enctype='multipart/form-data'>

      {{ csrf_field() }}
      <input type="hidden" name="year" value="{{ $year }}">
      <input type="hidden" name="month" value="{{ $month }}">
      <input type="hidden" name="n_act" value="{{ $n_act }}">
      <!-- パート -->
      <div class="mb-3">
        <label for="part" class="form-label fw-semibold">パート</label>
        <select id="part" name="part" class="form-select" required>
          <option value="" selected disabled>選択してください</option>
          @foreach ($parts as $part)
            <option value="{{ $part->id }}" @if(old("part") == "$part->id") selected @endif>{{ $part->part }}</option>
          @endforeach
        </select>
        <div class="form-text">【必須】所属パートを選択してください。</div>
      </div>

      <!-- ニックネーム -->
      <div class="mb-4">
        <label for="name" class="form-label fw-semibold">ニックネーム</label>
        <input id="name" name="name" type="text"
          class="form-control"
          maxlength="30" required placeholder="ニックネーム"
          value="{{ old('name') }}"
        />
        <div class="form-text">【必須】30文字以内で入力してください。</div>
        @if ($errors->has('name'))
          <div class="form-text text-bg-warning px-3">{{ $errors->first('name') }}</div>
        @endif


      </div>

      <hr class="my-4">

      <!-- 出欠セクション -->
      @foreach ($activities as $activity)
        <section>
          <div
            @if ($activity->meeting == "1")
              class="card mb-3 text-bg-info shadow-lg"
            @else
              class="card mb-3 shadow-lg"
            @endif
          >
            <div class="h6 d-flex align-items-center gap-2 ">
                <h3 class="h6 d-flex align-items-center gap-2 px-2 pt-2">
                  {{ $activity->act_at }} {{ $myController->get_youbi($activity->act_at) }}
                  <span class="badge text-bg-secondary">{{ $activity->time->jikan }}</span>
                  {{ $activity->place->place }}
                  {{ $activity->note }}
                  @if ($activity->meeting == "1")
                    【一部団員に限定した活動です】
                  @endif
                </h3>
            </div>
            <div class="card-body">
              <div class="row g-3">
                <div class="col-12 col-md-4">
                  <label for="act{{$activity->id}}" class="form-label fw-semibold">出欠</label>
                  <select id="act{{$activity->id}}" name="act{{$activity->id}}" class="form-select" required>
                    <option value="0">- （未定） --- 選択してください ---</option>
                    <option value="3" @if(old("act$activity->id") == "3") selected @endif>○ （参加）</option>
                    <option value="1" @if(old("act$activity->id") == "1") selected @endif>× （欠席）</option>
                    <option value="-1" @if(old("act$activity->id") == "-1") selected @endif @if ($activity->meeting != "1") disabled @endif>対象外（この会議の参加メンバーではない）</option>
                  </select>
                </div>
                <div class="col-12 col-md-8">
                  <label for="comment{{$activity->id}}" class="form-label fw-semibold">メッセージ</label>
                  <textarea id="comment{{$activity->id}}" name="comment{{$activity->id}}" class="form-control"
                            rows="1" placeholder="例）遅刻します など">@if($errors->any()){{ old("comment$activity->id") }}@endif</textarea>
                  <div
                    @if ($activity->meeting == "1")
                      class="form-text text-bg-secondary px-2 rounded"
                    @else
                      class="form-text text-body-secondary px-2 rounded"
                    @endif
                      >
                    任意入力。140文字以内で入力してください。
                  </div>
                  @if ($errors->has("comment$activity->id"))
                    <div class="form-text text-bg-warning px-3">{{ $errors->first("comment$activity->id") }}</div>
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
          登録する
        </button>
      </div>
      <!-- テキストリンク（中央寄せ） -->
      <p class="text-center mt-2 mb-0">
        <a href="{{ action('HomeController@show', [$year, $month]) }}">戻る</a>
      </p>

    </form>
  </div>
</div>

</main>
@include('layouts.footer')
@endsection
