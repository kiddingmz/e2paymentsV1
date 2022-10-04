<?php 
    class PaymentsC{
        private $ch = null;
        private $baseUrl = '';
        private $tokenType = '';
        private $AccessToken = '';

        public function __construct($url){
            $this->ch = curl_init();
            $this->baseUrl = $url;
        }

        public function accessToken($endpoit,$payload){
            curl_setopt_array($this->ch, [
                CURLOPT_URL            =>  $this->baseUrl.$endpoit,
                CURLOPT_POST           => true,
                CURLOPT_POSTFIELDS     => http_build_query($payload),
                CURLOPT_RETURNTRANSFER => true 
            ]);

            $response = curl_exec($this->ch);

            if(curl_errno($this->ch)){
                return;
            }else{
                if(empty($_COOKIE['EtwoPayments'])){
                    setcookie("EtwoPayments", json_decode($response, true)['access_token'], json_decode($response, true)['expires_in'] + time());
                    $this->tokenType = json_decode($response, true)['token_type'];
                    $this->AccessToken = json_decode($response, true)['access_token'];
                }else{
                    $this->tokenType = 'Bearer';
                    $this->AccessToken = json_decode($response, true)['access_token'];
                }
                return curl_getinfo($this->ch, CURLINFO_HTTP_CODE);
            }

        }

        public function payC2B($endpoit, $payload){
            
            $headerPay = [
                'Authorization: '. $this->tokenType.' '.$this->AccessToken,
                'Accept: application/json',
                'Content-Type: application/json'        
             ];

            curl_setopt_array($this->ch, [
                CURLOPT_URL            => $this->baseUrl.$endpoit,
                CURLOPT_HTTPHEADER     => $headerPay,
                CURLOPT_POST           => true,
                CURLOPT_POSTFIELDS     => $payload,
                CURLOPT_RETURNTRANSFER => true
             ]);

            $response = curl_exec($this->ch);

            if(curl_errno($this->ch)){
                return;
            }else{
                return ['status' => curl_getinfo($this->ch, CURLINFO_HTTP_CODE), 'message' => json_decode($response, true)];
            }
        }
    }
?>