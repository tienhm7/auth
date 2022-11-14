<?php
/**
 * Project template-backend-package
 * Created by PhpStorm
 * User: tienhm <tienhm@beetsoft.com.vn>
 * Copyright: tienhm <tienhm@beetsoft.com.vn>
 * Date: 02/07/2022
 * Time: 00:24
 */

namespace tienhm\Backend\Auth\Repository;

use tienhm\Backend\Auth\Base\BaseCore;

/**
 * Class BaseRepository
 *
 * @package   tienhm\Backend\Auth\Repository
 * @author    tienhm <tienhm@beetsoft.com.vn>
 * @copyright tienhm <tienhm@beetsoft.com.vn>
 */
class BaseRepository extends BaseCore
{
    /**
     * BaseRepository constructor.
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
