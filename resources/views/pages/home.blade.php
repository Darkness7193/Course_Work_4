<!DOCTYPE html><html lang="ru">@include('global-head')


<!-- imports: -->
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">



<body>
<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <button onclick="window.location='{{ route('product_moves.purchases_crud') }}'"> Покупки </button>
                    <button onclick="window.location='{{ route('product_moves.sales_crud') }}'"> Продажи </button>
                    <button onclick="window.location='{{ route('product_moves.inner_moves_crud') }}'"> Внутренние движения </button>

                    <button onclick="window.location='{{ route('product_moves.general_totals_report') }}'"> Общий отчет </button>
                    <button onclick="window.location='{{ route('product_moves.quantities_report') }}'"> Отчет количеств </button>

                    <button onclick="window.location='{{ route('products.crud') }}'"> products_crud </button>
                    <button onclick="window.location='{{ route('storages.crud') }}'"> storages_crud </button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
</body>
