<?php
/**
 * Created by JetBrains PhpStorm.
 * User: vadimdez
 * Date: 4/13/13
 * Time: 9:48 PM
 * To change this template use File | Settings | File Templates.
 */

namespace Resources;

use Tonic\Response, Tonic\Resource;

// le classi per il tasto 'Info Studente'
/**
 * @uri /classes
 */
class classes extends Resource
{
    /**
     * @method GET
     * @provides text/html
     */
    function init()
    {
        // query per ottenere la lista lelle classi
        $sql    = "SELECT cl.idClasse, Classe, Sezione FROM FrequentanoClassi as f, Classi as cl WHERE f.idClasse=cl.idClasse Group BY idClasse";
        $stmt   = $this->container["conn"]->query($sql);

        // converto
        $converter = new \converter();
        $data = $converter->convert($stmt); // contiene array

        $this->container["twig"]->addGlobal("link","classes"); //serve per riutilizzare html "selectClass"

        $page = $this->container["twig"]->render('selectClass.html', $data);

        return new Response(Response::OK, $page, array(
            'content-type' => 'text/html'
        ));
    }
}

/**
 * @uri /classes/:idClass
 */
class student extends Resource
{
    /**
    * @method GET
    * @provides text/html
    */
    function init($idClass)
    {
        // query per ottenere la lista dei corsi
        $sql = "SELECT s.matricola, nome, cognome, dataNascita FROM Studenti as s, FrequentanoClassi as fc WHERE s.matricola=fc.matricola AND fc.idClasse='$idClass'";
        $stmt = $this->container["conn"]->query($sql);

        // converto
        $converter = new \converter();
        $data = $converter->convert($stmt); // contiene array

        $this->container["twig"]->addGlobal("link","students"); // serve per riutilizzare html "selectStudente"

        $page = $this->container["twig"]->render('selectStudent.html',$data);

        return new Response(Response::OK, $page, array(
            'content-type' => 'text/html'
        ));
    }
}

/**
 * @uri /students/:idStudente
 */
class studentsInfo extends Resource
{
    /**
     * @method GET
     * @provides text/html
     */
    function init($idStudente)
    {

        // query per ottenere la lista dei corsi
        $sql = "SELECT nome, cognome, cl.idClasse ,classe, sezione, annoScolastico, esito FROM FrequentanoClassi as fc, Classi as cl, Studenti as S WHERE fc.matricola = '$idStudente' AND fc.idClasse = cl.idClasse AND s.matricola= fc.matricola";
        $stmt = $this->container["conn"]->query($sql);

        // converto
        $converter = new \converter();
        $data2 = $converter->convert($stmt, "row"); // contiene array




        $page = $this->container["twig"]->render('infoStudent.html',$data2);

        return new Response(Response::OK, $page, array(
            'content-type' => 'text/html'
        ));
    }
}

?>