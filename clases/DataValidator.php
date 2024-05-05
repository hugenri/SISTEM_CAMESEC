<?php



class DataValidator {


public static function validateLettersOnly($text, $message) {
            $text2 = str_replace(" ", "", $text);
        if (preg_match("/^[\p{L}\s]+$/u", $text2) === 1) {
            return true;
        } else {
          $response = array('success' => false, 'message' => $message . ': '. $text);
          return $response;
        }
    }
	
	
public static function validateLettersOnlyArray($array, $message) {
        foreach ($array as $text) {
            if (preg_match("/^[\p{L}\s]+$/u", $text) !== 1) {
                $response = array('success' => false, 'message' => $message . ': ' . $text);
                return $response;
            }
        }
        return true;
    }
    

public static function validateNumber($number, $message) {
        
            if (preg_match("/^[0-9]+$/", $number) !== 1) {
                $response = array('success' => false, 'message' => $message . ': ' . $number);
                return $response;
            }
        return true;
    }


public static function validateNumberFloat($number, $message) {
    
        // La expresión regular ahora permite números enteros y flotantes
        if (preg_match("/^[0-9]+(?:\.[0-9]+)?$/", $number) !== 1) {
            $response = array('success' => false, 'message' => $message . ': ' . $number);
            return $response;
        }
    return true;
}

public static function validateNumbersFloat($array, $message) {
    foreach ($array as $number) {
        // La expresión regular ahora permite números enteros y flotantes
        if (preg_match("/^[0-9]+(?:\.[0-9]+)?$/", $number) !== 1) {
            $response = array('success' => false, 'message' => $message . ': ' . $number);
            return $response;
        }
    }
    return true;
}

public static function validateNumbersOnlyArray($array, $message) {
    foreach ($array as $number) {
        if (preg_match("/^[0-9]+$/", $number) !== 1) {
            $response = array('success' => false, 'message' => $message . ': ' . $number);
            return $response;
        }
    }
    return true;
}


    public static function validateLength($text, $minLength, $maxLength, $message) {
        $length = strlen($text);
        if ($length >= $minLength && $length <= $maxLength) {
           // $validacion = true;
            return true;
        } else {
          return  $response = array('success' => false, 'message' => $message . ': '. $text);
        }

    }

public static function validateLengthInArray($texts, $minLength, $maxLength, $message) {
    foreach ($texts as $text) {
        $length = strlen($text);
        if ($length < $minLength || $length > $maxLength) {
            return array('success' => false, 'message' => $message . ': ' . $text);
        }
    }
    return true; // Todos los textos en el array cumplen con la longitud requerida
}

public static function validateLettersAndNumbers($text, $message) {
    $text2 = str_replace(" ", "", $text);
    if (preg_match("/^[\p{L}0-9\s]+$/u", $text2) === 1) {
        return true;
    } else {
        $response = array('success' => false, 'message' => $message . ': '. $text);
        return $response;
    }
}


public static function validateVariables($variables) {

    foreach ($variables as $var) {
        if (!isset($var) || empty($var)) {
            return false;
            break;
        } 
    }
    return true;
}

public static function validatePhoneNumber($phoneNumber, $message) {
    // Eliminar todos los caracteres no numéricos del número de teléfono
    $phoneNumber = preg_replace('/\D/', '', $phoneNumber);
    
    // Verificar si el número de teléfono tiene exactamente 10 dígitos
    if (strlen($phoneNumber) === 10) {
        return true; // El número de teléfono es válido
    } else {
        return array('success' => false, 'message' => $message . ': ' . $phoneNumber);
    }
}


public static function validateEmail($email, $message) {

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
       // $validacion = true;
            return true;
    } else {

       return  $response = array('success' => false, 'message' => $message. ' :' . $email);
    }

}



  public static function validateFormatPassword($password, $min, $max, $message) {

    $validLength = strlen($password) >= $min;
    $validLength2 = strlen($password) <= $max;
    $hasLowerCase = preg_match('/[a-z]/', $password);
    $hasUpperCase = preg_match('/[A-Z]/', $password);
    $hasDigit = preg_match('/\d/', $password);
    $hasSpecialChar = preg_match('/[^\w\s]|[\p{P}]/u', $password);
    
    if ($validLength2 && $validLength && $hasLowerCase && $hasUpperCase && $hasDigit && $hasSpecialChar) {

       // $validacion = true;
        return true;
    } else {
     return   $response = array('success' => false, 'message' => $message);
    }
}

public static function compareStrings($string1, $string2, $message) {

    if ($string1 == $string2) {
       // $validacion = true;
            return true;
    } else {
      return  $response = array('success' => false, 'message' => $message);
    }
}

public static function validateDateForMySQL($date, $message) {
    $dateObj = DateTime::createFromFormat('Y-m-d', $date);

    if ($dateObj && $dateObj->format('Y-m-d') === $date) {
        return true;
    } else {
        $response = array('success' => false, 'message' => $message . ': ' . $date);
        return $response;
    }
}


}