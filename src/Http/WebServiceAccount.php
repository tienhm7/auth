<?php

namespace tienhm\Backend\Auth\Http;

use Exception;
use nguyenanhung\Libraries\Password\Hash;
use nguyenanhung\Libraries\Password\Password;
use nguyenanhung\Validation\Validation;

/**
 * Class WebServiceAccount
 *
 * @package   tienhm\Backend\Auth\Http
 * @author    tienhm <tienhm@beetsoft.com.vn>
 * @copyright tienhm <tienhm@beetsoft.com.vn>
 */
class WebServiceAccount extends BaseHttp
{
    /**
     * WebServiceAccount constructor.
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

    protected const API_NAME = 'user';
    protected const DEFAULT_ID = 0;

    protected const MES_AUTH = array(
        'notFound' => 'Account does not exist, please try again',
        'inCorrect' => 'Account or password is incorrect, please try again',
        'success' => ' successfully',
    );

    protected $table = 'tnv_user';

    public function register(): WebServiceAccount
    {
        $inputData = $this->inputData;
        try {
            $isValid = Validation::is_valid(
                $inputData,
                [
                    'fullname' => 'required',
                    'email' => 'required|valid_email',
                    'password' => 'required|between_len,6;32',
                    'confirm_password' => 'required|equalsfield,password',
                    'phone' => 'required|between_len,10;11|numeric',
                ],
                [
                    'fullname' => ['required' => 'Fill the fullname field please.'],
                    'email' => [
                        'required' => 'Fill the email field please.',
                        'valid_email' => 'Email is incorrect, please try again.'
                    ],
                    'password' => [
                        'required' => 'Fill the password field please.',
                        'between_len' => 'Password must be between {param[0]} and {param[1]} characters.'
                    ],
                    'confirm_password' => [
                        'required' => 'Fill the confirm password field please.',
                    ],
                    'phone' => [
                        'required' => 'Fill the phone field please.',
                        'between_len' => '{field} must be between {param[0]} and {param[1]} characters.',
                        'numeric' => 'please enter a valid phone number'
                    ],
                ]
            );

            if ($isValid !== true) {
                $response = array(
                    'result' => self::EXIT_CODE['invalidParams'],
                    'desc' => json_encode($isValid),
                    'inputData' => $inputData
                );
                $this->logger->error(__METHOD__ . '.' . __LINE__, $response['desc']);
            } else {
                $salt = Hash::generateUserSaltKey();
                $this->logger->debug(__METHOD__ . ' - line: ' . __LINE__, 'Salt: ' . $salt);
                $userName = $this->formatUserName($inputData);
                $data = array(
                    'department_id' => empty($inputData['department_id']) ? self::DEFAULT_ID : $inputData['department_id'],
                    'parent' => empty($inputData['parent']) ? self::DEFAULT_ID : $inputData['parent'],
                    'username' => $userName,
                    'fullname' => $inputData['fullname'],
                    'address' => empty($inputData['address']) ? '' : $inputData,
                    'email' => $inputData['email'],
                    'status' => self::STATUS['wait_active'],
                    'avatar' => null,
                    'group_id' => self::DEFAULT_ID,
                    'password' => Password::hashPassword($inputData['password'] . $salt),
                    'reset_password' => 0,
                    'updated_pass' => Date('Y-m-d H:i:s'),
                    'phone' => $inputData['phone'],
                    'note' => null,
                    'photo' => null,
                    'thumb' => null,
                    'remember_token' => null,
                    'salt' => $salt,
                    'token' => Hash::generateUserToken(),
                    'activation_key' => Hash::generateOTPCode(),
                    'created_at' => Date('Y-m-d H:i:s'),
                    'updated_at' => Date('Y-m-d H:i:s'),
                    'google_token' => empty($inputData['google_token']) ? '' : $inputData['google_token'],
                    'google_refresh_token' => empty($inputData['google_refresh_token']) ? '' : $inputData['google_refresh_token'],
                );

                $uniEmail = $this->db->checkExitsRecords(['email' => $inputData['email']], $this->table);
                $uniUserName = $this->db->checkExitsRecords(['username' => $userName], $this->table);

                // Check if the login account matches any username or email in the DB.
                if ($uniEmail || $uniUserName) {
                    $response = array(
                        'result' => self::EXIT_CODE['notUnique'],
                        'desc' => 'Email or username ' . self::MESSAGES['notUnique'],
                        'data' => $inputData,
                    );
                    $this->logger->error(__METHOD__ . ' - line: ' . __LINE__, $response['desc']);

                } else {
                    $id = $this->db->createUser($data);
                    $this->logger->info(__METHOD__ . ' - line: ' . __LINE__, 'Register ' . self::API_NAME . ': ');
                    $this->logger->debug(__METHOD__ . ' - line: ' . __LINE__, 'Register Data:', $data);
                    if ($id > 0) {
                        $response = array(
                            'result' => self::EXIT_CODE['success'],
                            'desc' => self::ACTION['register'] . self::MES_AUTH['success'],
                        );
                        $this->logger->info(__METHOD__ . ' - line: ' . __LINE__,
                            $response['desc'] . ' ' . self::API_NAME . ' id: ' . $id);
                    } else {
                        $response = array(
                            'result' => self::EXIT_CODE['notFound'],
                            'desc' => self::MESSAGES['failed'],
                            'inputData' => $inputData,
                        );
                        $this->logger->error(__METHOD__ . ' - line: ' . __LINE__, $response['desc']);
                    }
                }
            }

            $this->response = $response;

            return $this;
        } catch (Exception $e) {
            $this->logger->error(__CLASS__ . '.' . __FUNCTION__,
                'File: ' . $e->getFile() . '-Line:' . $e->getLine() . '-Message:' . $e->getMessage());
            $this->response = null;

            return $this;
        }
    }

    public function login(): WebServiceAccount
    {
        $inputData = $this->inputData;
        try {
            $isValid = Validation::is_valid(
                $inputData,
                [
                    'user' => 'required',
                    'password' => 'required',
                ],
                [
                    'user' => ['required' => 'Fill the account field please.'],
                    'password' => ['required' => 'Fill the password field please.'],
                ]
            );

            if ($isValid !== true) {
                $response = array(
                    'result' => self::EXIT_CODE['invalidParams'],
                    'desc' => json_encode($isValid),
                    'inputData' => $inputData
                );
                $this->logger->debug(__METHOD__ . ' - line: ' . __LINE__, $response['desc']);
            } else {
                $result = $this->db->checkUserLogin(['account' => $inputData['user']]) ? $this->db->checkUserLogin(['account' => $inputData['user']])[0] : false;
                $this->logger->debug(__METHOD__ . ' - line: ' . __LINE__,
                    'check username or email: ' . $inputData['user'] . ' ' . ($result ? 'tồn tại' : 'không tồn tại'));
                // check account exists in the database
                if (!$result) {
                    $response = array(
                        'result' => self::EXIT_CODE['notFound'],
                        'desc' => self::MES_AUTH['notFound'],
                        'inputData' => $inputData
                    );
                    $this->logger->error(__METHOD__ . ' - line: ' . __LINE__, $response['desc']);
                } else {
                    $password = $inputData['password'] . $result->salt;

                    if (Password::verifyPassword($password, $result->password)) {
                        $response = array(
                            'result' => self::EXIT_CODE['success'],
                            'desc' => self::ACTION['login'] . self::MES_AUTH['success'],
                        );
                        $this->logger->info(__METHOD__ . ' - line: ' . __LINE__,
                            $response['desc'] . json_encode($result));

                    } else {
                        $response = array(
                            'result' => self::EXIT_CODE['failed'],
                            'desc' => self::MES_AUTH['inCorrect'],
                            'inputData' => $inputData
                        );
                        $this->logger->error(__METHOD__ . ' - line: ' . __LINE__, $response['desc']);
                    }
                }
            }
            $this->response = $response;

            return $this;
        } catch (Exception $e) {
            $this->logger->error(__CLASS__ . '.' . __FUNCTION__,
                'File: ' . $e->getFile() . '-Line:' . $e->getLine() . '-Message:' . $e->getMessage());
            $this->response = null;

            return $this;
        }
    }

    public function logout(): WebServiceAccount
    {
        $data = [
            'code' => self::EXIT_CODE['success'],
            'description' => 'Success'
        ];
        $this->response = $data;

        return $this;
    }

    public function updatePassword(): WebServiceAccount
    {
        $data = [
            'code' => self::EXIT_CODE['success'],
            'description' => 'Success'
        ];
        $this->response = $data;

        return $this;
    }

    public function forgotPassword(): WebServiceAccount
    {
        $data = [
            'code' => self::EXIT_CODE['success'],
            'description' => 'Success'
        ];
        $this->response = $data;

        return $this;
    }

    /**
     * Function format username
     *
     * @param array $inputData
     *
     * @return mixed|string
     */
    protected function formatUserName(array $inputData = array())
    {
        if (empty($inputData['user_name'])) {
            return implode('@', explode('@', $inputData['email'], -1));
        }

        return $inputData['user_name'];
    }
}
