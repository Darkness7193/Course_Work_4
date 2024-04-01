<!DOCTYPE html>
<html lang="ru">@include('global-head')


<body>
<x-app-layout>
    <!-- imports: -->
        @include('another.php_variables')
        <script src="{{ asset('js/of_crud-table/submit_changes.js') }}" type="module"></script>
        <script src="{{ asset('js/of_crud-table/delete-btn_bulk_activation.js') }}" type="module"></script>
        <link rel="stylesheet" href="{{ asset('css/crud-table.css') }}">
        <link rel="stylesheet" href="{{ asset('css/global.css') }}">


    <table class="crud-table" data-max-id="{{ $Storage::max('id') }}" data-view-fields="{{ implode(',', $view_fields) }}" data-crud-model="{{ $Storage }}">
        <tr>
            @foreach($headers as $header)
                <th>{{ mb_strtoupper($header) }}</th>
            @endforeach

            <th>@include('crud-components.activate-delete-btns-btn')</th>
        </tr>

        @foreach (array_merge($paginator->items(), $filler_rows) as $storage)
            <tr data-row-id="{{ $storage->id }}">
                <td><input type="text" value="{{ $storage->name }}" onfocusout="update_cell_of(this)"></td>
                <td><input type="text" value="{{ $storage->address }}" onfocusout="update_cell_of(this)"></td>
                <td><input type="text" step="0.01" value="{{ $storage->phone_number }}" onfocusout="update_cell_of(this)"></td>
                <td><input type="text" step="0.01" value="{{ $storage->email }}" onfocusout="update_cell_of(this)"></td>

                <td class="comment-td"><input type="text" value="{{ $storage->comment }}" onfocusout="update_cell_of(this)"></td>

                <td>@include('crud-components.delete-btn')</td>
            </tr>
        @endforeach
    </table>


    <div>{{ $paginator->links('pagination::my-pagination-links') }}</div>
    @include('crud-components.save-btn', ['no_view_fields' => []])
    @include('table-tools.search-bar', compact('search_targets', 'view_fields', 'headers'))
    @include('table-tools.ordering-menu', compact('view_fields', 'headers'))
</x-app-layout>
</body>
</html>
