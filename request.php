<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="form.css">
<div class="container">
<div class="row justify-content-center">
<div class="col-12 col-md-8 col-lg-6 pb-5">




<?php 

include_once  '/vendor/autoload.php';

class Get_Request {

function environments($key) {
    $array       = explode( '_', $key );
    $environment = strtoupper( $array[0] );
    switch ($environment) {
        case 'LIVE':
            return constant( 'Divido\MerchantSDK\Environment::' . $environment );
             break;

        case 'SANDBOX':
            return constant( "Divido\MerchantSDK\Environment::$environment" );
            break;
        
        default:
            return constant( "Divido\MerchantSDK\Environment::SANDBOX" );
            break;
    }
}



function  get_all_finances() {
$env               = $this->environments('sandbox_cafc150c1.68f7553baca9079c07a7033850d9be1b');
$client            = new \GuzzleHttp\Client();

$httpClientWrapper = new \Divido\MerchantSDK\HttpClient\HttpClientWrapper(
				     new \Divido\MerchantSDKGuzzle6\GuzzleAdapter($client),
				     \Divido\MerchantSDK\Environment::CONFIGURATION[$env]['base_uri'],
				     'sandbox_cafc150c1.68f7553baca9079c07a7033850d9be1b'
                     );
            
$sdk               = new \Divido\MerchantSDK\Client($httpClientWrapper, $env);
$request_options   = ( new \Divido\MerchantSDK\Handlers\ApiRequestOptions() );
$plans             = $sdk->getAllPlans($request_options);
$plans             = $plans->getResources();
return $plans;
    }
};

$form = new Get_Request;
$plans = $form->get_all_finances();
$option = '';

//var_dump($plans);die;

foreach($plans as $finance ){
    //Concatenate each fiannce_id and finance_text to $option
    $option .= '<option value="'.$finance->id.'">'.$finance->description.'</option>';

         }    

?>

 <!--Form with header-->

                    <form action="application_request.php" method="post">
                        <div class="card border-primary rounded-0">
                            <div class="card-header p-0">
                                <div class="bg-info text-white text-center py-2">
                                    <h3><i class="fa fa-envelope"></i> Divido</h3>
                                    <p class="m-0">Apply for finance</p>
                                </div>
                            </div>
                            <div class="card-body p-3">

                                <!--Body-->
                                <div class="form-group">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fa fa-user text-info"></i></div>
                                        </div>
                                        <input type="text" class="form-control" id="number" name="name" placeholder="First Name" required>
                                    </div>
                                </div>
                            
                                 <div class="form-group">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fa fa-envelope text-info"></i></div>
                                        </div>
                                        <input type="text" class="form-control" id="number" name="surname" placeholder="Surname" required>
                                    </div>
                                </div>

                                 <div class="form-group">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fa fa-envelope text-info"></i></div>
                                        </div>
                                        <input type="email" class="form-control" id="number" name="email" placeholder="Email" required>
                                    </div>
                                </div>

                                 <div class="form-group">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fa fa-envelope text-info"></i></div>
                                        </div>
                                        <input type="text" class="form-control" id="number" name="address" placeholder="Full Address" required>
                                    </div>
                                </div>

                                 <div class="form-group">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fa fa-envelope text-info"></i></div>
                                        </div>
                                        <input type="phone" class="form-control" id="number" name="phone" placeholder="Phone Number" required>
                                    </div>
                                </div>

                                 <div class="form-group">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fa fa-envelope text-info"></i></div>
                                        </div>
                                        <input type="number" class="form-control" id="number" name="price" placeholder="Price" min="250" max="25000" required>
                                    </div>
                                </div>

                                 <div class="form-group">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fa fa-envelope text-info"></i></div>
                                        </div>
                                        <input type="number" class="form-control" id="number" name="deposit" placeholder="Deposit amount" required>
                                    </div>
                                </div>

                                 <div class="form-group">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fa fa-envelope text-info"></i></div>
                                        </div>
                                        <input type="text" class="form-control" id="number" name="product" placeholder="Product Name" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fa fa-user text-info"></i></div>
                                        </div>
                                        <select type="text" class="form-control" id="number" name="finance" size="1" required placeholder="Pick Finance">
                                           
                                            <option value="" disabled selected>Select your finance option</option>
                                            <?php
                                            echo $option;                                        
                                         ?>
                                        </select>    
                                    </div>
                                </div>
                                

                                <div class="text-center">
                                    <input type="submit" value="Submit" class="btn btn-info btn-block rounded-0 py-2">
                                </div>
                            </div>

                        </div>
                    </form>
                    <!--Form with header-->

          </div>
    </div>
</div>

