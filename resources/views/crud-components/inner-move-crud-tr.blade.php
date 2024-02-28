<!-- imports: -->
    <script src="{{ asset('js/submit_changes.js') }}" type="module"></script>


<!-- f($row, $products, $storages, $ProductMove, $is_create_tr=undefined): -->
<tr data-row-id="{{ $row->id }}">
    <td><input type="date" value="{{ $row->date->toDateString() }}" onchange="update_cell_of(this)"></td>

    <td><select class="product-move-type-select" onchange="update_cell_of(this)">
        @foreach($ProductMove::inner_move_types_ru() as $inner_move_type => $inner_move_type_ru)
            <option value="{{ $inner_move_type }}"> {{ $inner_move_type_ru }} </option>
        @endforeach
        <option value="{{ $row->product_move_type }}" selected="selected" hidden="hidden">
            {{ "$row" ? $ProductMove::inner_move_types_ru()[$row->product_move_type] : '' }}
        </option>
    </select></td>

    <td>@include('crud-components.foreign-cell', ['selected_foreign_row' => $row->storage, 'foreign_rows' => $storages])</td>
    <td>
        @if ("$row->product_move_type" === 'transfering')
            @include('crud-components.foreign-cell', ['class' => 'new-storage-select', 'selected_foreign_row' => $row->new_storage, 'foreign_rows' => $storages])
        @else
            @include('crud-components.foreign-cell', ['class' => 'new-storage-select', 'foreign_rows' => $storages, 'parameters' => 'disabled="true"'])
        @endif
    </td>

    <td>@include('crud-components.foreign-cell', ['selected_foreign_row' => $row->product, 'foreign_rows' => $products])</td>
    <td><input type="number" value="{{ $row->quantity }}" onchange="update_cell_of(this)"></td>
    <td><input type="number" step="0.01" value="{{ $row->price }}" onchange="update_cell_of(this)"></td>

    <td class="comment-td"><input type="text" value="{{ $row->comment }}" onchange="update_cell_of(this)"></td>

    <td>@include('crud-components.delete-btn', ['is_create_tr' => $is_create_tr ?? false ])</td>
</tr>
