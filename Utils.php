<?php

class Utils{

    static function prepareArrayOfObjectsNames($objects){
        foreach($objects as $objName=>$obj){
            $objNames[] = $objName;
        }

        return $objNames;
    }
}