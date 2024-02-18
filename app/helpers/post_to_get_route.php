<?php

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;


$post_to_get_route = function (Request $request): RedirectResponse {
    return to_route($request->target_route, $request->except(['target_route']));
};
