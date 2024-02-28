<!DOCTYPE html>
    <script>
        window.update_or_create_in_bulk_route = '{{ route('product_moves.bulk_update_or_create') }}'
        window.delete_in_bulk_route = '{{ route('product_moves.bulk_delete') }}'
    </script>


<!-- imports: -->
    <script src="{{ asset('js/submit_changes.js') }}" type="module"></script>
    <link rel="stylesheet" href="{{ asset('css/crud-table.css') }}">
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">


<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta id="csrf-token" content="{{ csrf_token() }}">
</head>
<body
    data-img-delete-on="{{ asset('images/delete-on.png') }}"
    data-img-delete-off="{{ asset('images/delete-off.png') }}"
>

<table
    class="crud-table"
    data-view-fields="{{ implode(',', $view_fields) }}"
    data-max-id="{{ $max_id }}"
>
    <tr>
        <th> ПРОДАНО </th>

        <th> ТОВАР </th>
        <th> КОЛ-ВО </th>
        <th> ЦЕНА </th>

        <th> СКЛАД </th>
        <th> КОММЕНТАРИЙ </th>
    </tr>


    @foreach ($sales as $sale    )
        @include('crud-components.product-move-crud-tr', [
            'row' => $sale,
            'products' => $products,
            'storages' => $storages
        ])
    @endforeach

    @if (($sales->count() < $sales->perPage()) || !$sales->hasPages())
        @include('crud-components.product-move-crud-tr', [
            'row' => $emptyRow,
            'products' => $products,
            'storages' => $storages,
            'is_create_tr' => true,
        ])
        <script type="module">
            window.per_page = Number('{{ $sales->perPage() }}')
            window.page_count = Number('{{ $sales->count() }}')
            let crud_table = document.getElementsByClassName('crud-table')[0]
            let last_tr = crud_table.rows[crud_table.rows.length - 1]
            last_tr.onchange = ()=>{ auto_new_tr() }
            set_next_row_id(last_tr)
        </script>
    @endif
</table>


<div>{{ $sales->links('pagination::my-pagination-links') }}</div>

@include('crud-components.save-btn', ['no_view_fields' => [
    'product_move_type' => 'selling',
    'new_storage_id' => null
]])
@include('table-tools.search-bar', ['model_for_route' => 'product_moves.sales_crud'])

</body>
</html>


<script src="{{ asset('js/delete_btn_bulk_activation.js') }}" type="module"></script>
