<?php
declare(strict_types=1);

namespace Tests\Feature\app\Http\Controllers\User\Auth;

use App\Http\Controllers\User\Auth\RegisterController;
use Tests\AppTestCase;
use Tests\Traits\RoutingTestTrait;

class RegisterControllerTest extends AppTestCase
{
    use RoutingTestTrait;

    public function setUp(): void
    {
        parent::setUp();
    }


    public function tearDown(): void
    {
        parent::tearDown();
    }

    public function testRouting()
    {
        $this->initAssertRouting();

        $baseUrl = config('app.url');
        $this->assertDispatchedRoute(
            $baseUrl . '/register',
            'GET',
            [
                'actionName' => RegisterController::class . '@showRegistrationForm',
                'routeName' => 'register',

            ]
        );
        $this->assertDispatchedRoute(
            $baseUrl . '/register',
            'POST',
            [
                'actionName' => RegisterController::class . '@register',
                'routeName' => '',

            ]
        );
    }

    public function testMiddleware()
    {
        $this->initAssertRouting();

        $baseUrl = config('app.url');
        $this->assertAppliedMiddleware(
            $baseUrl . '/register',
            'GET',
            [
                'middleware' => [
                    'user',
                ],
            ]
        );
        $this->assertAppliedMiddleware(
            $baseUrl . '/register',
            'POST',
            [
                'middleware' => [
                    'user',
                ],
            ]
        );
    }
}
