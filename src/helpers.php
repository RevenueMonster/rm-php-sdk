<?php

if (! class_exists(RevenueMonster::class)) {

    if (! function_exists('array_ksort')) {
        function array_ksort(&$array)
        {
            if (count($array) > 0) {
                foreach ($array as $k => $v) {
                    if (is_array($v)) {
                        $array[$k] = array_ksort($v);
                    } 
                }

                ksort($array);
            }
            return $array;
        }
    }

    if (! function_exists('random_str')) {
        function random_str($length = 8, $type = 'alphanum')
        {
            switch($type)
            {
                case 'basic'    : return mt_rand();
                    break;
                case 'alpha'    :
                case 'alphanum' :
                case 'num'      :
                case 'nozero'   :
                        $seedings             = array();
                        $seedings['alpha']    = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                        $seedings['alphanum'] = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                        $seedings['num']      = '0123456789';
                        $seedings['nozero']   = '123456789';
                        
                        $pool = $seedings[$type];
                        
                        $str = '';
                        for ($i=0; $i < $length; $i++)
                        {
                            $str .= substr($pool, mt_rand(0, strlen($pool) -1), 1);
                        }
                        return $str;
                    break;
                case 'unique'   :
                case 'md5'      :
                            return md5(uniqid(mt_rand()));
                    break;
            }
        }
    }

}

?>