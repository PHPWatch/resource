<?php

namespace Resource\Tests\Curl;

use ReflectionClass;
use Resource\Curl\CurlHandle;
use PHPUnit\Framework\TestCase;

class CurlHandleTest extends TestCase
{
    /**
     * Instance of cURL handle.
     *
     * @var \Resource\Curl\CurlHandle
     */
    protected $curl;

    protected function setUp(): void
    {
        $this->setOutputCallback(fn () => null);
    }

    protected function tearDown(): void
    {
        $this->curl->close();
    }

    public function testCanBeIntantiated()
    {
        $this->curl = new CurlHandle();

        $this->assertInstanceOf(CurlHandle::class, $this->curl);
    }

    public function testHandlerInitialization()
    {
        $this->curl = CurlHandle::init('https://www.example.com');

        $curlReflection = new ReflectionClass($this->curl);
        $resource = $curlReflection->getProperty('resource');
        $resource->setAccessible(true);

        $this->assertIsResource($resource->getValue($this->curl));
    }

    public function testHandlerCanBeExecuted()
    {
        $this->curl = CurlHandle::init('https://www.example.com');

        $this->assertIsBool($this->curl->exec());
    }

    public function testCanCopyHandle()
    {
        $this->curl = CurlHandle::init('https://www.example.com');

        $copy = $this->curl->copyHandle();

        $this->assertInstanceOf(CurlHandle::class, $copy);
        $this->assertEquals(gettype($this->curl), gettype($copy));
    }

    public function testGetsInfoOnTransfer()
    {
        $this->curl = CurlHandle::init('https://www.example.com');

        $this->curl->exec();

        $this->assertequals(200, $this->curl->getinfo(CURLINFO_RESPONSE_CODE));
    }
}
