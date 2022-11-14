<?php

namespace tienhm\Backend\Auth\Config;

/**
 * Class DataRepository
 *
 * @package   tienhm\Backend\Auth\Config
 * @author    tienhm <tienhm@beetsoft.com.vn>
 * @copyright tienhm <tienhm@beetsoft.com.vn>
 */
class DataRepository
{
    const CONFIG_PATH = 'config';
    const CONFIG_EXT  = '.php';

    /**
     * Hàm lấy nội dung config được quy định trong thư mục config
     *
     * @author: tienhm <tienhm@beetsoft.com.vn>
     * @time  : 9/28/18 14:47
     *
     * @param string $configName Tên file config
     *
     * @return array|mixed
     */
    public static function getData(string $configName)
    {
        $path = __DIR__ . DIRECTORY_SEPARATOR . self::CONFIG_PATH . DIRECTORY_SEPARATOR . $configName . self::CONFIG_EXT;
        if (is_file($path) && file_exists($path)) {
            return require $path;
        }

        return array();
    }
}
