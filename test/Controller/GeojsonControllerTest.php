<?php

namespace Anax\Ip;

use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;

/**
 * Test the SampleController.
 */
class GeojsonControllerTest extends TestCase
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
        $controller = new GeojsonController();
        $controller->setDi($di);

        $res = $controller->indexAction();

        $this->assertInstanceOf("Anax\Response\Response", $res);
        $this->assertInstanceOf("Anax\Response\ResponseUtility", $res);
    }



    /**
     * Test the route "info".
     */
    public function testgeotagjsonActionGet()
    {
        global $di;

        //Setup di
        $di = new DIFactoryConfig();
        $di->loadServices(ANAX_INSTALL_PATH . "/config/di");

        //use different cache for unit tests
        $di->get("cache")->setPath(ANAX_INSTALL_PATH . "/test/cache");

        //setup the controller
        $controller = new GeojsonController();
        $controller->setDi($di);

        $request = $di->get("request");

        $request->setGet("ip", "194.47.129.126");
        $res = $controller->geotagjsonActionGet();
        $this->assertIsArray($res);

        $this->assertArrayHasKey("result", $res[0]);
    }
}
