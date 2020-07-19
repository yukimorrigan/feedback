<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ClientTest extends TestCase
{
    use RefreshDatabase;

    protected $application;
    protected $client;
    protected $manager;

    public function setUp() :void
    {
        parent::setUp();
        # генерация заявки
        $this->application = factory(\App\Application::class)->create();
        # создатель заявки
        $this->client = $this->application->user;
        # менеджер
        $this->manager = factory(\App\User::class)->states('manager')->create();
    }
    /**
     * Redirect check from home page.
     *
     * @return void
     */
    public function testClientRedirectFromHomePage()
    {
        $response =  $this->actingAs($this->client)->get(route('home'));
        $response->assertRedirect(route('application.create'));
    }

    /**
     * Redirect check from index page.
     *
     * @return void
     */
    public function testClientRedirectFromIndexPage() {
        $response =  $this->actingAs($this->client)->get(route('application.index'));
        $response->assertRedirect(route('application.create'));
    }

    /**
     * Redirect check from update page.
     *
     * @return void
     */
    public function testClientRedirectFromUpdatePage() {
        $response =  $this->actingAs($this->client)->put(route('application.update', $this->application));
        $response->assertRedirect(route('application.create'));
    }

    /**
     * Redirect check from show page.
     *
     * @return void
     */
    public function testClientRedirectFromShowPage() {
        $response =  $this->actingAs($this->client)->get(route('application.show', $this->application));
        $response->assertRedirect(route('application.create'));
    }

    /**
     * Redirect check from delete page.
     *
     * @return void
     */
    public function testClientRedirectFromDeletePage() {
        $response =  $this->actingAs($this->client)->delete(route('application.destroy', $this->application));
        $response->assertRedirect(route('application.create'));
    }

    /**
     * Redirect check from edit page.
     *
     * @return void
     */
    public function testClientRedirectFromEditPage() {
        $response =  $this->actingAs($this->client)->get(route('application.edit', $this->application));
        $response->assertRedirect(route('application.create'));
    }
}
