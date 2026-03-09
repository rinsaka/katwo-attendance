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

<div class="card my-3 border-0 shadow-lg">
  <div class="card-header bg-primary text-white h5 mb-0">
    メールのフッタ
  </div>
  <div class="card-body">
     <form>
        <p>
        <textarea name="menu" rows="15" class="form-control">{{ $mailinfo->mailinfo }}</textarea>
        </p>
    </form>
  </div>
  <div class="mb-3 px-2">
    <a href="{{ action('HomeController@index') }}">戻る</a>
  </div>
</div>

</main>

@include('layouts.footer')
@endsection
