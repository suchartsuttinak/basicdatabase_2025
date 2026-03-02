<?php

use Illuminate\Support\Facades\Route;

if (!function_exists('setActive')) {
    function setActive($routeName) {
        return Route::currentRouteName() === $routeName ? 'active' : '';
    }
}