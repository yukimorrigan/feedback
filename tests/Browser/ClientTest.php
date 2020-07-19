<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ClientTest extends DuskTestCase
{
    use DatabaseMigrations;
    /**
     * Create Application test.
     *
     * @return void
     */
    public function testCreateApplication()
    {
        $user = factory('App\User')->create();

        $this->browse(function (Browser $browser) use ($user) {
            # зайти на страницу создания заявки
            $browser->loginAs($user)
                ->assertAuthenticatedAs($user)
                ->visit(route('application.create'))
                ->assertSeeIn('#status', 'Оставьте вашу заявку.');
            # отправить форму
            $browser->type('subject', 'Subject')
                ->type('message', 'Message')
                ->attach('file', __DIR__.'/files/resume.docx')
                ->press('Отправить')
                ->assertSeeIn('#status', 'Ваша заявка успешно добавлена!');
            # пробуем отправить еще раз
            $browser->type('subject', 'Subject')
                ->type('message', 'Message')
                ->attach('file', __DIR__.'/files/resume.docx')
                ->press('Отправить')
                ->assertSeeIn('#status', 'Вы можете оставлять заявку только раз в сутки.');
        });
    }
}
