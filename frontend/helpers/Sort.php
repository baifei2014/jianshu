<?php 
namespace frontend\helpers;

class Sort
{
    public static function sortOtherinfors($oinfors, $uinfors)
    {   
        if(count($oinfors) == 0){
            return $uinfors;
        }else{
            for ($i = 0; $i < count($oinfors); $i++) { 
                for ($j = 0; $j < count($uinfors); $j++) { 
                    if($oinfors[$i]['created_at'] < $uinfors[$j]['updated_at']){
                        $uinfors[$j]['created_at'] = $uinfors[$j]['updated_at'];
                        array_splice($oinfors, $i, 0, [$uinfors[$j]]);
                        array_splice($uinfors, $j, 1);
                    }
                }
            }
            if(count($uinfors) != 0){
                array_splice($oinfors, count($oinfors), 0, $uinfors);
            }
            return $oinfors;
        }
    }
}
