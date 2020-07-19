<?php

namespace Tests\Browser;

use App\Application;
use Facebook\WebDriver\WebDriverBy;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ManagerTest extends DuskTestCase
{
    use DatabaseMigrations;
    /**
     * Test applications list view.
     *
     * @return void
     */
    public function testApplicationList()
    {
        $manager = factory(\App\User::class)->states('manager')->create();
        # кол-во заявок на одну страницу
        $countPerPage = Application::SHOW_BY_DEFAULT;
        factory(\App\Application::class, $countPerPage)->create();

        $this->browse(function (Browser $browser) use ($manager, $countPerPage)  {
            # зайти на страницу просмотра заявок
            $browser->loginAs($manager)
                ->assertAuthenticatedAs($manager)
                ->visit(route('application.index'));
            # строк в таблице должно быть столько же, сколько в константе SHOW_BY_DEFAULT
            $trs = $browser->driver->findElements(WebDriverBy::cssSelector('tbody > tr'));
            $this->assertCount($countPerPage, $trs);
            # нажать на первый флажок
            $browser->check('tbody > tr:nth-child(1) input');
            # подождать
            $browser->pause(1000);
            # обновить страницу
            $browser->visit(route('application.index'))
                # последняя строка таблицы c классом .table-success - первая запись в бд
                ->assertSeeIn("tbody > tr:nth-child($countPerPage).table-success", "1")
                # чекбокс этой строки помечен
                ->assertChecked("tbody > tr:nth-child($countPerPage).table-success .form-check-input");
            # отжать флажок
            $browser->uncheck("tbody > tr:nth-child($countPerPage) input");
            # подождать
            $browser->pause(1000);
            # обновить страницу
            $browser->visit(route('application.index'))
                # классов не должно быть
                ->assertAttribute('tbody > tr:nth-child(1)', 'class', '')
                # первая строка таблицы - первая запись в бд
                ->assertSeeIn('tbody > tr:nth-child(1) th', '1')
                # чекбокс не помечен
                ->assertNotChecked('tbody > tr:nth-child(1) .form-check-input');
        });
    }
}
