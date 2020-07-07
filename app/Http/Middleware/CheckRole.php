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
        /*TODO система ролей пользователей*/
        /*при попытке сохранения записи пользователей, автоматическая переадресация на страницу create!!*/
/*        # если менеджер
        if ($request->user()->hasRole($role)) {
            # не подпускать менеджера к странице создания заявок
            if ($request->path() === 'application/create') {
                return redirect()->route('application.index');
            }
        } else {
            # Если пользователь не на странице создания
            if (($request->path() != 'application/create')) {
                # redirect на страницу создания
                return redirect()->route('application.create');
            }
        }*/
        # разрешить доступ к странице
        return $next($request);
    }
}
