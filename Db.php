<?php


class Db {
    private static $spojeni;
    
    private static $nastaveni = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
        //PDO::ATTR_EMULATE_PREPARES => false,
);
    
    public static function pripoj($host, $uzivatel, $heslo, $databaze)
{
        if (!isset(self::$spojeni))
        {
                self::$spojeni = @new PDO(
                        "mysql:host=$host;dbname=$databaze",
                        $uzivatel,
                        $heslo,
                        self::$nastaveni
                );
        }
        
}

public static function dotazJeden($dotaz, $parametry = array())
{
        $navrat = self::$spojeni->prepare($dotaz);
        $navrat->execute($parametry);
        return $navrat->fetch();
}

public static function dotazVsechny($dotaz, $parametry = array())
{
        $navrat = self::$spojeni->prepare($dotaz);
        $navrat->execute($parametry);
        return $navrat->fetchAll();
}

public static function dotaz($sql, $parametry = array())
    {
        $dotaz = self::$spojeni->prepare($sql);
        $dotaz->execute($parametry);
        
    }
    
public static function zmen($tabulka, $udaje, $podminka, $parametry){
        return self::dotaz("UPDATE `$tabulka`SET `".implode('` = ?, `', array_keys($udaje)).
                "` = ? " . $podminka, array_merge(array_values($udaje),$parametry)
 );
    }
    
public static function uloz($tabulka, $udaje){
        
        Db::dotaz(
                "INSERT INTO `$tabulka` (`".
                implode('`, `', array_keys($udaje)).
                "`) VALUES (".str_repeat('?,', sizeOf($udaje)-1)."?)",
                        array_values($udaje));

             
    }
//Načtte data odpovídající podmínce $podminka z tabulky $tabulka  
public static function vypisJeden($tabulka, $udaje, $podminka, $parametry){
    
        $clanek = Db::dotazJeden(
                 "SELECT`".implode("`,`",(array_values($udaje)))."`FROM `".$tabulka.$podminka."`".implode(',',array_keys($parametry)).
                "` = ?"
                ,array_values($parametry));   /*`titulek`,`obsah`,`datum` FROM `clanky` WHERE `url`= */
                return $clanek;

      
    }
    
public static function vratPocet($tabulka, $podminka="", $udaje = array()){
    
        return Db::dotazJeden(
                  "SELECT COUNT(*) from `$tabulka` $podminka"
                     ,$udaje);
}



}
