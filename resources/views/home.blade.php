@extends('layouts.app')


@section('content')
<!-- imports: -->
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 horizontal-arrange" style="margin-top: 40px">

            <div class="card">
                <div class="card-header">{{ __('Движения') }}</div>
                <div class="card-body vertical-arrange">
                    <button class="page-btn" onclick="window.location='{{ route('product_moves.purchases_crud') }}'"> Покупки </button>
                    <button class="page-btn" onclick="window.location='{{ route('product_moves.sales_crud') }}'"> Продажи </button>
                    <button class="page-btn" onclick="window.location='{{ route('product_moves.inner_moves_crud') }}'"> Внутренние движения </button>
                </div>
            </div>

            <div class="card">
                <div class="card-header">{{ __('Отчеты') }}</div>
                <div class="card-body vertical-arrange">
                    <button class="page-btn" onclick="window.location='{{ route('product_moves.general_totals_report') }}'"> Общий отчет </button>
                    <button class="page-btn" onclick="window.location='{{ route('product_moves.quantities_report') }}'"> Отчет по месяцам </button>
                </div>
            </div>

            <div class="card">
                <div class="card-header">{{ __('Справочник') }}</div>
                <div class="card-body vertical-arrange">
                    <button class="page-btn" onclick="window.location='{{ route('products.crud') }}'"> Товары </button>
                    <button class="page-btn" onclick="window.location='{{ route('storages.crud') }}'"> Склады </button>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
