@extends('layouts.app-2026')

@inject('myController', 'App\Http\Controllers\Controller')

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

<div class="card my-3 border-0 shadow-sm">
  <div class="card-header bg-primary text-white h5 mb-0">
    {{ $menu->activity->act_at }} {{ $myController->get_youbi($menu->activity->act_at) }} @if (strlen($menu->activity->note)) <span class="note">&nbsp; {{ $menu->activity->note }}</span>@endif の練習メニュー
  </div>
  <div class="card-body">
    <p class="mb-0 text-body-secondary">
      必要事項を入力し、ページ下部の「練習メニューを更新する」ボタンを押してください。
    </p>
  </div>
</div>

<!-- 入力フォームカード -->
<div class="card mb-4">
  <div class="card-body">
    <form method="post" action="{{ route('menu_update') }}" enctype='multipart/form-data'>

      {{ csrf_field() }}
      {{ method_field('patch') }}
      <input type="hidden" name="mid" value="{{ $menu->id }}">
      <input type="hidden" name="url" value="{{ url()->previous()}}">


      <!-- 投稿者名 -->
      <div class="mb-4">
        <label for="name" class="form-label fw-semibold">投稿者名</label>
        <input id="name" name="name" type="text"
          class="form-control"
          maxlength="30" required placeholder="投稿者名"
          value="{{ $menu->name }}"
        />
        <div class="form-text">【必須】投稿者の名前を入れてください。</div>
        @if ($errors->has('name'))
          <div class="form-text text-bg-warning px-3">{{ $errors->first('name') }}</div>
        @endif
      </div>

      <!-- 練習メニュー -->
      <div class="mb-4">
        <label for="menu" class="form-label fw-semibold">練習メニュー</label>
        <textarea name="menu" rows="10" class="form-control" placeholder="練習メニューやお知らせ事項を入力して下さい" required>{{ $menu->menu }}</textarea>
        <div class="form-text">【必須】練習メニューやお知らせ事項を入力して下さい。</div>
        @if ($errors->has('menu'))
          <div class="form-text text-bg-warning px-3">{{ $errors->first('menu') }}</div>
        @endif
      </div>
      <p>

      </p>
      <p class="mb-0 text-body-secondary">
        投稿日時：{{ $menu->created_at }}
      </p>
      <p class="mb-0 text-body-secondary">
        最終更新：{{ $menu->updated_at }}
      </p>


      <!-- 送信 -->
      <div class="d-grid d-sm-flex justify-content-sm-end gap-2 mt-4">
        <button type="submit" class="btn btn-primary btn-lg">
          練習メニューを更新する
        </button>
      </div>

      <!-- テキストリンク（右寄せ） -->
      <p class="text-end mt-2 mb-0">
        <a href="{{ action('MenusController@mail', $menu->id) }}">
          案内メールの文面を生成する
        </a>
      </p>
      <!-- テキストリンク（中央寄せ） -->
      <p class="text-center mt-2 mb-0">
        <a href="{{ url()->previous() }}">戻る</a>
      </p>

    </form>
  </div>
</div>
</main>

@endsection
