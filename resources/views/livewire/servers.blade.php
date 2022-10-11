<main id="servers">
    @foreach($serverTypes as $serverType => $servers)
        <div class="server-type">
            <table>
                <tr>
                    <th colspan="3">{{ $serverType }}</th>
                </tr>
                @foreach($servers as $server)
                    <tr>
                        <td>{{ $server->server_region }}</td>
                        <td>{{ $server->status }}</td>
                        <td>{{ $server->response_time }}ms</td>
                    </tr>
                @endforeach
            </table>
        </div>
    @endforeach
</main>
