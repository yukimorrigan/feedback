<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ManagerTest extends TestCase
{
    use RefreshDatabase;

    protected $manager;

    public function setUp() :void
    {
        parent::setUp();
        # менеджер
        $this->manager = factory(\App\User::class)->states('manager')->create();
    }

    /**
     * Redirect check from home page.
     *
     * @return void
     */
    public function testManagerRedirectFromHomePage()
    {
        $response =  $this->actingAs($this->manager)->get(route('home'));
        $response->assertRedirect(route('application.index'));
    }

    /**
     * Redirect check from create page.
     *
     * @return void
     */
    public function testManagerRedirectFromCreatePage()
    {
        $response =  $this->actingAs($this->manager)->get(route('application.create'));
        $response->assertRedirect(route('application.index'));
    }

    /**
     * Redirect check from store page.
     *
     * @return void
     */
    public function testManagerRedirectFromStorePage()
    {
        $response =  $this->actingAs($this->manager)->post(route('application.store'));
        $response->assertRedirect(route('application.index'));
    }
}
