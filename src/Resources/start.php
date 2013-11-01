<?php
/**
 * Created by JetBrains PhpStorm.
 * User: vadimdez
 * Date: 4/11/13
 * Time: 8:49 PM
 * To change this template use File | Settings | File Templates.
 */

namespace Resources;

use Tonic\Response, Tonic\Resource;

/**
 * @uri /
 */
class start extends Resource
{

    /**
     * @method GET
     * @provides text/html
     */
    function init()
    {

        $page = $this->container["twig"]->render('start.html');

        return new Response(Response::OK, $page, array(
            'content-type' => 'text/html'
        ));
    }
}

?>