<!DOCTYPE html><html lang="ru">@include('global-head')


<!-- imports: -->
    @include('another/php_variables')
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">


<body>
    <button onclick="window.location='{{ route('product_moves.purchases_crud') }}'"> Покупки </button>
    <button onclick="window.location='{{ route('product_moves.sales_crud') }}'"> Продажи </button>
    <button onclick="window.location='{{ route('product_moves.inner_moves_crud') }}'"> Внутренние движения </button>

    <button onclick="window.location='{{ route('product_moves.totals_report') }}'"> Отчет </button>
    <button onclick="window.location='{{ route('product_moves.quantities_report') }}'"> Отчет количеств </button>
</body>
