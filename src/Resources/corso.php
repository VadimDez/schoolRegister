<?php
/**
 * Created by JetBrains PhpStorm.
 * User: vadimdez
 * Date: 4/11/13
 * Time: 10:09 PM
 * To change this template use File | Settings | File Templates.
 */

namespace Resources;

use Tonic\Response, Tonic\Resource;

/**
 * @uri /corso
 */
class corsi extends Resource
{

    /**
     * @method GET
     * @provides text/html
     */
    function init()
    {
        // query per ottenere la lista dei corsi
        $sql = "SELECT idCorso, titolo FROM Corsi";
        $stmt = $this->container["conn"]->query($sql);

        // converto
        $converter = new \converter();
        $data = $converter->convert($stmt); // contiene array

        $page = $this->container["twig"]->render('corso.html',$data);

        return new Response(Response::OK, $page, array(
            'content-type' => 'text/html'
        ));
    }
}

/**
 * @uri /corso/:id
 */
class corso extends Resource
{

    /**
     * @method GET
     * @provides text/html
     */
    function init($id)
    {
        // passando id del corso eseguo la query per ottenere info su un corso preciso
        $sql = "SELECT * FROM Corsi WHERE idCorso = '$id'";
        $stmt = $this->container["conn"]->query($sql);

        $converter = new \converter();
        $data = $converter->convert($stmt);

        $page = $this->container["twig"]->render('infoCorso.html', $data);

        return new Response(Response::OK, $page, array(
            'content-type' => 'text/html'
        ));
    }
}

?>