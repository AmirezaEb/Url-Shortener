<?php

use PHPUnit\Framework\TestCase;
use App\Core\Routing\Route;

class RouteTest extends TestCase
{
    protected function setUp(): void
    {
        // هر بار قبل از شروع تست، لیست روترها را خالی می‌کنیم
        $reflection = new \ReflectionClass(Route::class);
        $routesProperty = $reflection->getProperty('routes');
        $routesProperty->setAccessible(true);
        $routesProperty->setValue([]);
    }

    public function testAddGetRoute()
    {
        Route::get('/home', 'HomeController@index');

        $routes = Route::routers();
        $this->assertCount(1, $routes);
        $this->assertEquals('get', $routes[0]['method']);
        $this->assertEquals('/home', $routes[0]['uri']);
        $this->assertEquals('HomeController@index', $routes[0]['action']);
    }

    public function testAddPostRoute()
    {
        Route::post('/login', 'AuthController@login');

        $routes = Route::routers();
        $this->assertCount(1, $routes);
        $this->assertEquals('post', $routes[0]['method']);
        $this->assertEquals('/login', $routes[0]['uri']);
        $this->assertEquals('AuthController@login', $routes[0]['action']);
    }

    public function testAddPutRoute()
    {
        Route::put('/user/update', 'UserController@update');

        $routes = Route::routers();
        $this->assertCount(1, $routes);
        $this->assertEquals('put', $routes[0]['method']);
        $this->assertEquals('/user/update', $routes[0]['uri']);
        $this->assertEquals('UserController@update', $routes[0]['action']);
    }

    public function testAddDeleteRoute()
    {
        Route::delete('/user/delete', 'UserController@delete');

        $routes = Route::routers();
        $this->assertCount(1, $routes);
        $this->assertEquals('delete', $routes[0]['method']);
        $this->assertEquals('/user/delete', $routes[0]['uri']);
        $this->assertEquals('UserController@delete', $routes[0]['action']);
    }

    public function testAddPatchRoute()
    {
        Route::patch('/post/update', 'PostController@update');

        $routes = Route::routers();
        $this->assertCount(1, $routes);
        $this->assertEquals('patch', $routes[0]['method']);
        $this->assertEquals('/post/update', $routes[0]['uri']);
        $this->assertEquals('PostController@update', $routes[0]['action']);
    }

    public function testAddOptionsRoute()
    {
        Route::options('/options', 'OptionsController@handle');

        $routes = Route::routers();
        $this->assertCount(1, $routes);
        $this->assertEquals('options', $routes[0]['method']);
        $this->assertEquals('/options', $routes[0]['uri']);
        $this->assertEquals('OptionsController@handle', $routes[0]['action']);
    }

    public function testMultipleRoutes()
    {
        Route::get('/home', 'HomeController@index');
        Route::post('/login', 'AuthController@login');
        Route::put('/user/update', 'UserController@update');

        $routes = Route::routers();
        $this->assertCount(3, $routes);

        $this->assertEquals('get', $routes[0]['method']);
        $this->assertEquals('/home', $routes[0]['uri']);

        $this->assertEquals('post', $routes[1]['method']);
        $this->assertEquals('/login', $routes[1]['uri']);

        $this->assertEquals('put', $routes[2]['method']);
        $this->assertEquals('/user/update', $routes[2]['uri']);
    }
}