<?php
/**
 * Project template-backend-package
 * Created by PhpStorm
 * User: tienhm <tienhm@beetsoft.com.vn>
 * Copyright: tienhm <tienhm@beetsoft.com.vn>
 * Date: 02/07/2022
 * Time: 00:27
 */

namespace tienhm\Backend\Auth\Config;

/**
 * Class Config
 *
 * @package   tienhm\Backend\Auth\Config
 * @author    tienhm <tienhm@beetsoft.com.vn>
 * @copyright tienhm <tienhm@beetsoft.com.vn>
 */
class Config
{
    public static function configGlobal()
    {
        return DataRepository::getData('config_global');
    }

    public static function configItem($item)
    {
        $config = self::configGlobal();
        if (isset($config[$item])) {
            return $config[$item];
        }

        return null;
    }
}
