<!-- imports: -->
    <link rel="stylesheet" href="{{ asset('css/abstract/dropdown.css') }}">
    <link rel="stylesheet" href="{{ asset('css/abstract/number-checkbox-input.css') }}">
    <link rel="stylesheet" href="{{ asset('css/table-tools/ordering-menu.css') }}">
    <script src="{{ asset('js/of_abstract/of_dropdown.js') }}" type="module"></script>
    <script src="{{ asset('js/of_abstract/of_number-checkbox-input.js') }}" type="module"></script>
    <script src="{{ asset('js/of_ordering-menu/of_order-direction-btn.js') }}" type="module"></script>


<!-- f($view_fields, $headers): -->
<form class="vertical-arrange vertical-center"
    method="post"
    action="{{ route('product_moves.set_order', ['target_route' => Route::current()->getName()]) }}"
>   @csrf
    <div class="dropdown">
        <button class="icon ordering-btn drop-btn" type="button" onclick="toggle_dropdown_content(this)"></button>
        <button class="icon un-ordering-btn drop-btn" type="submit" name="action" value="is_un_ordering" onclick="clear_number_checkboxes()"></button>
        <div class="dropdown-content number-check-box-container">
            <table>
                @foreach($view_fields as $rw => $view_field)
                    <tr>
                        <td>{{ $headers[$rw] }}:</td>
                        <td><input class="number-checkbox-input"
                            name="{{ $view_field }}_input_data"
                            type="number"
                            readonly
                        ></td>

                        <td>
                            <button class="icon order-direction-btn" type="button" value="asc" onclick="toggle_ordering_direction(this)"></button>
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td></td>
                    <td><button class="ok-ordering-btn icon" type="submit" name="action" value="is_ordering"></button></td>
                </tr>
            </table>
        </div>
    </div>
</form>
