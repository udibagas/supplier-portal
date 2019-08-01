<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => 'auth'], function() {
    Route::resource('accountGroup', 'AccountGroupController')->only(['index', 'store', 'update', 'destroy']);
    Route::resource('bank', 'BankController')->only(['index', 'store', 'update', 'destroy']);
    Route::resource('department', 'DepartmentController')->only(['index', 'store', 'update', 'destroy']);
    Route::resource('industryType', 'IndustryTypeController')->only(['index', 'store', 'update', 'destroy']);
    Route::resource('invoiceSubmission', 'InvoiceSubmissionController')->only(['index', 'store', 'update', 'destroy']);
    Route::resource('invoiceSubmissionReview', 'InvoiceSubmissionReviewController')->only(['index', 'store', 'update', 'destroy']);
    Route::resource('partnershipType', 'PartnershipTypeController')->only(['index', 'store', 'update', 'destroy']);
    Route::resource('quotation', 'QuotationController')->only(['index', 'store', 'update', 'destroy']);
    Route::resource('quotationRequestAssignment', 'QuotationRequestAssignmentController')->only(['index', 'store', 'update', 'destroy']);
    Route::resource('quotationRequest', 'QuotationRequestController')->only(['index', 'store', 'update', 'destroy']);
    Route::resource('quotationReview', 'QuotationReviewController')->only(['index', 'store', 'update', 'destroy']);
    Route::resource('user', 'UserController')->only(['index', 'store', 'update', 'destroy']);
    Route::resource('vendorBank', 'VendorBankController')->only(['index', 'store', 'update', 'destroy']);
    Route::resource('vendorCompanyManagement', 'VendorCompanyManagementController')->only(['index', 'store', 'update', 'destroy']);
    Route::resource('vendor', 'VendorController')->only(['index', 'store', 'update', 'destroy']);
    Route::resource('vendorDocument', 'VendorDocumentController')->only(['index', 'store', 'update', 'destroy']);
    Route::resource('vendorInvitation', 'VendorInvitationController')->only(['index', 'store', 'update', 'destroy']);
    Route::resource('vendorRegistrationReview', 'VendorRegistrationReviewController')->only(['index', 'store', 'update', 'destroy']);
});
