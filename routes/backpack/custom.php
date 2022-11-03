<?php

use Illuminate\Support\Facades\Route;

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin')
    ),
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    
    Route::crud('classroom', 'ClassroomCrudController');
    Route::crud('payment', 'PaymentCrudController');
    Route::crud('payment-way', 'PaymentWayCrudController');
    Route::crud('school-level', 'SchoolLevelCrudController');
    Route::crud('school-year', 'SchoolYearCrudController');
    Route::crud('setting', 'SettingCrudController');
    Route::crud('spp-master', 'SppMasterCrudController');
    Route::crud('student', 'StudentCrudController');
    Route::crud('teacher', 'TeacherCrudController');
    Route::crud('petty-cash', 'PettyCashCrudController');
    Route::crud('teacher-classroom', 'TeacherClassroomCrudController');
    Route::crud('invoice', 'InvoiceCrudController');
    Route::crud('student-funding-detail', 'StudentFundingDetailCrudController');
    Route::crud('student-school-history', 'StudentSchoolHistoryCrudController');
}); // this should be the absolute last line of this file