@extends('layouts.app-2026')

@section('content')

<main class="container-md">
@include('layouts.flash')


<div class="card my-3 border-0 shadow-lg">
  <div class="card-header h5 mb-0">
   団員ログイン
  </div>
  <div class="card-body">

    <form class="form-horizontal" method="POST" action="{{ route('login') }}">
        {{ csrf_field() }}

        <!-- Login ID -->
        <div class="mb-4 form-group{{ $errors->has('login_id') ? ' has-error' : '' }}">
            <label for="login_id" class="form-label fw-semibold">Login ID</label>
            <input id="login_id" name="login_id" type="login_id"
                class="form-control"
                required
                value="{{ old('login_id') }}" autofocus
            />
            @if ($errors->has('login_id'))
                <span class="help-block">
                    <strong>{{ $errors->first('login_id') }}</strong>
                </span>
            @endif
        </div>

        <!-- Password -->
        <div class="mb-4 form-group{{ $errors->has('password') ? ' has-error' : '' }}">
            <label for="password" class="form-label fw-semibold">Password</label>

            <input id="password" name="password" type="password"
                class="form-control"
                required />
            @if ($errors->has('password'))
                <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
        </div>

        <!-- 送信 -->
        <div class="d-grid d-lg-flex justify-content-sm-end gap-2 mt-4">
        <button type="submit" class="btn btn-primary btn-lg">
          Login
        </button>
      </div>

    </form>
  </div>
</div>

</main>

@endsection
