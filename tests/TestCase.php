<?php

namespace Tests;

use Illuminate\Contracts\Debug\ExceptionHandler;
use App\Exceptions\Handler;
use \Illuminate\Contracts\Container\Container;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function signIn($user=null){
        $user =$user ?:create('App\User');

        $this->actingAs($user);

        return $this;
    }

    protected function setUp(): void{
        parent::setUp();
        $this->disableExceptionHandling();
    }


    
    //if need to test by using withExceptionHanding(),require disable handling and app need to throw exception
    //default setup
    protected function disableExceptionHandling(){
        $this->oldExceptionHandler=$this->app->make(ExceptionHandler::class);

        $this->app->instance(ExceptionHandler::class,new class extends Handler{
            public function __construct(){}
            public function report(\Exception $e){}
            public function render($request,\Exception $e){
                throw $e;
            }

        });

    }

    //laravel original handing will handle Exception and no Exception to throw.
    //if system will handle exception with some further action and no exception throw. test the further action, use this.
    //not default.
    protected function withExceptionHanding()
    {
        $this->app->instance(ExceptionHandler::class, $this->oldExceptionHandler);
        return $this;
    }

}
