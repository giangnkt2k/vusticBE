<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return ['Laravel' => app()->version()];
});
Route::get('/contracts/{filename}', function ($filename) {
    $path = 'contracts/' . $filename; // nằm trong storage/app/public/contracts
    abort_unless(Storage::disk('public')->exists($path), 404);

    return response()->file(Storage::disk('public')->path($path));
})->where('filename', '.*');
require __DIR__ . '/auth.php';
