<!DOCTYPE html><html lang="ru">@include('global-head')


<!-- imports: -->
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">


<body>
    <button onclick="window.location='{{ route('product_moves.purchases_crud') }}'"> Покупки </button>
    <button onclick="window.location='{{ route('product_moves.sales_crud') }}'"> Продажи </button>
    <button onclick="window.location='{{ route('product_moves.inner_moves_crud') }}'"> Внутренние движения </button>

    <button onclick="window.location='{{ route('product_moves.general_totals_report') }}'"> Общий отчет </button>
    <button onclick="window.location='{{ route('product_moves.quantities_report') }}'"> Отчет количеств </button>

    <button onclick="window.location='{{ route('products.crud') }}'"> products_crud </button>
    <button onclick="window.location='{{ route('storages.crud') }}'"> storages_crud </button>
</body>
