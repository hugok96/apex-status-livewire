<main class="map">
    <div class="rotation-current">
        <img src="{{$mode->current_rotation?->asset}}">
        <div class="rotation-details">
            <h2>
                <small> {{ $mode->name }} </small>
                {{ $mode->current_rotation?->name }}
            </h2>
            <span>time left:</span>
            <h3 class="countdown" data-countdown-to="{{ $mode->current_rotation?->end->timestamp }}">--:--:--</h3>
        </div>
        <div class="rotation-next-up">
            <img src="{{ $mode->next_rotation?->asset }}">
            <div>
                <div>next up:</div>
                <div>{{ $mode->next_rotation?->name ?? 'Unknown' }}</div>
            </div>
        </div>
    </div>
</main>
