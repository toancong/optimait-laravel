<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 6/27/14
 * Time: 11:28 AM
 */

namespace Optimait\Laravel\Services\Export;


interface ExportInterface {

    public function setHeadings($array);

    public function export($data);
} 