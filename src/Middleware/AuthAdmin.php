<?php

namespace WTG\Admin\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class AuthAdmin
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($this->auth->guest()) {
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()
                    ->guest(route('auth::login'));
            }
        } elseif (! $this->auth->user()->isAdmin()) {
            return redirect()
                ->to(route('account::dashboard'))
                ->withErrors(trans('admin::auth.no_admin_rights'));
        }

        return $next($request);
    }
}
