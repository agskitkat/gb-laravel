<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Faker;

class ExampleTest extends DuskTestCase
{
    /**
     * A basic browser test example.
     *
     * @return void
     */
    public function testBasicExample()
    {

        $this->browse(function (Browser $browser) {

            $faker = Faker\Factory::create('Ru_RU');


            // Заходим на страницу логина и авторизируемся
            $browser->visit('/login')
                ->type("#email", "aaa@aaa.aaa")
                ->type("#password", 'aaa@aaa.aaa')
                ->press('Login')
                ->assertPathIs('/');

            // Идём на страницу новой статьи
            $browser->visit('/admin/articles')
                ->press('.dusk-add-article')
                ->assertPathIs('/admin/articles/create');

            $browser->type('input[name="name"]', '1')
                ->select('select[name="categories[]"]', "0")
                ->press('.btn-success')
                ->assertSee('Количество символов в поле Заголовок должно быть не менее 3.');

            $browser->type('input[name="name"]', 'TEST')
                ->select('select[name="categories[]"]', "0")
                ->script("$('#ckeditor').html('".$faker->text(rand(200, 400))."');")
                // TODO  Победить ckeditor
                //->type('.ck.ck-content.ck-editor__editable', $faker->text(rand(200, 400)))
                ->press('form button.btn-success')
                ->assertSee('Изменения сохранены !');

        });
    }
}
