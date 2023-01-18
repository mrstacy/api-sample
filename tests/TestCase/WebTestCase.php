<?php

namespace App\Tests\TestCase;

use Symfony\Component\DependencyInjection\ContainerInterface;

class WebTestCase extends DBIntegrationTestCase
{
    const PROJECT_ROOT = __DIR__ . "/../../";
    const AUTH_HEADER = "x-api-key";

    protected function getTestClient() {
        return static::$kernel->getContainer()->get('test.client');
    }

    public static function getContainer() : ContainerInterface
    {
        return self::$container;
    }

    /**
     * Call protected/private method of a class.
     *
     * @param object &$object    Instantiated object that we will run method on.
     * @param string $methodName Method name to call
     * @param array  $parameters Array of parameters to pass into method.
     *
     * @return mixed Method return.
     */
    public function invokeMethod(&$object, $methodName, array $parameters = array())
    {
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);
        return $method->invokeArgs($object, $parameters);
    }

    protected function getAuthHeaders()
    {
        return [
            'HTTP_' . self::AUTH_HEADER => $_ENV['API_KEY']
        ];
    }

}
