<?php
class Settings
{
    public static function get($settings)
    {
        return parse_ini_file('/home/taborker/server_settings/settings.ini', true)[$settings];
    }
}
