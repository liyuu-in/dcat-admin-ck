<?php

use Liyuu\DcatAdminCk\Http\Controllers;
use Illuminate\Support\Facades\Route;

Route::any('/ckfinder/connector', Controllers\DcatAdminCkController::class.'@requestAction')
    ->name('ckfinder-connector');

Route::any('/ckfinder/browser', Controllers\DcatAdminCkController::class.'@browserAction')
    ->name('ckfinder-browser');
