@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div>
                      @forelse ($activities as $activity)
                        <h3>{{ $activity->act_at }}</h3>
                          @foreach ($activity->attendances as $attendance)
                            <p>
                              {{ $attendance->part->part }}  {{ $attendance->name }}
                              @if ($attendance->attendance == 3)
                                ○
                              @elseif ($attendance->attendance == 2)
                                △
                              @elseif ($attendance->attendance == 1)
                                ×
                              @else
                                -
                              @endif
                            </p>
                          @endforeach
                      @empty
                      <p>No Activity Yet!</p>
                      @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
