<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckDepartmentAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Извлекаем динамический параметр {code} из URL (например, 'anatomy')
        $code = $request->route('code');

        // Проверяем, есть ли в сессии подтвержденный доступ именно для этого кода
        if (!session()->has("access_granted_{$code}")) {
            // Если доступа нет, отправляем на страницу ввода кода
            return redirect()->route('departments.unlock', ['code' => $code])
                ->with('error', 'Будь ласка, введіть код доступу.');
        }

        return $next($request);
    }
}
