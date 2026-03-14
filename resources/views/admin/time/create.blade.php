@extends('layouts.admin-2026')

@inject('myController', 'App\Http\Controllers\Controller')

@section('content')

<main>
@include('layouts.flash')

<div class="card my-3 border-0 shadow-lg">
  <div class="card-header h5 mb-0">
    活動時間の新規登録（管理者モード）
  </div>
  <div class="card-body">
    <form method="post" action="{{ route('admin_time_store') }}" enctype='multipart/form-data'>
      {{ csrf_field() }}

      <!-- 活動時間 -->
      <div class="mb-4">
        <label for="jikan" class="form-label fw-semibold">活動時間</label>
        <input id="jikan" name="jikan" type="text"
          class="form-control"
          maxlength="30" required placeholder="18:00 - 22:00"
          value="{{ old('jikan') }}"
        />
        <div class="form-text">【必須】活動時間を入力してください。</div>
        @if ($errors->has('jikan'))
          <div class="form-text text-bg-warning px-3">{{ $errors->first('jikan') }}</div>
        @endif
      </div>

      <!-- デフォルト活動時間 -->
      <div class="mb-3">
        <div class="form-text">デフォルト活動時間として設定したい場合はOnにしてください。</div>
        <ul class="list-group">
          <li class="list-group-item">
            <div class="form-check form-switch ps-0">
              <label class="form-check-label me-5">デフォルト活動施設に設定する</label>
              <input class="form-check-input float-end" type="checkbox" role="switch" name="default_jikan" id="default_jikan">
            </div>
          </li>
        </ul>
      </div>

      <!-- 送信 -->
      <div class="d-grid d-lg-flex justify-content-sm-end gap-2 mt-4">
        <button type="submit" class="btn btn-primary btn-lg">
          活動時間を登録する
        </button>
      </div>
    </form>

    <!-- テキストリンク（中央寄せ） -->
    <p class="text-center mt-2 mb-0">
       <a href="{{ action('Admin\HomeController@time') }}">
        活動時間一覧（管理者モード）に戻る
      </a>
    </p>


  </div>
</div>
</main>
@include('layouts.admin-footer')
@endsection
