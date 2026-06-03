<?php

use App\Models\Task;

// COMPLETE
test('puede marcar una tarea como completada', function () {
    $task = Task::factory()->create(['completed' => false]);

    $response = $this->patchJson("/api/tasks/{$task->id}/complete");

    $response->assertStatus(200)
             ->assertJsonFragment(['completed' => true]);

    $this->assertDatabaseHas('tasks', [
        'id'        => $task->id,
        'completed' => true,
    ]);
});

test('una tarea recién creada no está completada', function () {
    $task = Task::factory()->create();

    $this->assertFalse($task->completed);
});

test('retorna 404 al intentar completar una tarea inexistente', function () {
    $response = $this->patchJson('/api/tasks/9999/complete');

    $response->assertStatus(404);
});
