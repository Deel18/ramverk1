<?php

namespace Anax\Ip;

use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;

/**
 * Test the SampleController.
 */
class GeotagControllerTest extends TestCase
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
        $controller = new GeotagController();
        $controller->setDi($di);

        $di->get("session")->set("ip", null);
        $di->get("session")->set("res", null);
        $di->get("session")->set("country_name", null);
        $di->get("session")->set("city", null);
        $di->get("session")->set("longitude", null);
        $di->get("session")->set("latitude", null);
        $di->get("session")->set("type", null);

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
        $controller = new GeotagController();
        $controller->setDi($di);


        $response = $di->get("response");
        $request = $di->get("request");
        $session = $di->get("session");

        //Ipv4 test
        $request->setPost("ip", "194.47.129.126");
        $request->setPost("verify", "Verify");

        $session->set("res", null);

        $res = $controller->indexActionPost();
        $this->assertIsObject($res);
        $response->redirectSelf();
        $this->assertInstanceOf("Anax\Response\Response", $res);
        $this->assertInstanceOf("Anax\Response\ResponseUtility", $res);

        //Fail test
        $request->setPost("ip", "test");
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
