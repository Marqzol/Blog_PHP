<?php

    function getResult($array, $count = 0){
        $result = array();
        switch ($count){
            case 1:
                foreach ($array as $row){
                    array_push($result, $row[0]);
                }
                return $result[0];
                break;
            default:
                foreach ($array as $key=>$value){
                    array_push($result, $value);
                }
                return $result;
                break;
        }
    }


?>
