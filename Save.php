<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Save
 *
 * @author HP
 */
class Save {
    
    public function __construct($phpObj) {
        $this->phpObj=$phpObj;
    }
    
    public function save(){
        foreach ($this->phpObj['query']['results']['channel']['item']['forecast'] as $obj){
            $date = new DateTime($obj['date']);
            
            if (Db::dotazVsechny('SELECT date FROM pocasi_praha WHERE DAY(date) = '.$date->format("d").'
                    AND MONTH(date) = '.$date->format("m").' AND YEAR(date) = '.$date->format("Y"))){
                
                Db::zmen('pocasi_praha', array('high'=>$obj['high'],'low'=>$obj['low']), 
                        'WHERE DAY(date) = ? AND MONTH(date) = ? AND YEAR(date) = ?', 
                        array($date->format("d"),$date->format("m"),$date->format("Y")));
            }
            
            else{
            Db::uloz('pocasi_praha', array('high'=>$obj['high'],'low'=>$obj['low'],'date'=>$date->format("Y-m-d")));
            }
            }
    }
}
