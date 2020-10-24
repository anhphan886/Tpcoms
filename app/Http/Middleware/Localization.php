<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;

class Localization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $locale = (session()->has('locale')) ? session()->get('locale') : 'vi';

        if(!$locale){
            return back();
        }

        if (!in_array($locale, Config::get('app.locales'))) {
            return back();
        }
        App::setLocale($locale);

        return $next($request);
    }
}
