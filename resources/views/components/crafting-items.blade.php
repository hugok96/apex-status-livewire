@foreach($items as $item)
    <div title="{{ $item->item }}" class="crafting-item">
        <img class="asset" src="{{ $item->item_type?->asset }}" style="background-color: {{ $item->item_type?->rarityHex ?? '#760000'}};"/>
        <span class="description">
            <img src="/assets/crafting.svg" class="crafting"/>
            <span>{{ $item->cost }}</span>
        </span>
    </div>
@endforeach
