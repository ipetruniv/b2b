<?php

namespace App\Http\Middleware;

use Closure;

class Debugapi
{
    /**
     * Обработка входящего запроса.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->method() == 'POST') {
            $url = str_replace('/api/','', $_SERVER['REQUEST_URI']);
            @file_put_contents($_SERVER['DOCUMENT_ROOT'].'/apilog/'.$url,json_encode($_POST));
        }
        return $next($request);
    }

}