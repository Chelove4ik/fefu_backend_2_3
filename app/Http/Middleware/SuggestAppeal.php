<?php

namespace App\Http\Middleware;

use App\Models\Settings;
use Closure;
use Illuminate\Http\Request;

class SuggestAppeal
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $setting = app(Settings::class);

        if (!$request->session()->has('page_counter') || !$request->session()->has('show_counter')) {
            $request->session()->put('page_counter', 0);
            $request->session()->put('show_counter', 0);
        }

        if ($request->session()->get('appeal_send', false) || $request->session()->get('show_counter') >= $setting->max) {
            return $next($request);
        }

        $request->session()->increment('page_counter');
        if ($request->session()->get('page_counter') >= $setting->periodicity) {
            $request->session()->put('page_counter', 0);
            $request->session()->increment('show_counter');
            $request->session()->now('need_show_suggest', true);
            $request->session()->put('need_show_text', true);
        }

        return $next($request);
    }
}
