<?php
	require_once('libs/config.php');
	require 'libs/e2PaymentsCurl.php';

	$url = 'https://e2payments.explicador.co.mz';

	$payloadToken = [ 
		'grant_type' => 'client_credentials',
        'client_id' => constant('CLID'),
       	'client_secret' => constant('CLSSECRET')        
    ];

    $endpointToken = '/oauth/token';

    $endpoitPay = '/v1/c2b/mpesa-payment/'.constant('IDCARTEIRA');

    $payC2B = new PaymentsC($url);
    $payC2B->accessToken($endpointToken,$payloadToken);

    if(!empty($_POST['celular']) && !empty($_POST['valor']) &&!empty($_POST['ref'])){

    	$payloadPay = '{
	        "client_id": "9614458f-470f-4551-9101-42e5ef2a1070",
	        "phone": "'.addslashes($_POST['celular']).'",
	        "amount": "'.addslashes($_POST['valor']).'",
	        "reference": "'.addslashes($_POST['ref']).'"
    	}';

	    $status = $payC2B->payC2B($endpoitPay, $payloadPay);
	    //print_r($status);
	    $show = 'show';
		$hiden = '';

		$suc = 'success';
		$dan = 'danger';

	    if($status['status'] == 200 || $status['status'] == 201){
	    	$msg = "Pagamento efectuado com sucesso";
			$info1 = $show;
			$info2 = $suc;
	    }else{
	    	//401 muitos digitos
	    	//print_r($status);
	    	$msg = "Pagamento não efectuado";
			$info1 = $show;
			$info2 = $dan;
	    }
	}
?>

<!doctype html>
<html lang="pt-pt">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/png" href="https://raw.githubusercontent.com/joseseie/livee2PaymentsApp/master/public/favicon.ico"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/github-fork-ribbon-css/0.2.3/gh-fork-ribbon.min.css" />
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script type="text/javascript" src="js/notify.js"></script>
    <title>e2Payments Teste</title>
  </head>
  <body>
    <header class="pb-1 pt-1 bg-dark text-white">
        <div class="container">
            <div class="d-flex justify-content-between">
                <div class="d-flex align-items-center justify-content-start te"><h5>e2Payments Live Tests</h5></div>
                <div class="d-flex align-items-center justify-content-end"><small>e2Payments v1.0.0</small></div>
            </div>
        </div>
    </header>
    <div class="container">
        <div class="row justify-content-center">
        	
            <div class="col-9 pt-5">
            	<div class="text-center p-5">
        			<img src="https://user-images.githubusercontent.com/18400142/132318330-b8536515-d0d3-44ba-817e-ee2d269722f6.png" alt="" style="width: 100px; height: 100px;">
        		</div>
                <form method="POST" action="#">
                    <div class="form-group form-floating">

                        <input type="tel" class="form-control" id="celular" name="celular" placeholder="84/85XXXXXXX" required>
                        <label for="celular">Numero com Mpesa 84/85</label>
                    </div>
                    <div class="form-group 
                    form-floating">
                        <input type="number" class="form-control" id="valor" name="valor" required placeholder="Valor">
                        <label for="valor">Valor a pagar</label>
                    </div>
                    
				    <div class="form-floating">
				      <select class="form-select" name="ref" id="floatingSelectGrid" aria-label="Floating label select example">
				        <option value="Live">Live</option>
				        <option value="TestarPagamento">Whatsapp</option>
				        <option value="Curso">Telegram</option>
				      </select>
				      <label for="floatingSelectGrid">Indique a refêrencia</label>
				    </div><br>
                    <button type="submit" class="btn btn-dark d-flex justify-content-end">Pagamento</button><br>
                    <div id="info" class=" alert alert-<?php echo $info2;?> alert-dismissible fade <?php echo $info1;?> " role="alert"><?php  echo $msg; $info1 ='f';?>
                    	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					    <span aria-hidden="true">&times;</span>
					  </button>
					</div>			
						
                </form>   
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $( "#floatingSelectGrid" ).val();
        $( "#floatingSelectGrid option:selected" ).text();
  	</script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>