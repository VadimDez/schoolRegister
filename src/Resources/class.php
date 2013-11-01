<?php
/**
 * Created by JetBrains PhpStorm.
 * User: vadimdez
 * Date: 4/12/13
 * Time: 9:03 PM
 * To change this template use File | Settings | File Templates.
 */

namespace Resources;

use Tonic\Response, Tonic\Resource;

// le classi per il tasto 'Classe-Corsi'
/**
 * @uri /class
 */
class classe extends Resource
{

    /**
     * @method GET
     * @provides text/html
     */
    function init()
    {
        $sql    = "SELECT cl.idClasse, Classe, Sezione FROM FrequentanoClassi as f, Classi as cl WHERE f.idClasse=cl.idClasse GROUP BY idClasse";
        $stmt   = $this->container["conn"]->query($sql);

        // converto
        $converter = new \converter();
        $data = $converter->convert($stmt); // contiene array
        $this->container["twig"]->addGlobal("link","class");
        $page = $this->container["twig"]->render('selectClass.html', $data);

        return new Response(Response::OK, $page, array(
            'content-type' => 'text/html'
        ));
    }
}

/**
 * @uri /class/:idClass
 */
class studente extends Resource
{

    /**
     * @method GET
     * @provides text/html
     */
    function init($idClass)
    {
        $sql = "SELECT * FROM FrequentanoClassi as f,studenti as s, FrequentanoCorsi as fc, Corsi WHERE f.matricola=s.matricola AND f.idClasse='$idClass' AND fc.matricola=s.matricola AND fc.idCorso=Corsi.idCorso";
        $stmt= $this->container["conn"]->query($sql);

        // converto
        $converter = new \converter();
        $data = $converter->convert($stmt); // contiene array

        $page = $this->container["twig"]->render('coursesOfClass.html', $data);

        return new Response(Response::OK, $page, array(
            'content-type' => 'text/html'
        ));
    }
}

/**
 * @uri /class/:idClass/:idStudent
 */
class studentsCourses extends Resource
{

    /**
     * @method GET
     * @provides text/html
     */
    function init()
    {

        $page = $this->container["twig"]->render('studentsCourses.html');

        return new Response(Response::OK, $page, array(
            'content-type' => 'text/html'
        ));
    }
}

?>