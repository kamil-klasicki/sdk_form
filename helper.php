<?php

include_once './vendor/autoload.php';

class Helper
{

    public function check_environment()
    {
        if (strpos(constant('API_KEY'), 'sandbox') !== false) {
            return '.sandbox';
        } else if (strpos(constant('API_KEY'), 'live') !== false) {
            return null;
        } else {
            die('Please add your API key');
        }
    }

    public function environments($key)
    {
        $array = explode('_', $key);
        $environment = strtoupper($array[0]);
        switch ($environment) {
            case 'LIVE':
                return constant('Divido\MerchantSDK\Environment::' . $environment);
                break;

            case 'SANDBOX':
                return constant("Divido\MerchantSDK\Environment::$environment");
                break;

            default:
                return constant("Divido\MerchantSDK\Environment::SANDBOX");
                break;
        }
    }

    public function get_all_finances()
    {
        $env = $this->environments('sandbox_cafc150c1.68f7553baca9079c07a7033850d9be1b');
        $client = new \GuzzleHttp\Client();

        $httpClientWrapper = new \Divido\MerchantSDK\HttpClient\HttpClientWrapper(
            new \Divido\MerchantSDKGuzzle6\GuzzleAdapter($client),
            \Divido\MerchantSDK\Environment::CONFIGURATION[$env]['base_uri'],
            'sandbox_cafc150c1.68f7553baca9079c07a7033850d9be1b'
        );

        $sdk = new \Divido\MerchantSDK\Client($httpClientWrapper, $env);
        $request_options = (new \Divido\MerchantSDK\Handlers\ApiRequestOptions());
        $plans = $sdk->getAllPlans($request_options);
        $plans = $plans->getResources();
        $option = '';

        foreach ($plans as $finance) {
            //Concatenate each fiannce_id and finance_text to $option
            $option .= '<option value="' . $finance->id . '">' . $finance->description . '</option>';
        }
        return $option;
    }


    public function check_key($key)
    {
        return (isset($_POST[$key]) && !empty(trim($_POST[$key])) ? $_POST[$key] : false);
    }

};
