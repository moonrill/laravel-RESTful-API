<?php

namespace Tests\Feature;

use App\Models\Contact;
use Database\Seeders\ContactSeeder;
use Database\Seeders\UserSeeder;
use Tests\TestCase;

class AddressTest extends TestCase
{
    public function testCreateSuccess()
    {
        $this->seed([UserSeeder::class, ContactSeeder::class]);
        $contact = Contact::query()->limit(1)->first();

        $this->post('/api/contacts/' . $contact->id . '/addresses',
            [
                'street' => 'test',
                'city' => 'test',
                'province' => 'test',
                'country' => 'test',
                'postal_code' => 'test',
            ],
            [
                'Authorization' => 'test'
            ]
        )->assertStatus(201)
            ->assertJson([
                'data' => [
                    'street' => 'test',
                    'city' => 'test',
                    'province' => 'test',
                    'country' => 'test',
                    'postal_code' => 'test',
                ]
            ]);
    }

    public function testCreateFailed()
    {
        $this->seed([UserSeeder::class, ContactSeeder::class]);
        $contact = Contact::query()->limit(1)->first();

        $this->post('/api/contacts/' . $contact->id . '/addresses',
            [
                'street' => 'test',
                'city' => 'test',
                'province' => 'test',
                'country' => '',
                'postal_code' => 'test',
            ],
            [
                'Authorization' => 'test'
            ]
        )->assertStatus(400)
            ->assertJson([
                'errors' => [
                    'country' => [
                        'The country field is required.'
                    ],
                ]
            ]);
    }

    public function testCreateContactNotFound()
    {
        $this->seed([UserSeeder::class, ContactSeeder::class]);
        $contact = Contact::query()->limit(1)->first();

        $this->post('/api/contacts/' . ($contact->id + 1) . '/addresses',
            [
                'street' => 'test',
                'city' => 'test',
                'province' => 'test',
                'country' => 'test',
                'postal_code' => 'test',
            ],
            [
                'Authorization' => 'test'
            ]
        )->assertStatus(404)
            ->assertJson([
                'errors' => [
                    'message' => [
                        'User not found'
                    ]
                ]
            ]);
    }
}
