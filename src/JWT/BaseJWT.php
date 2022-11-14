<?php
/**
 * Project template-backend-package
 * Created by PhpStorm
 * User: tienhm <tienhm@beetsoft.com.vn>
 * Copyright: tienhm <tienhm@beetsoft.com.vn>
 * Date: 02/07/2022
 * Time: 00:38
 */

namespace tienhm\Backend\Auth\JWT;

use tienhm\Backend\Auth\Base\BaseCore;

/**
 * Class BaseJWT
 *
 * @package   tienhm\Backend\Auth\JWT
 * @author    tienhm <tienhm@beetsoft.com.vn>
 * @copyright tienhm <tienhm@beetsoft.com.vn>
 */
class BaseJWT extends BaseCore
{
    /**
     * BaseJWT constructor.
     *
     * @param array $options
     *
     * @author   : tienhm <tienhm@beetsoft.com.vn>
     * @copyright: tienhm <tienhm@beetsoft.com.vn>
     */
    public function __construct(array $options = array())
    {
        parent::__construct($options);
        $this->logger->setLoggerSubPath(__CLASS__);
    }
}
