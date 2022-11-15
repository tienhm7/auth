[![Latest Stable Version](http://poser.pugx.org/tienhm7/auth/v)](https://packagist.org/packages/template-backend-package) [![Total Downloads](http://poser.pugx.org/tienhm7/auth/downloads)](https://packagist.org/packages/tienhm7/auth) [![Latest Unstable Version](http://poser.pugx.org/tienhm7/auth/v/unstable)](https://packagist.org/packages/tienhm7/auth) [![License](http://poser.pugx.org/tienhm7/auth/license)](https://packagist.org/packages/tienhm7/auth) [![PHP Version Require](http://poser.pugx.org/tienhm7/auth/require/php)](https://packagist.org/packages/tienhm7/auth)

# Auth Package

Simple package for registration and login

## Use Package

```
// Add package to composer
composer require tienhm7/auth

// Intergrate to Framework
Example Laravel
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use tienhm\Backend\Auth\Http\WebServiceAccount;

class AuthController extends Controller
{
    private WebServiceAccount $module;

    public function __construct()
    {
        parent::__construct();
        $this->module = (new WebServiceAccount($this->config['OPTIONS']))->setSDKConfig($this->config);
    }

    public function login(Request $request)
    {
        $data = $request->only('user', 'password');
        $api = $this->module;
        $api->setInputData($data)
            ->login();

        return $api->getResponse();
    }

    public function register(Request $request)
    {
        $data = $request->only('username', 'fullname', 'email', 'password', 'confirm_password', 'phone');
        $api = $this->module;
        $api->setInputData($data)
            ->register();

        return $api->getResponse();
    }
}
```


## Contact & Support

If any question & request, please contact following information

| Name            | Email                  | Skype                | Facebook   |
|-----------------|------------------------|----------------------|------------|
| Hoang Manh Tien | tienhm@beetsoft.com.vn | conthuyendocmoc_a888 | @tiencntt2 |

From Vietnam with Love <3