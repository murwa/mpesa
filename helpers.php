<?php
/**
 * Created by PhpStorm.
 * User: mxgel
 * Date: 11/05/2018
 * Time: 03:58
 */




if (! function_exists('storage_path')) {
    /**
     * Get the path to the storage folder.
     *
     * @param  string  $path
     * @return string
     */
    function storage_path($path = '')
    {
        return __DIR__.($path ? DIRECTORY_SEPARATOR.$path : $path);
    }
}