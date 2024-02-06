<?php


use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

/**
 * Class AuthTest
 *
 * @package Tests\Feature
 */
class TaskTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test accessing tasks endpoint without authentication.
     *
     * @return void
     */
    public function testAccessTasksWithoutAuthentication()
    {
        $response = $this->getJson('/api/tasks');
        $response->assertStatus(401);
    }

    /**
     * Test accessing tasks endpoint with authentication.
     *
     * @return void
     */
    public function testAccessTasksWithAuthentication()
    {
        $user = User::factory()->create();
        $token = $user->createToken('TestToken')->accessToken;

        $headers = ['Authorization' => "Bearer $token"];

        $response = $this->withHeaders($headers)->getJson('/api/tasks');
        $response->assertStatus(200);
    }

    /**
     * Test creating a new task.
     *
     * @return void
     */
    public function testCreateTask()
    {
        $user = User::factory()->create();
        $token = $user->createToken('TestToken')->accessToken;

        $headers = ['Authorization' => "Bearer $token"];
        $taskData = [
            'title' => 'Test Task',
            'description' => 'This is a test task.',
            'status' => 'To Do'
        ];

        $response = $this->withHeaders($headers)
            ->postJson('/api/tasks', $taskData);
        $response->assertStatus(200);
    }

    /**
     * Test retrieving a specific task.
     *
     * @return void
     */
    public function testRetrieveTask()
    {
        $user = User::factory()->create();
        $token = $user->createToken('TestToken')->accessToken;

        $headers = ['Authorization' => "Bearer $token"];
        $task = $user->tasks()->create([
            'title' => 'Test Task',
            'description' => 'This is a test task.',
            'status' => 'To Do'
        ]);

        $response = $this->withHeaders($headers)
            ->getJson("/api/tasks/{$task->id}");
        $response->assertStatus(200);
        $response->assertJson(['data' => ['title' => $task->title]]);
    }

    /**
     * Test updating a task.
     *
     * @return void
     */
    public function testUpdateTask()
    {
        $user = User::factory()->create();
        $token = $user->createToken('TestToken')->accessToken;

        $headers = ['Authorization' => "Bearer $token"];
        $task = $user->tasks()->create([
            'title' => 'Test Task',
            'description' => 'This is a test task.',
            'status' => 'To Do'
        ]);

        $updatedData = [
            'title' => 'Updated Task Title',
            'description' => 'This task has been updated.',
            'status' => 'In Progress'
        ];

        $response = $this->withHeaders($headers)
            ->putJson("/api/tasks/{$task->id}", $updatedData);
        $response->assertStatus(200);
    }

    /**
     * Test deleting a task.
     *
     * @return void
     */
    public function testDeleteTask()
    {
        $user = User::factory()->create();
        $token = $user->createToken('TestToken')->accessToken;

        $headers = ['Authorization' => "Bearer $token"];
        $task = $user->tasks()->create([
            'title' => 'Test Task',
            'description' => 'This is a test task.',
            'status' => 'To Do'
        ]);

        $response = $this->withHeaders($headers)
            ->deleteJson("/api/tasks/{$task->id}");
        $response->assertStatus(200);
    }
}
