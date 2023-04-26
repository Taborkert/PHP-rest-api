<?php

class Request
{
    public static function get_uri()
    {
        return explode('/', substr($_SERVER['REQUEST_URI'], 5));
    }

    public static function get_method()
    {
        return $_SERVER['REQUEST_METHOD'];
    }
}
