@extends('layouts.main')

@section('title', $bill['DisplayName'].' | Ping the People')

@section('content')
    <div class="bill bill--single">
        <header class="bill__header">
            <h1>
                <div class="bill__header-name">{{ $bill['DisplayName']}}</div>
                <div class="bill__header-title">{{ $bill['Title']}}</div>
            </h1>
            <div class="bill__controls">
                @if($user)
                    <form action="/track" method="post">
                        {{csrf_field()}}
                        <input type="hidden" name="id" value="{{$bill['id']}}">
                        <input type="hidden" name="redirect" value="{{Request::url()}}">
                        @if($bill['isTracked'])
                            <button type="submit" class="button button--star">
                                <span class="u-sr-only">Stop watching {{$bill['DisplayName']}}</span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="star star--on">
                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                </svg>
                            </button>
                        @else
                            <button type="submit" class="button button--star">
                                <span class="u-sr-only">Watch {{$bill['DisplayName']}}</span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="star star--off">
                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                </svg>
                            </button>
                        @endif
                    </form>
                @endif
            </div>
        </header>
        <div class="bill__info">
            <div class="info">
                <div class="info__label">
                    Status
                </div>
                <div class="info__body">
                    @if($bill['IsDead'])
                        <div class="tooltip">
                            <div class="bill__dead-tag tooltip__trigger">Dead</div>
                            <div class="tooltip__content">
                                This bill either failed a vote or missed a deadline for a reading or hearing. It is no longer being considered as a distinct piece of legislation.
                            </div>
                        </div>
                    @else
                        <div class="tooltip">
                            <div class="bill__dead-tag tooltip__trigger">Alive</div>
                            <div class="tooltip__content">
                                This bill is being considered as legislation.
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="bill__info">
            @if(count($bill['authors']))
                <div class="info">
                    <div class="info__label">
                        @if(count($bill['authors'])==1)
                            Author
                        @else
                            Authors
                        @endif
                    </div>
                    <div class="info__body">
                        {{--this is so ugly but whitespace around the comma is bad --}}
                        @foreach($bill['authors'] as $author)@if(!$loop->first),@endif
                            <a href="#{{$author['Slug']}}">{{$author['Name']}}</a>@endforeach
                    </div>
                </div>
            @endif
            @if(count($bill['coauthors']))
                <div class="info">
                    <div class="info__label">
                        @if(count($bill['coauthors'])==1)
                            CoAuthor
                        @else
                            CoAuthors
                        @endif
                    </div>
                    <div class="info__body">
                        {{--this is so ugly but whitespace around the comma is bad --}}
                        @foreach($bill['coauthors'] as $author)@if(!$loop->first),@endif
                            <a href="#{{$author['Slug']}}">{{$author['Name']}}</a>@endforeach
                    </div>
                </div>
            @endif
        </div>
        <div class="bill__info">
            @if(count($bill['sponsors']))
                <div class="info">
                    <div class="info__label">
                        @if(count($bill['sponsors'])==1)
                            Sponsor
                        @else
                            Sponsors
                        @endif
                    </div>
                    <div class="info__body">
                        {{--this is so ugly but comma placement is important   vvv --}}
                        @foreach($bill['sponsors'] as $author)@if(!$loop->first),@endif
                            <a href="#{{$author['Slug']}}">{{$author['Name']}}</a>@endforeach
                    </div>
                </div>
            @endif
            @if(count($bill['cosponsors']))
                <div class="info">
                    <div class="info__label">
                        @if(count($bill['cosponsors'])==1)
                            CoSponsor
                        @else
                            CoSponsors
                        @endif
                    </div>
                    <div class="info__body">
                        {{--this is so ugly but comma placement is important   vvv --}}
                        @foreach($bill['cosponsors'] as $author)@if(!$loop->first),@endif
                            <a href="#{{$author['Slug']}}">{{$author['Name']}}</a>@endforeach
                    </div>
                </div>
            @endif
        </div>
        <div class="bill__info">
            @if(count($bill['committees']))
                <div class="info">
                    <div class="info__label">
                        @if(count($bill['committees'])==1)
                            Committee
                        @else
                            Committees
                        @endif
                    </div>
                    <div class="info__body">
                        @foreach($bill['committees'] as $committee)
                            @if(!$loop->first)
                                <span class="just-a-comma">,</span>
                            @endif
                            <a href="#{{$committee['Link']}}">{{$committee['Name']}}</a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
        <div class="bill__body info">
            <div class="info__label">
                Bill text
            </div>
            <div class="info__body info__body--long">
                {{ $bill['Description']}}
            </div>
        </div>
    </div>
@endsection
