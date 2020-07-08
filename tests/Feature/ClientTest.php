<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ClientTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Redirect check from home page.
     *
     * @return void
     */
    public function testClientRedirectFromHomePage()
    {
        # по умолчанию роль залогиненного пользователя - клиент
        $user = factory(\App\User::class)->create();
        $response =  $this->actingAs($user)->get(route('home'));
        $response->assertRedirect(route('application.create'));
    }

    /**
     * Redirect check from forbidden for client pages.
     *
     * @return void
     */
    public function redirectFromForbiddenPages() {
        # по умолчанию роль залогиненного пользователя - клиент
        $user = factory(\App\User::class)->create();
        $response =  $this->actingAs($user)->get(route('application.index'));
        $response->assertRedirect(route('application.create'));
        $response =  $this->actingAs($user)->get(route('application.update'));
        $response->assertRedirect(route('application.create'));
        $response =  $this->actingAs($user)->get(route('application.show'));
        $response->assertRedirect(route('application.create'));
        $response =  $this->actingAs($user)->get(route('application.destroy'));
        $response->assertRedirect(route('application.create'));
        $response =  $this->actingAs($user)->get(route('application.edit'));
        $response->assertRedirect(route('application.create'));
    }
}
