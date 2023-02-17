<thead>
    <tr>
        @if(isset($modules_config['header']) && !empty($modules_config['header']))
            @foreach($modules_config['header'] as $head)
                <th>{{$head}}</th>
            @endforeach
        @endif
    </tr>
</thead>
<tbody>
    @if(isset($modules_config['header']) && !empty($modules_config['header']))
        <tr style="height: 50px;"><td colspan="{{count($modules_config['header'])}}">Waiting...</td></tr>
    @endif
</tbody>
<tfoot>
    @if(isset($modules_config['footer']) && !empty($modules_config['footer']))
        <tr>
            <td colspan="2">TỔNG CỘNG</td>
            @for($i = 0; $i < (count($modules_config['header'])-2); $i++)
                <td></td>
            @endfor
        </tr>
    @endif
</tfoot>