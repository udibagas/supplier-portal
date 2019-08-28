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

Route::post('login', 'AuthController@login');
// untuk vendor registration
Route::post('register', 'AuthController@register');
Route::get('vendor/create', 'VendorController@create')->name('create-vendor')->middleware('signed');

Route::group(['middleware' => 'auth.jwt'], function() {
    Route::get('checkAuth', 'AppController@checkAuth');
    Route::post('logout', 'AuthController@logout');
    Route::resource('accountGroup', 'AccountGroupController')->only(['index', 'store', 'update', 'destroy']);

    // untuk dropdwn
    Route::get('accountGroup/getList', 'AccountGroupController@getList');
    Route::get('bank/getList', 'BankController@getList');
    Route::get('department/getList', 'DepartmentController@getList');
    Route::get('industryType/getList', 'IndustryTypeController@getList');
    Route::get('partnershipType/getList', 'PartnershipTypeController@getList');
    Route::get('productType/getList', 'ProductTypeController@getList');
    Route::get('user/getRoleList', 'UserController@getRoleList');
    Route::get('vendor/getList', 'VendorController@getList');
    Route::get('vendorDocumentType/getList', 'VendorDocumentTypeController@getList');

    Route::resource('bank', 'BankController')->only(['index', 'store', 'update', 'destroy']);
    Route::resource('department', 'DepartmentController')->only(['index', 'store', 'update', 'destroy']);
    Route::resource('industryType', 'IndustryTypeController')->only(['index', 'store', 'update', 'destroy']);
    Route::resource('invoiceSubmission', 'InvoiceSubmissionController')->only(['index', 'store', 'update', 'destroy']);
    Route::resource('invoiceSubmissionReview', 'InvoiceSubmissionReviewController')->only(['index', 'store', 'update', 'destroy']);
    Route::resource('partnershipType', 'PartnershipTypeController')->only(['index', 'store', 'update', 'destroy']);
    Route::resource('productType', 'ProductTypeController')->only(['index', 'store', 'update', 'destroy']);
    Route::resource('quotation', 'QuotationController')->only(['index', 'store', 'update', 'destroy']);
    Route::resource('quotationRequestAssignment', 'QuotationRequestAssignmentController')->only(['index', 'store', 'update', 'destroy']);
    Route::resource('quotationRequest', 'QuotationRequestController')->only(['index', 'store', 'update', 'destroy']);
    Route::post('quotationRequestItem/uploadAttachment', 'QuotationRequestItemController@uploadAttachment');
    Route::delete('quotationRequestItem/deleteAttachment', 'QuotationRequestItemController@deleteAttachment');
    Route::resource('quotationRequestItem', 'QuotationRequestItemController')->only(['store', 'destroy']);
    Route::resource('quotationReview', 'QuotationReviewController')->only(['index', 'store', 'update', 'destroy']);
    Route::resource('user', 'UserController')->only(['index', 'store', 'update', 'destroy']);
    Route::resource('vendorBank', 'VendorBankController')->only(['index', 'store', 'update', 'destroy']);
    Route::resource('vendorCompanyManagement', 'VendorCompanyManagementController')->only(['index', 'store', 'update', 'destroy']);
    Route::get('vendor/getByUser/{user}', 'VendorController@getByUser');
    Route::post('vendor/notify/{vendor}', 'VendorController@notify');
    Route::resource('vendor', 'VendorController')->only(['index', 'store', 'update', 'destroy']);
    Route::delete('vendorDocument/deleteFile', 'VendorDocumentController@deleteFile');
    Route::post('vendorDocument/upload', 'VendorDocumentController@upload');
    Route::resource('vendorDocument', 'VendorDocumentController')->only(['index', 'store', 'update', 'destroy']);
    Route::resource('vendorInvitation', 'VendorInvitationController')->only(['index', 'show', 'store', 'update', 'destroy']);
    Route::resource('vendorRegistrationReview', 'VendorRegistrationReviewController')->only(['index', 'store', 'update', 'destroy']);
    Route::resource('vendorDocumentType', 'VendorDocumentTypeController')->only(['index', 'store', 'update', 'destroy']);
    Route::resource('quotationRequestAssignment', 'QuotationRequestAssignmentController')->only(['index', 'store', 'update', 'destroy']);;
});

Route::get('/{any}', 'AppController@index')->where('any', '.*');
