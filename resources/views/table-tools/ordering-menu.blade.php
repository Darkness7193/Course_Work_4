<!-- imports: -->
    <link rel="stylesheet" href="{{ asset('css/abstract/dropdown.css') }}">
    <link rel="stylesheet" href="{{ asset('css/abstract/number-checkbox-input.css') }}">
    <link rel="stylesheet" href="{{ asset('css/table-tools/ordering-menu.css') }}">
    <script src="{{ asset('js/of_abstract/of_dropdown.js') }}" type="module"></script>
    <script src="{{ asset('js/of_abstract/of_number-checkbox-input.js') }}" type="module"></script>


<!-- f($view_fields, $headers): -->
<div class="dropdown">
    <button type="button" onclick="toggle_dropdown_content(this)" class="icon ordering-btn drop-btn"></button>
    <div class="dropdown-content number-check-box-container">
        <table>
            @foreach($view_fields as $rw => $view_field)
                <tr>
                    <td>{{ $headers[$rw] }}:</td>
                    <td><input class="number-checkbox-input"
                        name="{{ $view_field }}_search_target"
                        type="number"
                    ></td>
                </tr>
            @endforeach
        </table>
    </div>
</div>
