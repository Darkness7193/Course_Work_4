<!-- imports: -->
    <link rel="stylesheet" href="{{ asset('css/dropdown.css') }}">
    <link rel="stylesheet" href="{{ asset('css/table-tools/ordering-menu.css') }}">
    <link rel="stylesheet" href="{{ asset('css/number-checkbox.css') }}">
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
    <script src="{{ asset('js/dropdown.js') }}" type="module"></script>


<!-- f($view_fields, $headers): -->
<div class="dropdown">
    <button type="button" onclick="toggle_dropdown_content(this)" class="icon ordering-btn drop-btn"></button>
    <div class="dropdown-content number-check-box-container">
        <table>
            @foreach($view_fields as $rw => $view_field)
                <tr>
                    <td>{{ $headers[$rw] }}:</td>
                    <td><input class="number-checkbox"
                        name="{{ $view_field }}_search_target"
                        type="number"
                    ></td>
                </tr>
            @endforeach
        </table>
    </div>
</div>
