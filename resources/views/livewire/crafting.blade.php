<main id="crafting">
    <div class="group">
        <h1>
            daily
            <small>
                time left:
                <span class="countdown" data-countdown-to="{{ $daily[0]->end?->timestamp }}">--:--:--</span>
            </small>
        </h1>
        @foreach($daily as $rotation)
            <x-crafting-items :rotation="$rotation"></x-crafting-items>
        @endforeach
    </div>
    <div class="group">
        <h1>
            weekly
            <small>
                time left:
                <span class="countdown" data-countdown-to="{{ $weekly[0]->end?->timestamp }}">--:--:--</span>
            </small>
        </h1>
        @foreach($weekly as $rotation)
            <x-crafting-items :rotation="$rotation"></x-crafting-items>
        @endforeach
    </div>
    <div class="group">
        <h1>weapons</h1>
        @foreach($weapon as $rotation)
            <x-crafting-items :rotation="$rotation"></x-crafting-items>
        @endforeach
    </div>
    <div class="group permanent">
        <h1>permanent</h1>
        @foreach($permanent as $rotation)
            <x-crafting-items :rotation="$rotation"></x-crafting-items>
        @endforeach
    </div>
</main>
