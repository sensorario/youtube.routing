<?php

class RouterTest extends PHPUnit\Framework\TestCase
{
    private Router $router;

    private Request $request;

    public function setUp(): void
    {
        $this->router = new Router();
    }

    /** @test */
    public function shouldNeverLookForMethodAndPathWheneverIsEmpty()
    {
        $this->request = $this
            ->getMockBuilder(Request::class)
            ->getMock();
        $this->request->expects($this->never())
            ->method('getPath');
        $this->request->expects($this->never())
            ->method('getMethod');

        $result = $this->router->match($this->request);
        $this->assertSame(false, $result);
    }

    /** @test */
    public function shouldMatchGetRequestIfStoredInTheRouter()
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

        $this->router->add('GET', '/', HomeController::class);

        $result = $this->router->match($this->request);
        $this->assertSame(true, $result);
    }

    /** @test */
    public function shouldReturnControllerAfterGivenSuccessfulMatch()
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

        $this->router->add('GET', '/', HomeController::class);

        $this->router->match($this->request);

        $this->assertSame(HomeController::class, $this->router->controller());
        $this->assertSame('get', $this->router->action());
    }
}
