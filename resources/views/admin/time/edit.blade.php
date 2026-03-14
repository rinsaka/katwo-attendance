@extends('layouts.admin-2026')

@inject('myController', 'App\Http\Controllers\Controller')

@section('content')

<main>
@include('layouts.flash')

<div class="card my-3 border-0 shadow-lg">
  <div class="card-header h5 mb-0">
    活動時間の編集（管理者モード）
  </div>
  <div class="card-body">

    <div class="mb-4">
      ここで時間を変更すると「{{ $time->jikan }}」で登録されている全ての活動予定の時間が更新されます．
    </div>

    <form method="post" action="{{ route('admin_time_update') }}" enctype='multipart/form-data'>
      {{ csrf_field() }}
      {{ method_field('patch') }}
      <input type="hidden" name="tid" value="{{ $time->id }}">

      <!-- 活動時間 -->
      <div class="mb-4">
        <label for="jikan" class="form-label fw-semibold">活動時間</label>
        <input id="jikan" name="jikan" type="text"
          class="form-control"
          maxlength="30" required placeholder="18:00 - 22:00"
          value=
        @if ($errors->any())
          "{{ old('jikan') }}"
        @else
          "{{ $time->jikan }}"
        @endif
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
              <label class="form-check-label me-5">
                @if ($time->default_jikan)
                  デフォルト活動時間に設定されています
                @else
                  デフォルト活動時間に設定する
                @endif
              </label>
              <input class="form-check-input float-end" type="checkbox" role="switch" name="default_jikan" id="default_jikan"
              @if ($time->default_jikan)
                checked disabled
              @endif
              >
            </div>
          </li>
        </ul>
      </div>

      <div class="mb-4 text-secondary" >
        登録日時：{{ $time->created_at }}<br>
        最終更新：{{ $time->updated_at }}
      </div>

      <!-- 送信 -->
      <div class="d-grid d-lg-flex justify-content-sm-end gap-2 mt-4">
        <button type="submit" class="btn btn-primary btn-lg">
          活動時間を変更する
        </button>
      </div>

    </form>

    <!-- テキストリンク（中央寄せ） -->
    <p class="text-center mt-2 mb-0">
       <a href="{{ action('Admin\HomeController@time') }}">
        活動時間一覧（管理者モード）に戻る
      </a>
    </p>

    <!-- テキストリンク（右寄せ） -->
    <p class="text-end mt-2 mb-0">
       <a href="{{ action('Admin\HomeController@time_delete', $time->id) }}">
        活動時間情報を削除する
      </a>
    </p>



  </div>
</div>
</main>

@include('layouts.admin-footer')
@endsection
