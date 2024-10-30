<?php

namespace Tests\Unit;

use Tests\TestCase;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\User;
use App\Models\Country;

class UserApiTest extends TestCase
{

    use DatabaseTransactions;

    /**
     * تست لیست کردن کاربران
     */
    public function test_can_list_users()
    {
        User::factory(3)->create();

        $response = $this->getJson('/api/users');

        $response->assertStatus(200)
            ->assertJsonCount('data');
    }

    /**
     * تست مشاهده یک کاربر خاص
     */
    public function test_can_view_user()
    {
        $user = User::factory()->create();

        $response = $this->getJson("/api/users/{$user->id}");

        $response->assertStatus(200)
            ->assertJson([
            'member' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                ],
            ]);
    }

    /**
     * تست ایجاد کاربر جدید
     */
    public function test_can_create_user()
    {
        $country_id = Country::inRandomOrder()->first()->id;

        $userData = [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'password' => 'password123',
            'country_id' => $country_id,
        ];

        $response = $this->postJson('/api/users', $userData);

        $response->assertStatus(201)
            ->assertJson([
            'member' => [
                    'name' => 'John Doe',
                    'email' => 'john.doe@example.com',
                ],
            ]);

        $this->assertDatabaseHas('users', [
            'email' => 'john.doe@example.com',
        ]);
    }

    /**
     * تست به‌روزرسانی کاربر
     */
    public function test_can_update_user()
    {
        $user = User::factory()->create();

        $updatedData = [
            'name' => 'Jane Doe',
            'email' => 'jane.doe@example.com',
        ];

        $response = $this->putJson("/api/users/{$user->id}", $updatedData);

        $response->assertStatus(200)
            ->assertJson([
            'member' => [
                    'id' => $user->id,
                    'name' => 'Jane Doe',
                    'email' => 'jane.doe@example.com',
                ],
            ]);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Jane Doe',
            'email' => 'jane.doe@example.com',
        ]);
    }

    /**
     * تست حذف کاربر
     */
    public function test_can_delete_user()
    {
        $user = User::factory()->create();

        $response = $this->deleteJson("/api/users/{$user->id}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
        ]);
    }

}
