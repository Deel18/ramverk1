<?php

namespace Anax\Ip;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A sample controller to show how a controller class can be implemented.
 * The controller will be injected with $di if implementing the interface
 * ContainerInjectableInterface, like this sample class does.
 * The controller is mounted on a particular route and can then handle all
 * requests for that mount point.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class IpController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;


    public function indexAction() : object
    {
        $title = "IP";

        $page = $this->di->get("page");
        $session = $this->di->session;

        $res = $session->get("res", null);
        $ipv = $session->get("ip", null);

        $session->set("res", null);
        $session->set("ip", null);

        $data = [
            "res" => $res,
            "ip" => $ipv,
        ];

        $page->add("ip/verify", $data);

        return $page->render([
            "title" => $title,
        ]);
    }

    public function indexActionPost()
    {
        $request = $this->di->request;
        $response = $this->di->response;
        $session = $this->di->session;

        $doVerify = $request->getPost("verify", null);
        $address = $request->getPost("ip", null);
        $check = new IPChecker();

        if ($doVerify) {
             $result = $check->checkIpv($address);

            $session->set("res", $result);
            $session->set("ip", $address);
        }

        if ($doVerify) {
            $res = $check->checkIpv($address);


            $session->set("res", $res);
            $session->set("ip", $address);
        }
        return $response->redirect("deel");
    }
}
