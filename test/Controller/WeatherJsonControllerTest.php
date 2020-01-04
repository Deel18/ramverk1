<?php

namespace Anax\Weather;

use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;

/**
 * Test the SampleController.
 */
class WeatherJsonControllerTest extends TestCase
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
        $controller = new WeatherJsonController();
        $controller->setDi($di);

        $res = $controller->indexAction();

        $this->assertInstanceOf("Anax\Response\Response", $res);
        $this->assertInstanceOf("Anax\Response\ResponseUtility", $res);
    }



    /**
     * Test the route "info".
     */
    public function testweatherjsonActionGet()
    {
        global $di;

        //Setup di
        $di = new DIFactoryConfig();
        $di->loadServices(ANAX_INSTALL_PATH . "/config/di");

        //use different cache for unit tests
        $di->get("cache")->setPath(ANAX_INSTALL_PATH . "/test/cache");

        //setup the controller
        $controller = new WeatherJsonController();
        $controller->setDi($di);

        $request = $di->get("request");


        #Ip test
        $request->setGet("ip", "194.47.129.126");
        $request->setGet("verify", "Verify");
        $res = $controller->weatherjsonActionGet();
        $this->assertIsArray($res);

        $this->assertArrayHasKey("valid", $res[0]);


        #Coordinates test
        $request->setGet("latitude", "56.160820");
        $request->setGet("longitude", "15.586710");
        $request->setGet("verify", "Verify");
        $res = $controller->weatherjsonActionGet();
        $this->assertIsArray($res);

        $this->assertArrayHasKey("valid", $res[0]);
    }
}
