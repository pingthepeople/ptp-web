<bill :bill="{{$bill}}">
    <noscript>
        <div class="bill">
            <header class="bill__header">
                <h3 class="bill__name">{{ $bill->Name }}</h3>
                <p class="bill__title">{{ $bill->Title }}</p>
            </header>
            <div class="bill__actions">
                @if($bill->isTrackedByCurrentUser)
                    <form action="/track-bill/{{$bill->Id}}" method="post">
                        {{csrf_field()}}
                        <button class="button button--small">Stop tracking</button>
                    </form>
                @else
                    <form action="/track-bill/{{$bill->Id}}" method="post">
                        {{csrf_field()}}
                        <button class="button button--small">Track this bill</button>
                    </form>
                @endif
            </div>
            <div class="bill__description">
                {{ $bill->Description }}
            </div>
        </div>
    </noscript>
</bill>