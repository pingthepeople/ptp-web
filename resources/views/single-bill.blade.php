@extends('layouts.main')

@section('title', $bill['DisplayName'].' | Ping the People')

@section('content')
    <div class="bill">
        <h1>
            <div class="bill__name">{{ $bill['DisplayName']}}</div>
            <div class="bill__title">{{ $bill['Title']}}</div>
        </h1>

        <div class="bill__metadata">
            @if($bill['IsDead'])
                <div class="tooltip">
                    <div class="bill__dead-tag tooltip__trigger u-underline">This bill is dead</div>
                    <div class="tooltip__content">
                        This bill either failed a vote or missed a deadline for a reading or hearing. It is no longer being considered as a distinct piece of legislation.
                    </div>
                </div>
            @endif

            @if($user)
                <form action="/track" method="post">
                    {{csrf_field()}}
                    <input type="hidden" name="id" value="{{$bill['id']}}">
                    <input type="hidden" name="redirect" value="{{Request::url()}}">
                    @if($bill['isTracked'])
                        <p>
                            You are watching this legislation
                            <button class="button--inline">
                                Stop watching {{$bill['DisplayName']}}
                            </button>
                        </p>
                    @else
                        <button>
                            Watch {{$bill['DisplayName']}}
                        </button>
                    @endif
                </form>
            @endif
        </div>

        <div class="bill__body">
            {{ $bill['Description']}}
        </div>

        <pre>
            <?php var_dump($bill); ?>
        </pre>
    </div>
@endsection
