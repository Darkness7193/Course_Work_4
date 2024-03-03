<!-- imports: -->
    <link rel="stylesheet" href="{{ asset('css/table-tools/advanced-search-menu.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dropdown.css') }}">
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
    <script src="{{ asset('js/dropdown.js') }}" type="module"></script>


<!-- f($view_fields, $headers): -->
<div class="advanced-search-btn dropdown icon">
    <button class="drop-btn icon" type="button" onclick="toggle_dropdown_content(this)"></button>
    <div class="advanced-search-menu dropdown-content">
        <table>
            @foreach($view_fields as $rw => $view_field)
                <tr>
                    <td>{{ $headers[$rw] }}:</td>
                    <td><input class="advanced-search-input"
                        name="{{ $view_field }}_search_target"
                        type="text"
                        onfocus="this.select();"
                    ></td>
                </tr>
            @endforeach
        </table>
    </div>
</div>
