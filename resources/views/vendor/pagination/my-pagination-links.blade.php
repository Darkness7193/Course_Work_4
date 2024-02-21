<link rel="stylesheet" href="{{ asset('css/my-pagination-links.css') }}">
<link rel="stylesheet" href="{{ asset('css/global.css') }}">


@if ($paginator->hasPages())
    <nav class="d-flex justify-items-center justify-content-between">
        <div class="d-none flex-sm-fill d-sm-flex align-items-sm-center justify-content-sm-between">
            <form method="POST"
                  action="{{ route('post_to_get_route', ['target_route' => Route::current()->getName()]) }}"
                  class="search-form"
                  autocomplete="off"
            >
                @csrf {{ csrf_field() }}

                <p class="small text-muted">
                    {!! __('Показать') !!}
                    <input type="number" class="count-input" name='per_page' value="{{ $paginator->perPage() }}" onchange="this.form.submit()">
                    {!! __('строк') !!}
                    <input type="number" class="page-input" name='current_page' value="{{ $paginator->currentPage() }}" onchange="this.form.submit()">
                    {!! __('страницы из') !!}
                    <span class="fw-semibold">{{ $paginator->lastPage() }}</span>
                </p>
            </form>
        </div>
    </nav>
@endif
