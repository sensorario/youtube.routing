<?php

class RoutingTest extends PHPUnit\Framework\TestCase
{
    private Request $request;

    private Controller $controller;

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
        $router->add('/', Controller::class, 'GET');
        $response = $router->match($this->request);        
        $this->assertSame(false, $response);
    }

    /** @test */
    public function shouldReturnNoRouteWheneverNotYetConfigured()
    {
        $this->request = $this
            ->getMockBuilder(Request::class)
            ->getMock();
        $this->request->expects($this->never())
            ->method('getPath');
        $this->request->expects($this->never())
            ->method('getMethod');

        $router = new Router();
        $response = $router->match($this->request);
        $this->assertSame(false, $response);
    }

    /** @test */
    public function shouldStoreGetRouteWhenMethodIsOmitted()
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
    public function shouldReturnControllerOfAGivenRoute()
    {
        $this->request = $this
            ->getMockBuilder(Request::class)
            ->getMock();
        $this->request->expects($this->exactly(2))
            ->method('getPath')
            ->willReturn('/');
        $this->request->expects($this->exactly(2))
            ->method('getMethod')
            ->willReturn('GET');

        $router = new Router();
        $router->add('/', FirstController::class);
        $router->add('/foo', SecondController::class);
        $router->match($this->request);        
        $this->assertSame(FirstController::class, $router->controller());
    }

    /** @test */
    public function shouldReturnActionOfAGivenRoute()
    {
        $this->request = $this
            ->getMockBuilder(Request::class)
            ->getMock();
        $this->request->expects($this->exactly(1))
            ->method('getPath')
            ->willReturn('/');
        $this->request->expects($this->exactly(2))
            ->method('getMethod')
            ->willReturn('GET');

        $router = new Router();
        $router->add('/', Controller::class);
        $router->match($this->request);        
        $this->assertSame('GET', $router->action());
    }

    /** @test */
    public function shouldTakeActionFromNonDefaultValue()
    {
        $this->request = $this
            ->getMockBuilder(Request::class)
            ->getMock();
        $this->request->expects($this->exactly(2))
            ->method('getPath')
            ->willReturn('/');
        $this->request->expects($this->exactly(3))
            ->method('getMethod')
            ->willReturn('POST');

        $router = new Router();
        $router->add('/', Controller::class, 'POST');
        $router->match($this->request);        
        $this->assertSame(Controller::class, $router->controller());
        $this->assertSame('POST', $router->action());
    }
}
