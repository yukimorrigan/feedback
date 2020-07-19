<?php

namespace App\Http\Middleware;

use Closure;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        $currentRouteName = $request->route()->getName();

        # если менеджер
        if ($request->user()->hasRole($role)) {
            # не подпускать менеджера к странице создания заявок (и перенаправлять при входе на главную)
            if ($currentRouteName === 'application.create' || $currentRouteName === 'application.store'
                || $currentRouteName === 'home') {
                # redirect на страницу с заявками
                return redirect()->route('application.index');
            }
        } else {
            # Если пользователь не на странице создания и не было запроса на сохранение в бд
            if ($currentRouteName !== 'application.create' && $currentRouteName !== 'application.store') {
                # redirect на страницу создания
                return redirect()->route('application.create');
            }
        }
        # разрешить доступ к странице
        return $next($request);
    }
}
