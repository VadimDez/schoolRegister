<?php
/**
 * Created by JetBrains PhpStorm.
 * User: vadimdez
 * Date: 4/13/13
 * Time: 5:24 PM
 * To change this template use File | Settings | File Templates.
 */

class converter
{
    function convert($array, $name = 'data')
    {
        // funzione che prende in input fetch array e lo trasforma in array utilizzabile in twig
        $arr = array();

        while ($row = $array->fetch())
        {
            array_push($arr, $row);
        }

        $arr = array($name => $arr);
        return $arr;
    }
}

?>