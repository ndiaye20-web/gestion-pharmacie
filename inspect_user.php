<?php

require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;

$users = User::where('name', 'Rama DIOP')
    ->orWhere('email', 'diop2345@gmail.com')
    ->get();

if ($users->isEmpty()) {
    echo "NOT_FOUND\n";
    exit(0);
}

foreach ($users as $user) {
    echo $user->id . ' | ' . $user->name . ' | ' . $user->email . ' | ' . $user->role . "\n";
}
