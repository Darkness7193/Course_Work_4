<!DOCTYPE html><html lang="ru">@include('global-head')


<!-- imports: -->
    @include('another/php_variables')
    <script src="{{ asset('js/of_crud-table/submit_changes.js') }}" type="module"></script>
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

    @foreach ($paginator->items() ?: [$emptyRow] as $sale)
        <tr data-row-id="{{ $sale->id }}">
            <td><input type="date" value="{{ $sale->date->toDateString() }}" onchange="update_cell_of(this)"></td>

            <td>@include('crud-components.foreign-cell', ['selected_foreign_row' => $sale->product, 'foreign_rows' => $products])</td>
            <td><input type="number" value="{{ $sale->quantity }}" onchange="update_cell_of(this)"></td>
            <td><input type="number" step="0.01" value="{{ $sale->price }}" onchange="update_cell_of(this)"></td>

            <td>@include('crud-components.foreign-cell', ['selected_foreign_row' => $sale->storage, 'foreign_rows' => $storages])</td>
            <td class="comment-td"><input type="text" value="{{ $sale->comment }}" onchange="update_cell_of(this)"></td>

            <td>@include('crud-components.delete-btn', ['is_create_tr' => $is_create_tr ?? false ])</td>
        </tr>
    @endforeach

    @if ($paginator->count() < $paginator->perPage())
        <script src="{{ asset('js/of_crud-table/set_first_creation_tr.js') }}" type="module"></script>
    @endif
</table>


<div>{{ $paginator->links('pagination::my-pagination-links') }}</div>
@include('crud-components.save-btn', ['no_view_fields' => [
    'product_move_type' => 'selling',
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
