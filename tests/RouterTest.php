<?php

class RoutingTest extends PHPUnit\Framework\TestCase
{
    private Request $request;

    private Controller $controller;

    /** @test */
    public function shouldReturnNoRouteWheneverNotYetConfigured()
    {
        $this->request = $this
            ->getMockBuilder(Request::class)
            ->getMock();

        $router = new Router();
        $response = $router->match($this->request);
        $this->assertSame(false, $response);
    }

    /** @test */
    public function shouldNeverMatchWithWrongMethod()
    {
        $this->request = $this
            ->getMockBuilder(Request::class)
            ->getMock();
        $this->request->expects($this->once())
            ->method('getPath')
            ->willReturn('/');
        $this->request->expects($this->once())
            ->method('getMethod')
            ->willReturn('POST');

        $router = new Router();
        $router->add('/', Controller::class);
        $response = $router->match($this->request);        
        $this->assertSame(false, $response);
    }

    /** @test */
    public function shouldCheckRequestPathWheneverSomeRoutesExists()
    {
        $this->request = $this
            ->getMockBuilder(Request::class)
            ->getMock();
        $this->request->expects($this->once())
            ->method('getPath')
            ->willReturn('/');
        $this->request->expects($this->once())
            ->method('getMethod')
            ->willReturn('GET');

        $router = new Router();
        $router->add('/', Controller::class);
        $response = $router->match($this->request);        
        $this->assertSame(true, $response);
    }

    /** @test */
    public function shouldAddRouteWithoutDefaultHttpMethod()
    {
        $this->request = $this
            ->getMockBuilder(Request::class)
            ->getMock();
        $this->request->expects($this->once())
            ->method('getPath')
            ->willReturn('/');
        $this->request->expects($this->once())
            ->method('getMethod')
            ->willReturn('POST');

        $router = new Router();
        $router->add('/', Controller::class, 'POST');
        $response = $router->match($this->request);        
        $this->assertSame(true, $response);
    }

    /** @test */
    public function shouldReturnControllerAndActionOfAGivenRoute()
    {
        $this->request = $this
            ->getMockBuilder(Request::class)
            ->getMock();
        $this->request->expects($this->once())
            ->method('getPath')
            ->willReturn('/');

        $router = new Router();
        $router->add('/', Controller::class);
        $router->match($this->request);        
        $this->assertSame(Controller::class, $router->controller());
        $this->assertSame('GET', $router->action());
    }

    /** @test */
    public function shouldTakeActionFromNonDefaultValue()
    {
        $this->request = $this
            ->getMockBuilder(Request::class)
            ->getMock();
        $this->request->expects($this->once())
            ->method('getPath')
            ->willReturn('/');
        $this->request->expects($this->once())
            ->method('getMethod')
            ->willReturn('POST');

        $router = new Router();
        $router->add('/', Controller::class, 'POST');
        $router->match($this->request);        
        $this->assertSame(Controller::class, $router->controller());
        $this->assertSame('POST', $router->action());
    }
}