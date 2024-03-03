<?php

class ReCaptchaVerifier {

   
    public static function verify($reCaptchaToken, $reCaptchaAction) {
            $postArray = array(
            'secret' => '6Lcb4OgnAAAAACA1KPd9ZBNdeBbVOI6CEqaSXOH2', //clave secreta
            'response' => $reCaptchaToken
             );


        $postJSON = http_build_query($postArray);

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $postJSON);
        $response = curl_exec($curl);
        curl_close($curl);

        $curlResponseArray = json_decode($response, true);

        if ($curlResponseArray["success"] == true && $curlResponseArray["action"] == $reCaptchaAction && $curlResponseArray["score"] >= 0.5) {
            return true;
        } else {
            return false;
        }
    }
}

