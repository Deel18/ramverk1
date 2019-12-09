<?php

namespace Anax\Ip;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A sample JSON controller to show how a controller class can be implemented.
 * The controller will be injected with $di if implementing the interface
 * ContainerInjectableInterface, like this sample class does.
 * The controller is mounted on a particular route and can then handle all
 * requests for that mount point.
 */
class JipController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;




    /**
     * This is the index method action, it handles:
     * GET METHOD mountpoint
     * GET METHOD mountpoint/
     * GET METHOD mountpoint/index
     *
     * @return array
     */
    public function indexAction() : object
    {
        $title = "IP";

        $page = $this->di->get("page");

        $page->add("json/verify");

        return $page->render([
            "title" => $title,
        ]);
    }



    /**
     * This sample method dumps the content of $di.
     * GET mountpoint/dump-app
     *
     * @return array
     */
    public function verifyActionGet()
    {
        $ipv = $this->di->request->getGet("ip");

        $valid = (filter_var($ipv, FILTER_VALIDATE_IP)) ? "true" :  "false";

        $host = gethostbyaddr($ipv);

        $result = $valid ? "IP is valid." : "IP is not valid.";

        $data = [
            "ip" => $ipv,
            "result" => $result,
            "host" => $host,
        ];

        return [$data];
    }
}
