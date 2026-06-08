<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MahasiswaApi;

Route::apiResource('mahasiswa', MahasiswaApi::class)->names('api.mahasiswa');