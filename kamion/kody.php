<?php
if (isset($_GET["verze"])&&isset($_GET["hodnota"])) {
    if ($_GET["verze"]==1) {
        $kemler_kody_str=file_get_contents("kemler_kody.json");
        $kemler_kody=json_decode($kemler_kody_str, true);
                            
        if (isset($kemler_kody[$_GET["hodnota"]])) {
            echo $kemler_kody[$_GET["hodnota"]];
        }
        else if (strlen($_GET["hodnota"])>1) {
            echo vygenerujPopis($_GET["hodnota"]);
        }
    }
    else {
        $un_kody_str=file_get_contents("un_kody.json");
        $un_kody=json_decode($un_kody_str, true);
        
        if (isset($un_kody[$_GET["hodnota"]])) {
            echo $un_kody[$_GET["hodnota"]];
        }               
    }
}  

function vygenerujPopis($kod) {  
    $poleHodnot=array();
    
    $poleHodnot["X"]=($kod[0]=="X")? 1:0;
    
    for ($i=2;$i<10;$i++) {
        $poleHodnot[$i]=substr_count($kod, $i);
        
        if ($poleHodnot[$i]>3) {
            $poleHodnot[$i]=3;
        }             
    }
    
    if ($poleHodnot[2]>0) {
        $popis="plynná látka";
        
        if ($poleHodnot[2]>1) {
            $popis="dusivá ".$popis;
        }
        
        if ($poleHodnot[3]>0) {
            $popis="hořlavá ".$popis;
        }
    }
    else if ($poleHodnot[3]>0) {
        $popis="hořlavá kapalná látka";
        
        if ($poleHodnot[3]==2) {
            $popis="velmi ".$popis;
        }
        else if ($poleHodnot[3]==3) {
            $popis="extrémně ".$popis;
        }
    }
    else if ($poleHodnot[4]>0) {
        $popis="hořlavá pevná látka";
        
        if ($poleHodnot[4]==2) {
            $popis="velmi ".$popis;
        }
        else if ($poleHodnot[4]==3) {
            $popis="extrémně ".$popis;
        }
    }
    else {
        $popis="látka";
    }
    
    if ($poleHodnot[5]>0) {
        if ($poleHodnot[5]==1) {
            $popis.=", podporující hoření";
        }
        else if ($poleHodnot[5]==2) {
            $popis.=", vznětlivá";
        }
        else if ($poleHodnot[5]==3) {
            $popis.=", velmi vznětlivá";
        }
    }
    
    if ($poleHodnot[6]>0) {
        if ($poleHodnot[6]==1) {
            $popis.=", jedovatá";
        }
        else if ($poleHodnot[6]==2) {
            $popis.=", silně jedovatá";
        }
        else if ($poleHodnot[6]==3) {
            $popis.=", prudce jedovatá";
        }
    }
    
    if ($poleHodnot[7]>0) {
        if ($poleHodnot[7]==1) {
            $popis.=", radioaktivní";
        }
        else if ($poleHodnot[7]>1) {
            $popis.=", velmi radioaktivní";
        }
    }
    
    if ($poleHodnot[8]>0) {
        if ($poleHodnot[8]==1) {
            $popis.=", žíravá";
        }
        else if ($poleHodnot[8]==2) {
            $popis.=", velmi žíravá";
        }
        else if ($poleHodnot[8]==3) {
            $popis.=", extrémně žíravá";
        }
    }
    
    if ($poleHodnot[9]>0) {
        if ($poleHodnot[9]==1) {
            $popis="nebezpečná ".$popis;
        }
        else if ($poleHodnot[9]==2) {
            $popis="velmi nebezpečná ".$popis;
        }
        else if ($poleHodnot[9]==3) {
            $popis="extrémně nebezpečná ".$popis;
        }
    }
    
    if ($poleHodnot["X"]==1) {
        $popis.=", reagující nebezpečně s vodou";
    }    
    
    return $popis;
}          
?>