<?php

$GLOBALS['ROOT_DOCUMENT'] = dirname(__FILE__);

function getUri() {
    return explode("?", $_SERVER['REQUEST_URI'])[0];
}

function render(string $path, array $data=[]) : void {
    $APP = CONFIG_DB['app_name'];
    $pathArray = explode('.', $path);
    $file = ucfirst($pathArray[1]).ucfirst(rtrim($pathArray[0],'s')).'.php';
    $folder = ucfirst($pathArray[0]);
    require './'.$APP.'/'.$folder.'/'.$file;
}

function getString(INT $numberWords, string $string) : string {
    $i=0;
    $space = 0;
    while ($space<$numberWords && $i < strlen($string)-1) {
        $i++;
        if ($string[$i] === ' ') {
            $space++;
        }
    }
   $getstring= substr($string, 0, $i+1);
   if ($getstring == $string) {
    return $string;
   }else{
    return $getstring.'.....';
   }
}

function checkNumberInteger($value) : bool {
    $pattern = '/^[0-9]+$/';
    if (preg_match($pattern, $value)) {
        return true;
    }else{
        return false;
    }
}

function createRandomString(INT $string_number) : string {

    $characters = array_merge(range('A', 'Z'), range('a','z'), range(1,9));
    $randomString = '';
    for ($i = 1; $i <= $string_number; $i++) {
        $randomString .= $characters[rand(0, (count($characters)-1))];
    }
    return $randomString;
}
