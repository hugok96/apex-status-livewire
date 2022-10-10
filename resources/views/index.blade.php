<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>ApexStatus</title>
        <base href="/">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="/css/app.css" />
        <link rel="icon" type="image/x-icon" href="favicon.ico">
        @livewireStyles
    </head>
    <body>
        <main id="root">
            <livewire:maps></livewire:maps>
            <div>
                <livewire:crafting></livewire:crafting>
                <livewire:servers></livewire:servers>
            </div>
            <footer class="text-muted">
                <a href="steam://rungameid/1172470">Launch Apex Legends right now!</a><br/><br/>
                <div>made and designed with <span class="heart">♥</span> by <a href="https://hugomgwtf.com" target="_blank">@hugomgwtf</a></div>
                <div>copyright © 2022</div>
            </footer>
        </main>



        <script src="/vendor/livewire/livewire.js" ></script>
        <script src="/js/app.js" ></script>
        @livewireScripts
    </body>
</html>
