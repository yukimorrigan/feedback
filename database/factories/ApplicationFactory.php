<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Application;
use Faker\Generator as Faker;
use Illuminate\Http\UploadedFile;

$factory->define(Application::class, function (Faker $faker) {
    $faker = \Faker\Factory::create('ru_RU');
    return [
        'user_id' => function() {
            return factory(App\User::class)->create()->id;
        },
        'subject' => $faker->sentence(5),
        'message' => $faker->text(300),
        'file' => asset('/storage/' .
            UploadedFile::fake()
                ->create('fake.pdf')
                ->store('test/uploads', 'public')
        )
    ];
});
