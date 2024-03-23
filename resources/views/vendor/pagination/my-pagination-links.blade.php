<link rel="stylesheet" href="{{ asset('css/my-pagination-links.css') }}">
<link rel="stylesheet" href="{{ asset('css/global.css') }}">


    <nav class="d-flex justify-items-center justify-content-between">
        <div class="d-none flex-sm-fill d-sm-flex align-items-sm-center justify-content-sm-between">
            <form method="POST"
                action="{{ route('post_to_get_route', ['target_route' => Route::current()->getName()]) }}"
                class="search-form"
                autocomplete="off"
            >   @csrf

                <p class="small text-muted">
                    {!! __('Показать') !!}
                    <input type="number" class="count-input" onfocus="this.select();" name='per_page' value="{{ $paginator->perPage() }}" onchange="this.form.submit()">
                    {!! __('строк') !!}
                    <input type="number" class="page-input" onfocus="this.select();" name='current_page' value="{{ $paginator->currentPage() }}" onchange="this.form.submit()">
                    {!! __('страницы из') !!}
                    <span class="last-page-indicator fw-semibold">{{ $paginator->lastPage() }}</span>
                </p>
            </form>
        </div>
    </nav>
