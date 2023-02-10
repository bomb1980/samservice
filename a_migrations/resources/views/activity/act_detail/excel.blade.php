<table>
    <thead>
        <tr>
            @foreach ($config as $kf => $vf)
                <th>{{ $vf['label'] }}</th>
            @endforeach

        </tr>
    </thead>
    <tbody>
        @foreach ($datas as $kd => $data)
            <tr>

                @foreach ($config as $name => $vf)
                    <td>{{ $data->$name }}</td>
                @endforeach


            </tr>
        @endforeach
    </tbody>
</table>
