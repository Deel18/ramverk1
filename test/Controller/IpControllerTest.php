<?php

namespace Deel\Controller;

use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;

/**
 * Test the SampleController.
 */
class IpControllerTest extends TestCase
{
    /**
     * Test the route "index".
     */
    public function testIndexAction()
    {
        global $di;

        //Setup di
        $di = new DIFactoryConfig();
        $di->loadServices(ANAX_INSTALL_PATH . "/config/di");

        //use different cache for unit tests
        $di->get("cache")->setPath(ANAX_INSTALL_PATH . "/test/cache");

        //setup the controller
        $controller = new IpController();
        $controller->setDi($di);

        $di->get("session")->set("ip", null);
        $di->get("session")->set("res", null);

        $res = $controller->indexAction();
        $this->assertIsObject($res);
        $this->assertInstanceOf("Anax\Response\Response", $res);
        $this->assertInstanceOf("Anax\Response\ResponseUtility", $res);
    }


    /**
     * Test the route "info".
     */
    public function testIndexActionPost()
    {
        global $di;

        //Setup di
        $di = new DIFactoryConfig();
        $di->loadServices(ANAX_INSTALL_PATH . "/config/di");

        //use different cache for unit tests
        $di->get("cache")->setPath(ANAX_INSTALL_PATH . "/test/cache");

        //setup the controller
        $controller = new IpController();
        $controller->setDi($di);


        $response = $di->get("response");
        $request = $di->get("request");
        $session = $di->get("session");

        //Ipv4 test
        $request->setPost("ip", "19.117.63.126");
        $request->setPost("ipv4", "ipv4");
        $request->setPost("verify", "Verify");

        $session->set("res", null);
        $session->set("ip", null);

        $res = $controller->indexActionPost();
        $this->assertIsObject($res);
        $response->redirectSelf();
        $this->assertInstanceOf("Anax\Response\Response", $res);
        $this->assertInstanceOf("Anax\Response\ResponseUtility", $res);

        //Ipv6 test
        $request->setPost("ip", "2001:db8:0:1234:0:567:8:1");
        $request->setPost("ipv6", "ipv6");
        $request->setPost("verify", "Verify");

        $session->set("res", null);
        $session->set("ip", null);

        $res = $controller->indexActionPost();
        $this->assertIsObject($res);
        $response->redirectSelf();
        $this->assertInstanceOf("Anax\Response\Response", $res);
        $this->assertInstanceOf("Anax\Response\ResponseUtility", $res);

        //Ipv6 fail test
        $request->setPost("ip", "2001:db8:");
        $request->setPost("ipv6", "ipv6");
        $request->setPost("verify", "Verify");

        $session->set("res", null);
        $session->set("ip", null);

        $res = $controller->indexActionPost();
        $this->assertIsObject($res);
        $response->redirectSelf();
        $this->assertInstanceOf("Anax\Response\Response", $res);
        $this->assertInstanceOf("Anax\Response\ResponseUtility", $res);
    }
}
