<?php

namespace Database\Factories;

use App\Models\Contact;
use App\Models\ListContact;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contact>
 */
class ContactFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'opportunity' =>'opportunity',
            'user_id' => random_int(1, 50),
            'created_by' => random_int(1, 50),
            'updated_by' => random_int(1, 50),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Contact $contact) {
            $tags = Tag::inRandomOrder()->limit(rand(1, 3))->pluck('id');
            $contact->tags()->attach($tags);

            $listContacts = ListContact::inRandomOrder()->limit(rand(1, 3))->pluck('id');
            $contact->listContacts()->attach($listContacts);
        });
    }
}
