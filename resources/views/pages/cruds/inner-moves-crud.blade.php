<!DOCTYPE html>
<html lang="ru">@include('global-head')


<!-- imports: -->
@include('another.php_variables')
    <script src="{{ asset('js/of_crud-table/submit_changes.js') }}" type="module"></script>
    <script src="{{ asset('js/of_crud-table/disable_new_storage_field.js') }}" type="module"></script>
    <script src="{{ asset('js/of_crud-table/delete-btn_bulk_activation.js') }}" type="module"></script>
    <script src="{{ asset('js/of_crud-table/set_first_creation_tr.js') }}" type="module"></script>
    <link rel="stylesheet" href="{{ asset('css/crud-table.css') }}">
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">


<body>
<table class="crud-table" data-max-id="{{ $max_id }}" data-view-fields="{{ implode(',', $view_fields) }}">
    <tr>
        @foreach($headers as $header)
            <th>{{ mb_strtoupper($header) }}</th>
        @endforeach

        <th>@include('crud-components.activate-delete-btns-btn')</th>
    </tr>

    @foreach ($paginator->items() ?: [$emptyRow] as $inner_move)
        <tr data-row-id="{{ $inner_move->id }}">
            <td><input type="date" value="{{ $inner_move->date->toDateString() }}" onchange="update_cell_of(this)"></td>

            <td><select class="foreign-cell product-move-type-select" onchange="update_cell_of(this)">
                @foreach($ProductMove::inner_move_types_ru() as $inner_move_type => $inner_move_type_ru)
                    <option value="{{ $inner_move_type }}"> {{ $inner_move_type_ru }} </option>
                @endforeach
                <option value="{{ $inner_move->product_move_type }}" selected="selected" hidden="hidden">
                    {{ "$inner_move" ? $ProductMove::inner_move_types_ru()[$inner_move->product_move_type] : '' }}
                </option>
            </select></td>

            <td>@include('crud-components.foreign-cell', ['selected_foreign_row' => $inner_move->storage, 'foreign_rows' => $storages])</td>
            <td>
                @include('crud-components.foreign-cell', ['class' => 'new-storage-select', 'foreign_rows' => $storages] + (
                    "$inner_move->product_move_type" === 'transfering'
                        ? ['selected_foreign_row' => $inner_move->new_storage]
                        : ['parameters' => 'disabled="true"']))
            </td>

            <td>@include('crud-components.foreign-cell', ['selected_foreign_row' => $inner_move->product, 'foreign_rows' => $products])</td>
            <td><input type="number" value="{{ $inner_move->quantity }}" onchange="update_cell_of(this)"></td>
            <td><input type="number" step="0.01" value="{{ $inner_move->price }}" onchange="update_cell_of(this)"></td>

            <td class="comment-td"><input type="text" value="{{ $inner_move->comment }}" onchange="update_cell_of(this)"></td>

            <td>@include('crud-components.delete-btn', ['is_create_tr' => $is_create_tr ?? false ])</td>
        </tr>
    @endforeach

    @if ($paginator->count() < $paginator->perPage())
        <script src="{{ asset('js/of_crud-table/set_first_creation_tr.js') }}" type="module"></script>
    @endif
</table>


<div>{{ $paginator->links('pagination::my-pagination-links') }}</div>
@include('crud-components.save-btn', ['no_view_fields' => [
    'product_move_type' => 'purchasing',
    'new_storage_id' => null
]])
@include('table-tools.search-bar', [
    'search_targets' => $search_targets,
    'view_fields' => $view_fields,
    'headers' => $headers
])
@include('table-tools.ordering-menu', [
    'view_fields' => $view_fields,
    'headers' => $headers
])

</body>
</html>
