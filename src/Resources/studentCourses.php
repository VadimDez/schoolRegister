<?php
/**
 * Created by JetBrains PhpStorm.
 * User: vadimdez
 * Date: 4/14/13
 * Time: 12:40 AM
 * To change this template use File | Settings | File Templates.
 */


namespace Resources;

use Tonic\Response, Tonic\Resource;

// le classi per il tasto 'Studente-Corso'
/**
 * @uri /studentcourses
 */
class studentcourses extends Resource
{

    /**
     * @method GET
     * @provides text/html
     */
    function init()
    {
    	// stampo l'elenco delle classi presenti nel database
        $sql    = "SELECT cl.idClasse, Classe, Sezione FROM FrequentanoClassi as f, Classi as cl WHERE f.idClasse=cl.idClasse GROUP BY idClasse";
        $stmt   = $this->container["conn"]->query($sql);

        // converto
        $converter = new \converter();
        $data = $converter->convert($stmt); // contiene array
        $this->container["twig"]->addGlobal("link","studentcourses");
        $page = $this->container["twig"]->render('selectClass.html', $data);

        return new Response(Response::OK, $page, array(
            'content-type' => 'text/html'
        ));
    }
}


/**
 * @uri /studentcourses/:idClass
 */
class studentList extends Resource
{

    /**
     * @method GET
     * @provides text/html
     */
    function init($idClass)
    {
        $sql = "SELECT * FROM  FrequentanoClassi AS f, Studenti AS s WHERE s.matricola = f.matricola AND f.idClasse ='$idClass'";
        $stmt= $this->container["conn"]->query($sql);

        // converto
        $converter = new \converter();
        $data = $converter->convert($stmt); // contiene array

        $this->container["twig"]->addGlobal("link","studentcourses/$idClass");

        $page = $this->container["twig"]->render('selectStudent.html', $data);

        return new Response(Response::OK, $page, array(
            'content-type' => 'text/html'
        ));
    }
}
/**
 * @uri /studentcourses/:idClass/:idStudente
 */
class studentCoursesList extends Resource
{

    /**
     * @method GET
     * @provides text/html
     */
    function init($idClass,$idStudente)
    {
        $sql = "SELECT cl.idCorso,nome,cognome,titolo,tipologia, monteOre, annoScolastico FROM FrequentanoCorsi as f,Studenti as s, Corsi as cl WHERE s.matricola='$idStudente' AND f.matricola=s.matricola AND f.idCorso=cl.idCorso";
        $stmt= $this->container["conn"]->query($sql);

        // converto
        $converter = new \converter();
        $data = $converter->convert($stmt); // contiene array

        $page = $this->container["twig"]->render('studentCoursesList.html', $data);

        return new Response(Response::OK, $page, array(
            'content-type' => 'text/html'
        ));
    }
}