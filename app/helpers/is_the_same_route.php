<?php

use Illuminate\Support\Facades\Route;




function get_previous_route_name(): string {
    return app('router')->getRoutes()->match(app('request')->create(url()->previous()))->getName();
}


function is_the_same_route(): bool {
    return Route::currentRouteName() === get_previous_route_name();
}
