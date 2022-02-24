<?php
/**
 * @param $string
 * @return string
 */
function encryptIt($string)
{
    return urlencode(Crypt::encrypt($string));
}

/**
 * @param $encrypted
 * @return string
 */
function decryptIt($encrypted)
{
    return Crypt::decrypt(urldecode($encrypted));
}

/**
 * @param $route
 * @param array $params
 * @return string
 */
if (!function_exists('sysRoute')):
    function sysRoute($route, $params = array())
    {
        return route('webpanel.' . $route, $params);
    }
endif;

/**
 * @param $url
 * @return string
 */
if (!function_exists('sysUrl')):
    function sysUrl($url, $params = array())
    {
        return url('webpanel/' . $url, $params);
    }
endif;

/**
 * @param $view
 * @param array $data
 * @return \Illuminate\View\View
 */
if (!function_exists('sysView')):
    function sysView($view, $data = array())
    {
        return view('webpanel.' . $view, $data);
    }
endif;


if (!function_exists('frontView')):
    function frontView($view, $data = array())
    {
        return view('frontend.' . $view, $data);
    }
endif;


if (!function_exists('frontUrl')):
    function frontUrl($urL)
    {
        return url('frontpanel/' . $urL);
    }
endif;

if (!function_exists('frontRoute')):
    function frontRoute($route, $data = [])
    {
        return route('frontpanel.' . $route, $data);
    }
endif;


if (!function_exists('isAction')):
    function isAction($action)
    {
        return \Route::getCurrentRoute()->getActionName() == 'App\Http\Controllers\\' . $action;
    }
endif;
