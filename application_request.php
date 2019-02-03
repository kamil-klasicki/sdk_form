<?php

include_once '/vendor/autoload.php';
require_once "helper.php";
define('API_KEY', 'sandbox_cafc150c1.68f7553baca9079c07a7033850d9be1b');

class Application_Request extends Helper
{

}

//You can specify the redirect, checkout and respose URL here
$redirectUrl = 'URL OF YOUR CHOICE';
$checkoutUrl = 'URL OF YOUR CHOICE';
$responseUrl = 'URL OF YOUR CHOICE';

//Start of application request
$request = new Application_Request;
$env = $request->check_environment();
$url = 'https://secure' . $env . '.divido.com/v1/creditrequest';
$env = $request->environments(constant('API_KEY'));

//Loop through the array -> pass the key into the check_key() function to verify each post
$array = array('email', 'name', 'surname', 'email', 'address', 'phone', 'price', 'deposit', 'product', 'finance');
foreach ($array as $key) {
    $checked_array[$key] = $request->check_key($key);
}

//Generate URL-encode query string

$client = new \GuzzleHttp\Client();
$httpClientWrapper = new \Divido\MerchantSDK\HttpClient\HttpClientWrapper(
    new \Divido\MerchantSDKGuzzle6\GuzzleAdapter($client),
    \Divido\MerchantSDK\Environment::CONFIGURATION[$env]['base_uri'],
    constant('API_KEY')
);
$sdk = new \Divido\MerchantSDK\Client($httpClientWrapper, $env);
$application = (new \Divido\MerchantSDK\Models\Application())
    ->withCountryId('GB')
    ->withCurrencyId('GBP')
    ->withLanguageId('en')
    ->withFinancePlanId($checked_array['finance'])
    ->withApplicants(
        [
            [
                'firstName' => $checked_array['name'],
                'lastName' => $checked_array['surname'],
                'phoneNumber' => $checked_array['phone'],
                'email' => $checked_array['email'],
                'addresses' => array(
                    [
                        'text' => $checked_array['address'],
                    ],
                ),
            ],
        ]
    )
    ->withOrderItems([
        [
            'name' => $checked_array['product'],
            'quantity' => 1,
            'price' => (int) $checked_array['price'] * 100,
        ],
    ])
    // ->withDepositPercentage($checked_array['deposit']/100)
    ->withDepositAmount($checked_array['deposit'] * 100)
    ->withFinalisationRequired(false)
    ->withMerchantReference('')
    ->withUrls(
        [
            'merchant_redirect_url' => $redirectUrl,
            'merchant_checkout_url' => $checkoutUrl,
            'merchant_response_url' => $responseUrl,
        ]
    );

$response = $sdk->applications()->createApplication($application, [], ['Content-Type' => 'application/json']);
$application_response_body = $response->getBody()->getContents();
$decode = json_decode($application_response_body);
$result_id = $decode->data->id;
$result_redirect = $decode->data->urls->application_url;

if (true) {
    $token = header('Location: ' . urldecode($result_redirect));
} else {
    echo $decode->error;
}
