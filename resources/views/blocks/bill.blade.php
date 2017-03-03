<div class="bill">
    <header class="bill__header">
        <h3 class="bill__name">{{ $bill->Name }}</h3>
        <p class="bill__title">{{ $bill->Title }}</p>
    </header>
    <div class="bill__actions">
        @if($bill->isTrackedByCurrentUser)
            <div class="bill__tracked-label">You are tracking this bill</div>
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