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
    Route::post('school-year/activate', 'SchoolYearCrudController@activate');
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
    Route::crud('invoice-group', 'InvoiceGroupCrudController');
    Route::get('naik-kelas', 'NaikKelasController@index')->name('naik-kelas.index');
    Route::get('report/petty-cash/', 'ReportController@report_petty_cash_index')->name('report.petty-cash-index');
    Route::post('report/petty-cash/print', 'ReportController@report_petty_cash')->name('report.petty-cash');
    Route::get('report/invoice/{id}', 'ReportController@report_invoice')->name('report.invoice');
}); // this should be the absolute last line of this file