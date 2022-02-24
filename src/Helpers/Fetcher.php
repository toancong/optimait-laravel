<?php
/**
 * Created by PhpStorm.
 * User: Zorro
 * Date: 5/31/2016
 * Time: 11:44 AM
 */

namespace Optimait\Laravel\Helpers;


class Fetcher
{


    /*public static function Logs()
    {
        return \App\Modules\Logs\Log::with('user')->get();
    }


    public static function LatestLogs()
    {
        return \App\Modules\Logs\Log::with('user')->orderBy('created_at', 'DESC')->paginate(20);
    }*/

    public static function FindAttachment($id)
    {
        return \Optimait\Laravel\Models\Attachment::find($id);
    }

    /*public static function Modules(){
        return \App\Modules\Modules\Module::orderBy('name', 'ASC')->get();
    }*/
}