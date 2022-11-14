<?php

namespace tienhm\Backend\Auth\Http;

use tienhm\Backend\Auth\Base\BaseCore;
use tienhm\Backend\Auth\Database\Database;

/**
 * Class BaseHttp
 *
 * @package   tienhm\Backend\Auth\Http
 * @author    tienhm <tienhm@beetsoft.com.vn>
 * @copyright tienhm <tienhm@beetsoft.com.vn>
 */
class BaseHttp extends BaseCore
{
    public const EXIT_CODE = [
        'success'             => 0,
        'contentIsEmpty'      => 1,
        'invalidParams'       => 2,
        'invalidSignature'    => 3,
        'outdatedSignature'   => 4,
        'invalidService'      => 5,
        'paramsIsEmpty'       => 6,
        'duplicatePrimaryKey' => 7,
        'notFound'            => 8,
        'notChange'           => 9,
        'notUnique'           => 10,
        'failed'              => 11,
    ];

    public const PAGINATE = array(
        'page_number' => 1,
        'max_results' => 10,
    );

    public const STATUS_LEVEL = [0, 1];

    public const PREFIX_AUTH = '$';

    public const MESSAGES = array(
        'invalidSignature' => 'Sai chu ky xac thuc',
        'success'          => 'Ghi nhan thanh cong',
        'failed'           => 'Ghi nhan that bai',
        'invalidParams'    => 'Sai hoac thieu tham so',
        'duplicate'        => 'Duplicate value',
        'notFound'         => 'Khong ton tai ban ghi tuong ung',
        'fieldNotFound'    => 'khong ton tai',
        'notChange'        => 'Update that bai, data khong thay doi',
        'notUnique'        => 'da ton tai, hay thu lai',
    );

    public const ACTION = array(
        'create'   => 'create',
        'getAll'   => 'list',
        'update'   => 'update',
        'read'     => 'show',
        'delete'   => 'delete',
        'login'    => 'login',
        'register' => 'register',
    );

    public const STATUS = array(
        'deactivate'  => 0,
        'active'      => 1,
        'wait_active' => 2,
    );

    public const SHOW_STATUS = array(
        'deactivate' => 0,
        'active'     => 1,
    );

    public const DEFAULT_LANGUAGE = 'vietnamese';

    /** @var \tienhm\Backend\Auth\Database\Database */
    protected $db;

    /**
     * BaseHttp constructor.
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
        $this->db = new Database($options);
    }

    protected function formatInputStartDate($inputData = array())
    {
        if (isset($inputData['begin_date'])) {
            $startDate = $inputData['begin_date'];
        } elseif (isset($inputData['begindate'])) {
            $startDate = $inputData['begindate'];
        } elseif (isset($inputData['start_date'])) {
            $startDate = $inputData['start_date'];
        } else {
            $startDate = null;
        }

        return $startDate;
    }

    protected function formatInputEndDate($inputData = array())
    {
        if (isset($inputData['end_date'])) {
            $endDate = $inputData['end_date'];
        } elseif (isset($inputData['enddate'])) {
            $endDate = $inputData['enddate'];
        } else {
            $endDate = null;
        }

        return $endDate;
    }

    protected function formatInputUsername($inputData = array())
    {
        if (isset($inputData['username'])) {
            $res = $inputData['username'];
        } elseif (isset($inputData['nickname'])) {
            $res = $inputData['nickname'];
        } elseif (isset($inputData['account'])) {
            $res = $inputData['account'];
        } elseif (isset($inputData['acc'])) {
            $res = $inputData['acc'];
        } else {
            $res = null;
        }

        return $res;
    }

    protected function formatInputSignature($inputData = array())
    {
        if (isset($inputData['signature'])) {
            $res = $inputData['signature'];
        } elseif (isset($inputData['signal'])) {
            $res = $inputData['signal'];
        } elseif (isset($inputData['token'])) {
            $res = $inputData['token'];
        } elseif (isset($inputData['secret_token'])) {
            $res = $inputData['secret_token'];
        } else {
            $res = null;
        }

        return $res;
    }
}
