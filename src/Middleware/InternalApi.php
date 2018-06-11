<?php

namespace PdInternalApi\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use function PdInternalApi\sign;

class InternalApi
{

    public function __construct()
    {
        app()->configure('internal_api');
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $ip = $request->getClientIp();

        if (!Str::startsWith($ip, [
            '127.0.0.', '192.168.', '10.0.'
        ])) {
            return new JsonResponse('', 404);
        }

        $params = $request->all();

        if (empty($params['appid'])) {
            $data = ['error' => 'require appid',];
            return new JsonResponse($data, 403);
        }

        if (empty($params['timestamp'])) {
            $data = ['error' => 'require time',];
            return new JsonResponse($data, 403);
        } elseif (intval($params['timestamp']) + 60 < time()) {
            $data = ['error' => 'sign expired',];
            return new JsonResponse($data, 403);
        }

        $key = config('internal_api.server.' . $params['appid']);

        if (empty($key)) {
            $data = ['error' => 'config error',];
            return new JsonResponse($data, 403);
        }

        $sign = sign($params, $key);
        if ($sign != $params['sign']) {
            $data = [
                'error' => 'sign error',
            ];
            return new JsonResponse($data, 403);
        }

        return $next($request);
    }

}
