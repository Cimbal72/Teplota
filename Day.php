<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Day
 *
 * @author HP
 */
class Day {
    
    public function setDate($date){
        $this->date = $date;   
    }
    
    public function setHigh($high){
        $this->high = $high;
    }
    
    public function setLow($low){
        $this->low = $low;
    }
    
    public function setId($id){
        $this->id = $id;
    }
    
    public function setDateInst($dateInst){
        $this->dateInst = $dateInst;
    }
    
    public function setDateForm($dateForm){
        $this->dateForm = $dateForm;
    }
    
    public function setAvTemp($avTemp){
        $this->avTemp = $avTemp;
    }
    
    public function getDate(){
        return $this->date;   
    }
    
    public function getHigh(){
        return $this->high;
    }
    
    public function getLow(){
        return $this->low;
    }
    
    public function getId($id){
        return $this->id;
    }
    
    public function getDateInst(){
        return $this->dateInst;
    }
    
    public function getAvTemp(){
        return $this->avTemp;
    }
    
    public function getDateForm(){
        return $this->dateForm;
    }
}
