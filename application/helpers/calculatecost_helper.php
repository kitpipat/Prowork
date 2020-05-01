<?php
  
    function FCNtCOSCalCost($paPdtInfo){

             $nStdCost =    $paPdtInfo['nStdCost'];
             $tDisCost =    $paPdtInfo['tDisCost'];
             if($tDisCost !='' or $tDisCost !=0){

                $tDisCost = str_replace("%","%",$tDisCost);
                $aDisCost = explode(",",$tDisCost);
                var_dump($aDisCost);

             }else{

                return $nStdCost;

             }

    }

?>
