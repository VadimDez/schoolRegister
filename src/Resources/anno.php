<?php
/**
 * Created by JetBrains PhpStorm.
 * User: vadimdez / marcoPretelli
 * Date: 4/14/13
 * Time: 5:55 PM
 * To change this template use File | Settings | File Templates.
 */


namespace Resources;

use Tonic\Response, Tonic\Resource;

/**
 * @uri /anno
 */
class anno extends Resource
{

    /**
     * @method GET
     * @provides text/html
     */
    function init()
    {
        // query per ottenere la lista degli anni scolastici
        $sql = "SELECT DISTINCT annoScolastico FROM corsi";
        $stmt = $this->container["conn"]->query($sql);

        // converto
        $converter = new \converter();
        $data = $converter->convert($stmt); // contiene array

        $page = $this->container["twig"]->render('selectYear.html',$data);

        return new Response(Response::OK, $page, array(
            'content-type' => 'text/html'
        ));
    }
}

/**
 * @uri /anno/:yearStart/:yearEnd
 */
class anni extends Resource
{

    /**
     * @method GET
     * @provides text/html
     */
    function init($yearStart,$yearEnd)
    {
        $anno = $yearStart . '/' . $yearEnd;
        // query per ottenere la lista dei corsi appartenenti all'anno scolastico passato
        $sql = "SELECT * FROM Corsi WHERE annoScolastico='$anno' AND documentazione=''";
        $stmt = $this->container["conn"]->query($sql);

        // converto
        $converter = new \converter();
        $data = $converter->convert($stmt); // contiene array

        $page = $this->container["twig"]->render('courses.html',$data);

        return new Response(Response::OK, $page, array(
            'content-type' => 'text/html'
        ));
    }
}


/**
 * @uri /anno/:idCourse
 */
class students extends Resource
{

    /**
     * @method GET
     * @provides text/html
     */
    function init($idCourse)
    {
        // query per ottenere la lista dei corsi appartenenti all'anno scolastico passato
        $sql = "SELECT * FROM FrequentanoCorsi as f, Studenti as s WHERE f.idCorso='$idCourse' AND f.matricola=s.matricola";
        $stmt = $this->container["conn"]->query($sql);

        // converto
        $converter = new \converter();
        $data = $converter->convert($stmt); // contiene array

        $page = $this->container["twig"]->render('selectStudent.html',$data);

        return new Response(Response::OK, $page, array(
            'content-type' => 'text/html'
        ));
    }
}
?>