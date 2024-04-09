<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;


    public function test_authenticated_user_can_create_task()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $datetime = Carbon::now()->addDay();

        $response = $this->postJson('/api/tasks', [
            'description' => 'desc 1',
            'title' => 'Task 1',
            'due_date' => $datetime,
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('tasks', [
            'description' => 'desc 1',
            'title' => 'Task 1',
            'due_date' => $datetime,
        ]);
    }


    public function test_authenticated_user_can_update_task()
    {
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user->id]);
        $this->actingAs($user);

        $response = $this->putJson("/api/tasks/{$task->id}", [
            'description' => 'Updated Task',
            'status' => 'failed',
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('tasks', [
            'id' => $task->id, 'description' => 'Updated Task', 'status' => 'failed',
        ]);
    }


    public function test_authenticated_user_can_delete_task()
    {
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user->id]);
        $this->actingAs($user);

        $response = $this->deleteJson("/api/tasks/{$task->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }
}
