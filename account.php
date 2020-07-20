<?php

class account{


    function checkAccountExists($pdo, $u, $p){
        
        $retorno = $pdo->query($pdo, "SELECT * FROM `persona` WHERE Username=" . $u);
        if (count($retorno) == 0){
            return False;
        }
        return True;
    }
}