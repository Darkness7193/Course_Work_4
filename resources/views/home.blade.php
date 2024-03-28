@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif


                </div>
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
@endsection
