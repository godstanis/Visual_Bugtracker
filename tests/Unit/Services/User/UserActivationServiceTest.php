<?php

namespace Tests\Unit\Services\User;

use App\Services\User\UserActivationService;
use App\UserActivation;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserActivationServiceTest extends TestCase
{
    use DatabaseTransactions;

    protected $userActivationService;
    protected $userActivation;
    protected $user;

    public function setUp()
    {
        $this->createApplication();
        $this->user = factory(\App\User::class)->state('not_activated')->create();
        $this->userActivation = new UserActivation();
        $this->userActivationService = new UserActivationService($this->user, $this->userActivation);
    }

    /**
     * @covers UserActivationService::createToken()
     */
    public function testCreatesToken()
    {
        $generatedToken = $this->userActivationService->createToken();

        $this->assertTrue(is_string($generatedToken));
        $this->assertInternalType('string', $generatedToken);

        $this->assertTrue($this->userActivation->where('token', $generatedToken)->exists());
    }

    /**
     * @depends testCreatesToken
     * @covers UserActivationService::activateUserByToken()
     */
    public function testActivatesUserByToken()
    {
        $this->assertFalse($this->user->activated);

        $generatedToken = $this->userActivationService->createToken();

        $isActivated = $this->userActivationService->activateUserByToken($generatedToken);
        $this->assertTrue($isActivated);

        $this->user->refresh();

        $this->assertTrue((bool)$this->user->activated);
    }

}
