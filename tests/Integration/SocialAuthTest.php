<?php

namespace Tests\Unit;

use Mockery;
use Socialite;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;


class SocialAuthTest extends TestCase
{
    use DatabaseTransactions;

    private $socialAuthDriver,
            $socialAuthUser;

    public function setUp()
    {
        parent::setUp();


        $this->socialAuthUser = Mockery::mock();
        $this->socialAuthUser->shouldReceive('getName')
            ->andReturn('Jane Doe');


        $this->socialAuthDriver = Mockery::mock();
        $this->socialAuthDriver->shouldReceive('user')
            ->andReturn($this->socialAuthUser);


        Socialite::shouldReceive('driver')
            ->andReturn($this->socialAuthDriver);
    }

    /**
     * Test facebook auth integration
     *
     * @return void
     */
    public function testFacebookCallback()
    {
        $this->socialAuthUser->shouldReceive([
            'getEmail' => 'test@pingthepeople.org',
            'getId' => '1234',
        ]);


        $response = $this->call('GET', '/facebook-callback');


        $response->assertRedirect('/');
        $this->assertDatabaseHas('users', [
            'Name'=>'Jane Doe',
            'AuthProviderId'=>'facebook1234',
            'Email'=>'test@pingthepeople.org'
        ]);
    }

    public function testFacebookCallbackMissingEmail()
    {
        $this->socialAuthUser->shouldReceive([
            'getEmail' => '',
            'getId' => '1234',
        ]);


        $response = $this->call('GET', '/facebook-callback');


        $this->assertDatabaseHas('users', [
            'Name'=>'Jane Doe',
            'AuthProviderId'=>'facebook1234',
            'Email'=>''
        ]);
    }

    public function testFacebookCallbackMissingId()
    {
        $this->socialAuthUser->shouldReceive([
            'getEmail' => 'test@pingthepeople.org',
            'getId' => '',
        ]);


        $response = $this->call('GET', '/facebook-callback');


        $this->assertDatabaseMissing('users', [
            'Name'=>'Jane Doe',
            'Email'=>'test@pingthepeople.org'
        ]);
    }

    public function testSingleRecordIsCreated()
    {
        $this->socialAuthUser->shouldReceive([
            'getEmail' => 'test@pingthepeople.org',
            'getId' => '1234',
        ]);


        $this->call('GET', '/facebook-callback');
        $user1 = \Auth::user();
        $this->call('GET', '/logout');
        $anon = \Auth::user();
        $this->call('GET', '/facebook-callback');
        $user2 = \Auth::user();


        $this->assertNull($anon);
        $this->assertTrue($user1->id == $user2->id);
    }

    public function testSeparateRecordsForProviders() {
        $this->socialAuthUser->shouldReceive([
            'getEmail' => 'test@pingthepeople.org',
            'getId' => '1234',
        ]);


        $this->call('GET', '/facebook-callback');
        $user1 = \Auth::user();
        $this->call('GET', '/logout');
        $anon = \Auth::user();
        $this->call('GET', '/google-callback');
        $user2 = \Auth::user();

        
        $this->assertNull($anon);
        $this->assertFalse($user1->id == $user2->id);
    }
}
