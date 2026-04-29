<?php

test('registration screen can be rendered', function () {
    $response = $this->get('/register');

    $response->assertStatus(200);
});

test('new users can register', function () {
    $this->seed(\Database\Seeders\DummySeeder::class);

    $fakultas = \App\Models\Fakultas::query()->first();

    $response = $this->post('/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'role' => 'mahasiswa',
        'nim_nip' => '123456789',
        'id_fakultas' => $fakultas->id_fakultas,
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('dashboard', absolute: false));
});
