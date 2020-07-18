<?php

if (!function_exists('site')) {
    function site()
    {
        return config('Config\Me\Site');
    }
}

if (!function_exists('user')) {
    function user()
    {
        return config('Config\Me\User');
    }
}

if (!function_exists('menu')) {
    function menu()
    {
        return config('Config\Me\Menu');
    }
}
