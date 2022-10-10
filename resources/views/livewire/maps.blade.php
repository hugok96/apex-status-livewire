<main id="maps">
{{--    <main>--}}
        @foreach($modes as $gameMode)
            <x-map :mode="$gameMode"></x-map>
        @endforeach
{{--    </main>--}}
</main>
