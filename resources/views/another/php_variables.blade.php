<script>
    window.php_vars = {
        'update_or_create_in_bulk_route': '{{ route('bulk_update_or_create') }}',
        'delete_in_bulk_route': '{{ route('bulk_delete') }}',
        'post_to_get_route_route': '{{ route('post_to_get_route') }}',
        'current_route': '{{ Route::current()->getName() }}',

        'img_delete_on': "{{ asset('images/delete-on.png') }}",
        'img_delete_off': "{{ asset('images/delete-off.png') }}",

        'per_page': Number('{{ $paginator->perPage() }}'),
        'page_count': Number('{{ $paginator->count() }}')
    }
</script>
