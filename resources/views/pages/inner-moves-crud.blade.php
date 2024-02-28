<!DOCTYPE html>
    <script>
        window.update_or_create_in_bulk_route = '{{ route('product_moves.bulk_update_or_create') }}'
        window.delete_in_bulk_route = '{{ route('product_moves.bulk_delete') }}'
        window.img_delete_on = "{{ asset('images/delete-on.png') }}"
        window.img_delete_off = "{{ asset('images/delete-off.png') }}"
    </script>


<!-- imports: -->
    <script src="{{ asset('js/auto_new_tr.js') }}" type="module"></script>
    <link rel="stylesheet" href="{{ asset('css/crud-table.css') }}">
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">


<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta id="csrf-token" content="{{ csrf_token() }}">
</head>
<body>

<table
    class="crud-table"
    data-view-fields="{{ implode(',', $view_fields) }}"
    data-max-id="{{ $max_id }}"
>
    <tr>
        <th> ДАТА </th>

        <th> ТИП </th>
        <th> СКЛАД (начальный) </th>
        <th> СКЛАД (конечный) </th>

        <th> ТОВАР </th>
        <th> КОЛ-ВО </th>
        <th> ЦЕНА </th>

        <th> КОММЕНТАРИЙ </th>
    </tr>

    @foreach ($inner_moves as $inner_move)
        @include('crud-components.inner-move-crud-tr', [
            'row' => $inner_move,
            'ProductMove' => $ProductMove,
            'products' => $products,
            'storages' => $storages,
        ])
    @endforeach

    @if ($inner_moves->count() < $inner_moves->perPage())
        @include('crud-components.inner-move-crud-tr', [
            'row' => $emptyRow,
            'ProductMove' => $ProductMove,
            'products' => $products,
            'storages' => $storages,
            'is_create_tr' => true,
        ])
        <script type="module">
            window.per_page = Number('{{ $inner_moves->perPage() }}')
            window.page_count = Number('{{ $inner_moves->count() }}')
            let crud_table = document.getElementsByClassName('crud-table')[0]
            let last_tr = crud_table.rows[crud_table.rows.length - 1]
            last_tr.onchange = ()=>{ auto_new_tr() }
            set_next_row_id(last_tr)
        </script>
    @endif
</table>


<div>{{ $inner_moves->links('pagination::my-pagination-links') }}</div>

@include('crud-components.save-btn', ['no_view_fields' => [
    'product_move_type' => 'purchasing',
    'new_storage_id' => null
]])

@include('table-tools.search-bar', [
    'model_for_route' => 'product_moves.purchases_crud',
    'search_target' => $search_target
])

@include('table-tools.advanced-search-btn', [
    'model_for_route' => 'product_moves.purchases_crud'
])

</body>
</html>


<script src="{{ asset('js/new_storage_select_disabling.js') }}" type="module"></script>
<script src="{{ asset('js/delete_btn_bulk_activation.js') }}" type="module"></script>
