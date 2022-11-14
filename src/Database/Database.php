<?php

namespace tienhm\Backend\Auth\Database;

use tienhm\Backend\Auth\Base\BaseCore;
use tienhm\Backend\Auth\Database\Traits\SignatureTable;
use nguyenanhung\MyDatabase\Model\BaseModel;
use tienhm\Backend\Auth\Database\Traits\UserTable;

/**
 * Class Database
 *
 * @package   tienhm\Backend\Auth\Database
 * @author    tienhm <tienhm@beetsoft.com.vn>
 * @copyright tienhm <tienhm@beetsoft.com.vn>
 */
class Database extends BaseCore
{
    use SignatureTable, UserTable;

    /** @var array $database */
    protected $database;

    /**
     * Database constructor.
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

    /**
     * Function setDatabase
     *
     * @param $database
     *
     * @return $this
     * @author   : tienhm <tienhm@beetsoft.com.vn>
     * @copyright: tienhm <tienhm@beetsoft.com.vn>
     * @time     : 22/06/2022 38:16
     */
    public function setDatabase($database): Database
    {
        $this->database = $database;

        return $this;
    }

    /**
     * Function connection
     *
     * @return \nguyenanhung\MyDatabase\Model\BaseModel
     * @author   : tienhm <tienhm@beetsoft.com.vn>
     * @copyright: tienhm <tienhm@beetsoft.com.vn>
     * @time     : 22/06/2022 40:58
     */
    public function connection(): BaseModel
    {
        $DB                      = new BaseModel();
        $DB->debugStatus         = $this->options['debugStatus'];
        $DB->debugLevel          = $this->options['debugLevel'];
        $DB->debugLoggerPath     = $this->options['loggerPath'];
        $DB->debugLoggerFilename = 'Log-' . date('Y-m-d') . '.log';
        $DB->setDatabase($this->database);
        $DB->__construct($this->database);

        return $DB;
    }

    /**
     * Function initTable - Connection to special table
     *
     * @param $table
     *
     * @return \nguyenanhung\MyDatabase\Model\BaseModel
     * @author   : tienhm <tienhm@beetsoft.com.vn>
     * @copyright: tienhm <tienhm@beetsoft.com.vn>
     * @time     : 15/11/2022 06:39
     */
    protected function initTable($table): BaseModel
    {
        $DB = $this->connection();
        $DB->setTable($table);

        return $DB;
    }

    /**
     * Function checkExitsRecord
     *
     * @param $wheres
     * @param $tableName
     *
     * @return bool
     * @author   : tienhm <tienhm@beetsoft.com.vn>
     * @copyright: tienhm <tienhm@beetsoft.com.vn>
     * @time     : 15/11/2022 06:39
     */
    public function checkExitsRecords($wheres, $tableName): bool
    {
        $DB = $this->connection();
        $DB->setTable($tableName);
        $result = $DB->checkExists($wheres);
        $DB->disconnect();
        unset($DB);

        return $result === 1;
    }
}
