<?php


function query_crud_records($model, $request) {
    $purchases = $model::query();
    all_fields_search($purchases, $model, $request->search_target)->
    orderBy('date');
    paginate($purchases,
        per_page: $request->session()->get('per_page') ?? 10,
        current_page: $request->current_page ?? 1,
    );

    return $purchases;
}
