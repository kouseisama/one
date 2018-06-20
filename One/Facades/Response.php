<?php

namespace One\Facades;

/**
 * @package One\Facades
 * @mixin \One\Response
 * @method string error($msg, $code = 400) static
 * @method string code($code) static
 * @method string json($data, $callback = null) static
 * @method void redirectMethod($m, $args = []) static
 * @method string redirect($url, $args = []) static
 * @method string tpl($template, $data = []) static
 *
 */

class Response extends Facade
{
    protected static function getFacadeAccessor()
    {
        if (config('app.run_mode') == 'swoole') {
            return \One\Swoole\Response::class;
        }else{
            return \One\Response::class;
        }
    }
}