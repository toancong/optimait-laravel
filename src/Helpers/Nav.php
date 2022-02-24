<?php
namespace Optimait\Laravel\Helpers;


class Nav {
    public static $urlSegments = array();

    public static function setSegments($segments)
    {
        self::$urlSegments = $segments;
    }

    public static function isActive($menu)
    {
        return in_array($menu, self::$urlSegments);
    }

    public static function isActiveMultiple($menus)
    {
        $return = false;
        foreach ($menus as $menu) {
            if (in_array($menu, self::$urlSegments)) {
                $return = true;
                break;
            }
        }

        return $return;

    }


    public static function setActive($route, $class = 'active')
    {
        return (\Route::currentRouteName() == $route) ? $class : '';
    }
}