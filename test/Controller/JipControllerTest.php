<?php

namespace Anax\Controller;

use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;

/**
 * Test the SampleController.
 */
class JipControllerTest extends TestCase
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
        $controller = new JipController();
        $controller->setDi($di);

        $res = $controller->indexAction();

        $this->assertInstanceOf("Anax\Response\Response", $res);
        $this->assertInstanceOf("Anax\Response\ResponseUtility", $res);
    }



    /**
     * Test the route "info".
     */
    public function testVerifyActionGet()
    {
        global $di;

        //Setup di
        $di = new DIFactoryConfig();
        $di->loadServices(ANAX_INSTALL_PATH . "/config/di");

        //use different cache for unit tests
        $di->get("cache")->setPath(ANAX_INSTALL_PATH . "/test/cache");

        //setup the controller
        $controller = new JipController();
        $controller->setDi($di);

        $request = $di->get("request");

        $request->setGet("ip", "19.117.63.126");
        $res = $controller->verifyActionGet();
        $this->assertIsArray($res);

        $this->assertArrayHasKey("result", $res[0]);

        $request->setGet("ip", "2001:db8:0:1234:0:567:8:1");
        $res = $controller->verifyActionGet();
        $this->assertIsArray($res);
        $this->assertArrayHasKey("result", $res[0]);
    }
}
