@extends('layouts.admin-2026')

@inject('myController', 'App\Http\Controllers\Controller')

@section('content')

<main>
@include('layouts.flash')

<div class="card my-3 border-0 shadow-lg">
  <div class="card-header h5 mb-0">
    活動時間の削除（管理者モード）
  </div>
  <div class="card-body">

    <div class="mb-4">
      次の情報を削除しますか？この操作は元に戻せません．
    </div>

    <div class="mb-4">
      活動時間：{{ $time->jikan }}<br>
      登録済み活動回数：{{ $cnt }}<br>
      <span class="text-secondary">
        登録日時：{{ $time->created_at }}<br>
        最終更新：{{ $time->updated_at }}
      </span>
    </div>

    <form method="post" action="{{ action('Admin\HomeController@time_destroy', $time->id) }}">
      {{ csrf_field() }}
      {{ method_field('delete') }}


      <!-- 送信 -->
      <div class="d-grid d-lg-flex justify-content-sm-end gap-2 mt-4">
        <button type="submit" class="btn btn-danger btn-lg">
          活動時間情報を削除する
        </button>
      </div>
    </form>

  </div>
</div>
</main>

@include('layouts.admin-footer')
@endsection
