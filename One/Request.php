<?php

namespace One;

class Request
{

    /**
     * @return string|null
     */
    public function ip()
    {
        return array_get_not_null($_SERVER, ['REMOTE_ADDR', 'HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR']);
    }


    /**
     * @param $name
     * @return mixed|null
     */
    public function server($name)
    {
        return array_get($_SERVER, $name);
    }

    /**
     * @return mixed|null
     */
    public function userAgent()
    {
        return $this->server('HTTP_USER_AGENT');
    }

    /**
     * @return string
     */
    public function uri()
    {
        $path = urldecode(array_get_not_null($_SERVER, ['REQUEST_URI', 'argv.1']));
        $paths = explode('?', $path);
        return '/' . trim($paths[0], '/');
    }

    /**
     * request unique id
     * @return string
     */
    public function id()
    {
        return config('log.id');
    }


    private function getFromArr($arr, $key, $default = null)
    {
        $r = array_get($arr, $key);
        if (!$r) {
            $r = $default;
        }
        return $r;

    }

    /**
     * @param $key
     * @param $default
     * @return mixed|null
     */
    public function get($key, $default = null)
    {
        return $this->getFromArr($_GET, $key, $default);
    }

    /**
     * @param $key
     * @return mixed|null
     */
    public function post($key, $default = null)
    {
        return $this->getFromArr($_POST, $key, $default);
    }

    /**
     * @param int $i
     * @return mixed|null
     */
    public function arg($i, $default = null)
    {
        global $argv;
        return $this->getFromArr($argv, $i, $default);
    }


    /**
     * @param $key
     * @return mixed|null
     */
    public function res($key, $default = null)
    {
        return $this->getFromArr($_REQUEST, $key, $default);
    }


    /**
     * @param $key
     * @return mixed|null
     */
    public function cookie($key, $default = null)
    {
        return $this->getFromArr($_COOKIE, $key, $default);
    }

    /**
     * @return string
     */
    public function input()
    {
        return file_get_contents('php://input');
    }

    /**
     * @return array
     */
    public function json()
    {
        return json_decode($this->input(), true);
    }

    /**
     * @return array
     */
    public function file()
    {
        $files = [];
        foreach ($_FILES as $name => $fs) {
            $keys = array_keys($fs);
            if (is_array($fs[$keys[0]])) {
                foreach ($keys as $k => $v) {
                    foreach ($fs[$v] as $name => $val) {
                        $files[$name][$v] = $val;
                    }
                }
            } else {
                $files[$name] = $fs;
            }
        }
        return $files;
    }

    /**
     * @return string
     */
    public function method()
    {
        return strtolower($this->server('REQUEST_METHOD'));
    }

    /**
     * @return bool
     */
    public function isAjax()
    {
        if ($this->server('HTTP_X_REQUESTED_WITH') == 'XMLHttpRequest') {
            return true;
        } else {
            return false;
        }
    }


}