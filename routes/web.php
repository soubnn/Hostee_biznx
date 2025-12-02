<?php

use App\Http\Controllers\DirectSalesController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PurchaseOrderController;

Auth::routes();


// user login and profile
Route::get('/', [App\Http\Controllers\AdminController::class,'login'])->name('login');
Route::post('/loginsubmit', [App\Http\Controllers\AdminController::class,'loginsubmit'])->name('loginsubmit');
Route::get('/logout',[App\Http\Controllers\AdminController::class,'logout'])->name('logout');

Route::group(['middleware'=>['auth']],function(){

    Route::patch('/editprofilename/{id}', [App\Http\Controllers\AdminController::class,'editprofilename'])->name('editprofilename');
    Route::patch('/editpassword/{id}', [App\Http\Controllers\AdminController::class,'editpassword'])->name('editpassword');
    Route::patch('/editprofileimage/{id}', [App\Http\Controllers\AdminController::class,'editprofileimage'])->name('editprofileimage');

    Route::get('/dashboard',  [App\Http\Controllers\AdminController::class,'dashboard'])->name('dashboard');
    Route::get('/fetch-yearly-data', [App\Http\Controllers\AdminController::class, 'fetchYearlyData']);
    Route::get('/fetch-sales-data', [App\Http\Controllers\AdminController::class, 'fetchSalesData'])->name('fetch.sales.data');

    Route::resource('staff', App\Http\Controllers\StaffController::class);
    Route::post('delete_staff/{id}',[App\Http\Controllers\StaffController::class, 'delete_staff'])->name('delete_staff');
    Route::any('updateStaff/{id}',[App\Http\Controllers\StaffController::class, 'updateStaff'])->name('updateStaff');
    Route::get('/staffPayment',[App\Http\Controllers\StaffController::class, 'get_payments'])->name('staff.payments');
    Route::get('/filter_staff_payments',[App\Http\Controllers\StaffController::class, 'filter_staff_payments'])->name('filter_staff_payments');
    Route::get('/job_requests',[App\Http\Controllers\StaffController::class, 'job_requests'])->name('staff.request');
    Route::post('/delete_staff_request/{id}',[App\Http\Controllers\StaffController::class, 'delete_staff_request'])->name('delete_staff_request');
    Route::get('/staffs/search_request',[App\Http\Controllers\StaffController::class, 'search_request'])->name('staffs.search_request');
    Route::post('staff/make_payments/{id}',[App\Http\Controllers\StaffController::class, 'store_payments'])->name('staff.store_payments');
    Route::post('staff/make_advance_payment/{id}',[App\Http\Controllers\StaffController::class, 'store_advance'])->name('staff.store_advance');
    Route::get('/staff/payment/history/{id}',[App\Http\Controllers\StaffController::class, 'payment_history'])->name('staff.payment.history');
    Route::get('/staffs/user',[App\Http\Controllers\StaffController::class, 'index_user'])->name('user.index');
    Route::post('delete_user/{id}',[App\Http\Controllers\StaffController::class, 'delete_user'])->name('delete_user');
    Route::post('active_user/{id}',[App\Http\Controllers\StaffController::class, 'active_user'])->name('active_user');
    Route::get('staff/salarySlipReport/{id}',[App\Http\Controllers\StaffController::class, 'salarySlipReport'])->name('staff.salarySlipReport');
    Route::get('staff/termSalarySlipReport/{id}',[App\Http\Controllers\StaffController::class, 'termSalarySlipReport'])->name('staff.termSalarySlipReport');

    Route::resource('/stock', App\Http\Controllers\StockController::class);
    Route::get('getProduct',[App\Http\Controllers\StockController::class, 'getProduct'])->name('getProduct')->name('getProduct');;
    Route::get('getProductDetails/{id}',[App\Http\Controllers\StockController::class, 'getProductDetails'])->name('getProductDetails');
    Route::get('/stocks/export/csv',[App\Http\Controllers\StockController::class, 'export'])->name('stock.export.csv');

    Route::resource('/consignment', App\Http\Controllers\ConsignmentController::class);
    Route::post('inform_consignment/{id}',[App\Http\Controllers\ConsignmentController::class, 'inform_consignment'])->name('inform_consignment');
    Route::post('assessment_consignment/{id}',[App\Http\Controllers\ConsignmentController::class, 'assessment_consignment'])->name('assessment_consignment');
    Route::post('return_consignment/{id}',[App\Http\Controllers\ConsignmentController::class, 'return_consignment'])->name('return_consignment');
    Route::get('view_returned',[App\Http\Controllers\ConsignmentController::class, 'view_returned'])->name('view_returned');
    Route::get('view_delivered',[App\Http\Controllers\ConsignmentController::class, 'view_delivered'])->name('view_delivered');
    Route::get('view_pending',[App\Http\Controllers\ConsignmentController::class, 'pending_index'])->name('view_pending');
    Route::get('view_informed',[App\Http\Controllers\ConsignmentController::class, 'informed_index'])->name('view_informed');
    Route::get('view_rejected',[App\Http\Controllers\ConsignmentController::class, 'rejected_index'])->name('view_rejected');
    Route::get('reject_jobcard/{id}',[App\Http\Controllers\ConsignmentController::class, 'reject_jobcard'])->name('reject_jobcard');
    Route::get('approve_jobcard/{id}',[App\Http\Controllers\ConsignmentController::class, 'approve_jobcard'])->name('approve_jobcard');
    Route::get('view_thirdparty',[App\Http\Controllers\ConsignmentController::class, 'thirdparty'])->name('view_thirdparty');
    Route::get('rework/{id}',[App\Http\Controllers\ConsignmentController::class, 'rework'])->name('rework');
    Route::post('store_worktype',[App\Http\Controllers\ConsignmentController::class, 'store_worktype'])->name('store_worktype');
    Route::post('invoice/{id}',[App\Http\Controllers\ConsignmentController::class, 'invoice'])->name('invoice');
    Route::get('view_invoice/{id}',[App\Http\Controllers\ConsignmentController::class, 'view_invoice'])->name('view_invoice');
    Route::get('jobcard_report',[App\Http\Controllers\ConsignmentController::class, 'jobcard_report'])->name('jobcard_report');
    Route::get('jobcard_report_view',[App\Http\Controllers\ConsignmentController::class, 'jobcard_report_view'])->name('jobcard_report_view');
    Route::get('/get_customer', [App\Http\Controllers\ConsignmentController::class,'get_customer'])->name('get_customer');
    Route::get('/deliver_without_invoice/{id}', [App\Http\Controllers\ConsignmentController::class,'deliver_without_invoice'])->name('deliver_without_invoice');
    Route::get('allJobcards',[App\Http\Controllers\ConsignmentController::class, 'allJobcards'])->name('allJobcards');
    Route::get('/search-jobcards',[App\Http\Controllers\ConsignmentController::class, 'searchJobcards'])->name('search.jobcards');
    Route::get('/consignment/{id}/details',[App\Http\Controllers\ConsignmentController::class, 'print_details'])->name('consignment.print_details');

    Route::post('jobcard_edit_name/{id}',[App\Http\Controllers\ConsignmentController::class, 'jobcard_edit_name'])->name('jobcard_edit_name');
    Route::post('jobcard_edit_phone/{id}',[App\Http\Controllers\ConsignmentController::class, 'jobcard_edit_phone'])->name('jobcard_edit_phone');
    Route::post('jobcard_edit_place/{id}',[App\Http\Controllers\ConsignmentController::class, 'jobcard_edit_place'])->name('jobcard_edit_place');
    Route::post('jobcard_edit_email/{id}',[App\Http\Controllers\ConsignmentController::class, 'jobcard_edit_email'])->name('jobcard_edit_email');
    Route::post('jobcard_edit_customer_type/{id}',[App\Http\Controllers\ConsignmentController::class, 'jobcard_edit_customer_type'])->name('jobcard_edit_customer_type');
    Route::post('jobcard_edit_work_location/{id}',[App\Http\Controllers\ConsignmentController::class, 'jobcard_edit_work_location'])->name('jobcard_edit_work_location');
    Route::post('jobcard_edit_service_type/{id}',[App\Http\Controllers\ConsignmentController::class, 'jobcard_edit_service_type'])->name('jobcard_edit_service_type');
    Route::post('jobcard_edit_product_name/{id}',[App\Http\Controllers\ConsignmentController::class, 'jobcard_edit_product_name'])->name('jobcard_edit_product_name');
    Route::post('jobcard_edit_serial_num/{id}',[App\Http\Controllers\ConsignmentController::class, 'jobcard_edit_serial_num'])->name('jobcard_edit_serial_num');
    Route::post('jobcard_edit_complaints/{id}',[App\Http\Controllers\ConsignmentController::class, 'jobcard_edit_complaints'])->name('jobcard_edit_complaints');
    Route::post('jobcard_edit_components_recieved/{id}',[App\Http\Controllers\ConsignmentController::class, 'jobcard_edit_components_recieved'])->name('jobcard_edit_components_recieved');
    Route::post('jobcard_edit_remarks/{id}',[App\Http\Controllers\ConsignmentController::class, 'jobcard_edit_remarks'])->name('jobcard_edit_remarks');
    Route::post('jobcard_edit_advance/{id}',[App\Http\Controllers\ConsignmentController::class, 'jobcard_edit_advance'])->name('jobcard_edit_advance');
    Route::post('jobcard_edit_image1/{id}',[App\Http\Controllers\ConsignmentController::class, 'jobcard_edit_image1'])->name('jobcard_edit_image1');
    Route::post('jobcard_edit_image2/{id}',[App\Http\Controllers\ConsignmentController::class, 'jobcard_edit_image2'])->name('jobcard_edit_image2');
    Route::post('jobcard_edit_image3/{id}',[App\Http\Controllers\ConsignmentController::class, 'jobcard_edit_image3'])->name('jobcard_edit_image3');
    Route::post('jobcard_edit_image4/{id}',[App\Http\Controllers\ConsignmentController::class, 'jobcard_edit_image4'])->name('jobcard_edit_image4');
    Route::post('jobcard_edit_accessories/{id}',[App\Http\Controllers\ConsignmentController::class, 'jobcard_edit_accessories'])->name('jobcard_edit_accessories');

    Route::resource('/daybook', App\Http\Controllers\DaybookController::class);
    Route::get('/createIncome', [App\Http\Controllers\DaybookController::class, 'createIncome'])->name('daybook.createIncome');
    Route::get('get_commission',[App\Http\Controllers\DaybookController::class, 'get_commission'])->name('get_commission');
    Route::get('date_report',[App\Http\Controllers\DaybookController::class, 'date_report'])->name('date_report');
    Route::get('month_report',[App\Http\Controllers\DaybookController::class, 'month_report'])->name('month_report');
    Route::get('year_report',[App\Http\Controllers\DaybookController::class, 'year_report'])->name('year_report');
    Route::get('/daybooks/view_all',[App\Http\Controllers\DaybookController::class, 'all_index'])->name('daybook.all_index');
    Route::post('/generateDaybook', [App\Http\Controllers\DaybookController::class, 'generateDaybook'])->name('generateDaybook');

    Route::resource('/expense', App\Http\Controllers\ExpenseController::class);
    Route::get('get_expense',[App\Http\Controllers\ExpenseController::class, 'get_expense'])->name('get_expense');
    Route::resource('/income', App\Http\Controllers\IncomeController::class);
    Route::get('get_income',[App\Http\Controllers\IncomeController::class, 'get_income'])->name('get_income');

    Route::resource('/purchase', App\Http\Controllers\PurchaseController::class);
    Route::get('purchase_report',[App\Http\Controllers\PurchaseController::class, 'purchase_report'])->name('purchase_report');
    Route::post('/purchase/add_bill/{id}',[App\Http\Controllers\PurchaseController::class, 'add_purchase_bill'])->name('purchase.add_purchase_bill');

    Route::resource('/seller', App\Http\Controllers\SellerController::class);
    Route::resource('/product', App\Http\Controllers\ProductController::class);
    Route::get('products/view', [App\Http\Controllers\ProductController::class, 'view_products'])->name('products.view');
    Route::get('products/summary', [App\Http\Controllers\ProductController::class, 'product_summary'])->name('products.summary');
    Route::get('products/summary_items/{id}', [App\Http\Controllers\ProductController::class, 'product_summary_items'])->name('product.summary_items');
    Route::resource('/product_category', App\Http\Controllers\ProductCategoryController::class);
    Route::post('/add_category', [App\Http\Controllers\ProductCategoryController::class, 'add_category'])->name('add_category');

    Route::post('/storeSeller', [App\Http\Controllers\SellerController::class, 'store1']);
    Route::post('/addPurchaseItem', [App\Http\Controllers\PurchaseItemController::class, 'addPurchaseItem']);
    Route::post('/addSalesItem', [App\Http\Controllers\SalesItemsController::class, 'addSalesItem'])->name('addSalesItem');
    Route::post('/addProduct', [App\Http\Controllers\ProductController::class, 'addProduct']);
    Route::get('/getProducts', [App\Http\Controllers\ProductController::class, 'getProducts'])->name('getProducts');
    Route::get('/getProductsInStock', [App\Http\Controllers\ProductController::class, 'getProductsInStock'])->name('getProductsInStock');
    Route::get('/getProductDetails', [App\Http\Controllers\ProductController::class, 'getProductDetails'])->name('getProductDetails');
    Route::get('/getProductDetailsFromStock', [App\Http\Controllers\StockController::class, 'getProductDetailsFromStock'])->name('getProductDetailsFromStock');
    Route::post('/addSales', [App\Http\Controllers\SalesController::class, 'addSales']);
    Route::resource('/sales', App\Http\Controllers\SalesController::class);

    Route::resource('/stock', App\Http\Controllers\StockController::class);
    Route::get('/checkStock', [App\Http\Controllers\StockController::class, 'checkStock'])->name('checkStock');
    Route::get('getProduct',[App\Http\Controllers\StockController::class, 'getProduct'])->name('getProduct');
    Route::get('getProductDetails/{id}',[App\Http\Controllers\StockController::class, 'getProductDetails'])->name('getProductDetails');

    Route::post('product_edit_code/{id}', [App\Http\Controllers\ProductController::class, 'product_edit_code'])->name('product_edit_code');
    Route::post('product_edit_name/{id}', [App\Http\Controllers\ProductController::class, 'product_edit_name'])->name('product_edit_name');
    Route::post('product_edit_hsn/{id}', [App\Http\Controllers\ProductController::class, 'product_edit_hsn'])->name('product_edit_hsn');
    Route::post('product_edit_unit/{id}', [App\Http\Controllers\ProductController::class, 'product_edit_unit'])->name('product_edit_unit');
    Route::post('product_edit_tax_schedule/{id}', [App\Http\Controllers\ProductController::class, 'product_edit_tax_schedule'])->name('product_edit_tax_schedule');
    Route::post('product_edit_category/{id}', [App\Http\Controllers\ProductController::class, 'product_edit_category'])->name('product_edit_category');
    Route::post('product_edit_warrenty/{id}', [App\Http\Controllers\ProductController::class, 'product_edit_warrenty'])->name('product_edit_warrenty');
    Route::post('product_edit_max_stock/{id}', [App\Http\Controllers\ProductController::class, 'product_edit_max_stock'])->name('product_edit_max_stock');
    Route::post('product_edit_expiry/{id}', [App\Http\Controllers\ProductController::class, 'product_edit_expiry'])->name('product_edit_expiry');
    Route::post('product_edit_price/{id}', [App\Http\Controllers\ProductController::class, 'product_edit_price'])->name('product_edit_price');
    Route::post('product_edit_mrp/{id}', [App\Http\Controllers\ProductController::class, 'product_edit_mrp'])->name('product_edit_mrp');
    Route::post('product_edit_selling_price/{id}', [App\Http\Controllers\ProductController::class, 'product_edit_selling_price'])->name('product_edit_selling_price');
    Route::post('product_edit_supplier/{id}', [App\Http\Controllers\ProductController::class, 'product_edit_supplier'])->name('product_edit_supplier');
    Route::post('product_edit_brand/{id}', [App\Http\Controllers\ProductController::class, 'product_edit_brand'])->name('product_edit_brand');
    Route::post('product_edit_description/{id}', [App\Http\Controllers\ProductController::class, 'product_edit_description'])->name('product_edit_description');
    Route::post('product_edit_image/{id}', [App\Http\Controllers\ProductController::class, 'product_edit_image'])->name('product_edit_image');

    Route::resource('/vehicle', App\Http\Controllers\VehicleController::class);

    Route::post('vehicle_edit_number/{id}',[App\Http\Controllers\VehicleController::class, 'vehicle_edit_number'])->name('vehicle_edit_number');
    Route::post('vehicle_edit_name/{id}',[App\Http\Controllers\VehicleController::class, 'vehicle_edit_name'])->name('vehicle_edit_name');
    Route::post('vehicle_edit_model/{id}',[App\Http\Controllers\VehicleController::class, 'vehicle_edit_model'])->name('vehicle_edit_model');
    Route::post('vehicle_edit_rc_owner/{id}',[App\Http\Controllers\VehicleController::class, 'vehicle_edit_rc_owner'])->name('vehicle_edit_rc_owner');
    Route::post('vehicle_edit_engine_number/{id}',[App\Http\Controllers\VehicleController::class, 'vehicle_edit_engine_number'])->name('vehicle_edit_engine_number');
    Route::post('vehicle_edit_chasis_number/{id}',[App\Http\Controllers\VehicleController::class, 'vehicle_edit_chasis_number'])->name('vehicle_edit_chasis_number');
    Route::post('vehicle_edit_reg_validity/{id}',[App\Http\Controllers\VehicleController::class, 'vehicle_edit_reg_validity'])->name('vehicle_edit_reg_validity');
    Route::post('vehicle_edit_insurance_number/{id}',[App\Http\Controllers\VehicleController::class, 'vehicle_edit_insurance_number'])->name('vehicle_edit_insurance_number');
    Route::post('vehicle_edit_insurance_validity/{id}',[App\Http\Controllers\VehicleController::class, 'vehicle_edit_insurance_validity'])->name('vehicle_edit_insurance_validity');
    Route::post('vehicle_edit_pollution_validity/{id}',[App\Http\Controllers\VehicleController::class, 'vehicle_edit_pollution_validity'])->name('vehicle_edit_pollution_validity');
    Route::post('vehicle_edit_permit_validity/{id}',[App\Http\Controllers\VehicleController::class, 'vehicle_edit_permit_validity'])->name('vehicle_edit_permit_validity');
    Route::post('vehicle_edit_rcdoc/{id}',[App\Http\Controllers\VehicleController::class, 'vehicle_edit_rcdoc'])->name('vehicle_edit_rcdoc');
    Route::post('vehicle_edit_insurancedoc/{id}',[App\Http\Controllers\VehicleController::class, 'vehicle_edit_insurancedoc'])->name('vehicle_edit_insurancedoc');
    Route::post('vehicle_edit_pollutiondoc/{id}',[App\Http\Controllers\VehicleController::class, 'vehicle_edit_pollutiondoc'])->name('vehicle_edit_pollutiondoc');
    Route::post('vehicle_edit_permitdoc/{id}',[App\Http\Controllers\VehicleController::class, 'vehicle_edit_permitdoc'])->name('vehicle_edit_permitdoc');

    Route::post('seller_edit_name/{id}',[App\Http\Controllers\SellerController::class, 'seller_edit_name'])->name('seller_edit_name');
    Route::post('seller_edit_phone/{id}',[App\Http\Controllers\SellerController::class, 'seller_edit_phone'])->name('seller_edit_phone');
    Route::post('seller_edit_mobile/{id}',[App\Http\Controllers\SellerController::class, 'seller_edit_mobile'])->name('seller_edit_mobile');
    Route::post('seller_edit_city/{id}',[App\Http\Controllers\SellerController::class, 'seller_edit_city'])->name('seller_edit_city');
    Route::post('seller_edit_area/{id}',[App\Http\Controllers\SellerController::class, 'seller_edit_area'])->name('seller_edit_area');
    Route::post('seller_edit_courier_address/{id}',[App\Http\Controllers\SellerController::class, 'seller_edit_courier_address'])->name('seller_edit_courier_address');
    Route::post('seller_edit_email/{id}',[App\Http\Controllers\SellerController::class, 'seller_edit_email'])->name('seller_edit_email');
    Route::post('seller_edit_pincode/{id}',[App\Http\Controllers\SellerController::class, 'seller_edit_pincode'])->name('seller_edit_pincode');
    Route::post('seller_edit_state/{id}',[App\Http\Controllers\SellerController::class, 'seller_edit_state'])->name('seller_edit_state');
    Route::post('seller_edit_account/{id}',[App\Http\Controllers\SellerController::class, 'seller_edit_account'])->name('seller_edit_account');
    Route::post('seller_edit_gst/{id}',[App\Http\Controllers\SellerController::class, 'seller_edit_gst'])->name('seller_edit_gst');
    Route::post('seller_edit_pan/{id}',[App\Http\Controllers\SellerController::class, 'seller_edit_pan'])->name('seller_edit_pan');
    Route::post('seller_edit_tin/{id}',[App\Http\Controllers\SellerController::class, 'seller_edit_tin'])->name('seller_edit_tin');
    Route::post('/generateCompleteSellerReport', [App\Http\Controllers\SellerController::class, 'generateCompleteSellerReport'])->name('generateCompleteSellerReport');
    Route::post('/generateSellerReport', [App\Http\Controllers\SellerController::class, 'generateSellerReport'])->name('generateSellerReport');
    Route::get('/seller_courier/{id}', [App\Http\Controllers\SellerController::class, 'seller_courier'])->name('seller_courier');

    Route::get('/get_commission_details',[App\Http\Controllers\DaybookController::class,'get_commission']);
    Route::get('/get_salary_details',[App\Http\Controllers\DaybookController::class,'get_salary']);
    Route::get('/utility_login',[App\Http\Controllers\UtilityController::class,'utility_login'])->name('utility_login');
    Route::post('/utility_check',[App\Http\Controllers\UtilityController::class,'utility_check'])->name('utility_check');
    Route::get('/utility_dashboard',[App\Http\Controllers\UtilityController::class,'utility_dashboard'])->name('util_dash');
    Route::get('/utility_purchases',[App\Http\Controllers\UtilityController::class,'utility_purchases'])->name('util_purchase');
    Route::get('/utility_sales',[App\Http\Controllers\UtilityController::class,'utility_sales'])->name('util_sales.edit');
    Route::get('/utility_sales/cancel',[App\Http\Controllers\UtilityController::class,'utility_sales_cancel'])->name('util_sales.cancel');
    Route::get('/util_purchase_details/{id}',[App\Http\Controllers\UtilityController::class,'util_purchase_details'])->name('util_purchase_details');
    Route::get('/util_sales_details/{id}',[App\Http\Controllers\UtilityController::class,'util_sales_details'])->name('util_sales_details');
    Route::get('/util_sales_details/cancel/{id}',[App\Http\Controllers\UtilityController::class,'util_sales_details_cancel'])->name('util_sales_details.cancel');
    Route::post('/utility_edit_stock',[App\Http\Controllers\UtilityController::class,'utility_edit_stock'])->name('utility_edit_stock');
    Route::post('/utility_edit_purchase',[App\Http\Controllers\UtilityController::class,'utility_edit_purchase'])->name('utility_edit_purchase');
    Route::post('/utility_update_sales',[App\Http\Controllers\UtilityController::class,'utility_update_sales'])->name('utility_update_sales');
    Route::post('/util_update_sales_item',[App\Http\Controllers\UtilityController::class,'util_update_sales_item'])->name('util_update_sales_item');
    Route::post('/util_new_sales_item',[App\Http\Controllers\UtilityController::class,'util_new_sales_item'])->name('util_new_sales_item');
    Route::get('/util_delete_sales_item',[App\Http\Controllers\UtilityController::class,'util_delete_sales_item'])->name('util_delete_sales_item');
    Route::post('/util_sales_return/{id}',[App\Http\Controllers\UtilityController::class,'util_sales_return'])->name('util_sales_return');
    Route::post('/util_unpaid_sales_return/{id}',[App\Http\Controllers\UtilityController::class,'util_unpaid_sales_return'])->name('util_unpaid_sales_return');
    Route::get('/util_convert_invoice',[App\Http\Controllers\UtilityController::class,'util_convert_invoice'])->name('util_convert_invoice');
    Route::get('/util_convert_data',[App\Http\Controllers\UtilityController::class,'util_convert_data'])->name('util_convert_data');

    // consolidate
    Route::resource('consolidate', App\Http\Controllers\ConsoulidateController::class);
    Route::any('/direct_sales/consolidate/{id}', [App\Http\Controllers\ConsoulidateController::class, 'consolidates_create'])->name('direct_sales.consolidate');
    Route::get('/consolidate/invoice/{id}',[App\Http\Controllers\ConsoulidateController::class, 'consolidates_invoice'])->name('consolidates_invoice');

    //purchase utility return
    Route::any('/utility/purchase/return', [App\Http\Controllers\UtilityController::class, 'purchase_return'])->name('utility.purchase.return');
    Route::any('/utility/purchase/return_items/{id}', [App\Http\Controllers\UtilityController::class, 'purchase_return_items'])->name('utility.purchase.return_items');
    Route::any('/utility/purchase_items/return/{id}', [App\Http\Controllers\UtilityController::class, 'return_purchase_items'])->name('utility.purchase_items.return');
    Route::any('/utility/purchase/view_return', [App\Http\Controllers\UtilityController::class, 'view_return'])->name('utility.return.index');
    Route::any('/utility/purchase/view_returned_items/{id}', [App\Http\Controllers\UtilityController::class, 'view_returned_items'])->name('utility.purchase.returned_items');
    Route::any('/utility/purchase/debit_note/{id}', [App\Http\Controllers\UtilityController::class, 'debit_note'])->name('utility.purchase.debit_note');

    //sales utility return
    Route::any('/utility/sales/return', [App\Http\Controllers\UtilityController::class, 'sales_return'])->name('utility.sales.return');
    Route::any('/utility/sales/return_items/{id}', [App\Http\Controllers\UtilityController::class, 'sales_return_items'])->name('utility.sales.return_items');
    Route::any('/utility/sales_items/return/{id}', [App\Http\Controllers\UtilityController::class, 'return_sales_items'])->name('utility.sales_items.return');
    Route::any('/utility/sales/view_return', [App\Http\Controllers\UtilityController::class, 'view_sale_return'])->name('utility.sale_return.index');
    Route::any('/utility/sales/view_returned_items/{id}', [App\Http\Controllers\UtilityController::class, 'view_sale_returned_items'])->name('utility.sales.returned_items');
    Route::any('/utility/sales/credit_note/{id}', [App\Http\Controllers\UtilityController::class, 'credit_note'])->name('utility.sales.credit_note');

    //direct sales routes
    Route::any('/sale/view_all/', [App\Http\Controllers\DirectSalesController::class, 'search_sales'])->name('direct_sales.all_sales.search');
    Route::any('/sale/view_return', [App\Http\Controllers\DirectSalesController::class, 'view_sale_return'])->name('direct_sales.return.index');
    Route::any('/sale/view_returned_items/{id}', [App\Http\Controllers\DirectSalesController::class, 'view_sale_returned_items'])->name('direct_sales.returned_items');

    Route::controller(DirectSalesController::class)->group(function(){
        Route::get('/sale/all_sales', 'view_all_sales')->name('direct_sales.view_all');
    });


    //purchase routes
    Route::any('/purchases/view_return', [App\Http\Controllers\PurchaseController::class, 'view_return'])->name('purchase.return.index');
    Route::any('/purchases/view_returned_items/{id}', [App\Http\Controllers\PurchaseController::class, 'view_returned_items'])->name('purchase.returned_items');

    Route::get('/getChartData',[App\Http\Controllers\AdminController::class,'getChartData'])->name('getChartData');
    Route::get('/profile',[App\Http\Controllers\AdminController::class,'profile'])->name('profile');

    Route::resource('/chiplevel', App\Http\Controllers\ChiplevelController::class);
    Route::post('chiplevel_store/{id}',[App\Http\Controllers\ChiplevelController::class, 'chiplevel_store'])->name('chiplevel_store');

    Route::resource('/estimate', App\Http\Controllers\EstimateController::class);
    Route::post('store_system_estimate',[App\Http\Controllers\EstimateController::class, 'store_system_estimate'])->name('store_system_estimate');
    Route::get('/estimate/view/requests',[App\Http\Controllers\EstimateController::class, 'view_request'])->name('estimate.request');
    Route::get('getCategoryProduct',[App\Http\Controllers\EstimateController::class, 'getCategoryProduct'])->name('getCategoryProduct');
    Route::get('get_product_categories',[App\Http\Controllers\EstimateController::class, 'get_product_categories'])->name('get_product_categories');
    Route::get('/getEstimateProductDetails', [App\Http\Controllers\EstimateController::class, 'getEstimateProductDetails'])->name('getEstimateProductDetails');
    Route::get('/estimate_report/{id}', [App\Http\Controllers\EstimateController::class, 'estimate_report'])->name('estimate_report');
    Route::post('/estimate/{id}/enable',[App\Http\Controllers\EstimateController::class, 'enable_estimate'])->name('enable_estimate');
    Route::post('/estimate/{id}/disable',[App\Http\Controllers\EstimateController::class, 'disable_estimate'])->name('disable_estimate');
    Route::post('/estimate/{id}/edit',[App\Http\Controllers\EstimateController::class, 'estimate_item_edit'])->name('estimate.edit.items');
    Route::post('/estimate/new_item',[App\Http\Controllers\EstimateController::class, 'estimate_add_item'])->name('estimate.new_item');
    Route::post('/estimate/delete/{id}',[App\Http\Controllers\EstimateController::class, 'estimate_delete_item'])->name('estimate.delete_item');

    Route::resource('/directSales', App\Http\Controllers\DirectSalesController::class);
    Route::get('/checkInvoiceNumber', [App\Http\Controllers\DirectSalesController::class,'checkInvoiceNumber'])->name('checkInvoiceNumber');
    Route::get('/getCustomerDetails', [App\Http\Controllers\DirectSalesController::class,'getCustomerDetails'])->name('getCustomerDetails');
    Route::get('/getLatestInvoiceNumber', [App\Http\Controllers\DirectSalesController::class,'getLatestInvoiceNumber'])->name('getLatestInvoiceNumber');
    Route::get('/search_by_serial', [App\Http\Controllers\DirectSalesController::class,'searchBySerial'])->name('searchBySerial');
    Route::get('/search_by_serial_sale', [App\Http\Controllers\DirectSalesController::class,'search_by_serial_sale'])->name('search_by_serial_sale');

    Route::get('/add_servicer',[App\Http\Controllers\ChiplevelController::class, 'add_servicer'])->name('add_servicer');
    Route::get('/view_servicer',[App\Http\Controllers\ChiplevelController::class, 'view_servicer'])->name('view_servicer');
    Route::post('/update_servicer/{id}',[App\Http\Controllers\ChiplevelController::class, 'update_servicer'])->name('update_servicer');
    Route::post('/store/servicer',[App\Http\Controllers\ChiplevelController::class, 'store_servicer_single'])->name('store_servicer_single');
    Route::post('/store_servicer',[App\Http\Controllers\ChiplevelController::class, 'store_servicer'])->name('store_servicer');
    Route::post('service_store/{id}',[App\Http\Controllers\ChiplevelController::class, 'service_store'])->name('service_store');
    Route::post('update_warrenty/{id}',[App\Http\Controllers\ChiplevelController::class, 'update_warrenty'])->name('update_warrenty');
    Route::get('/get_servicer',[App\Http\Controllers\ChiplevelController::class, 'get_servicer'])->name('get_servicer');
    Route::get('/get_seller',[App\Http\Controllers\ChiplevelController::class, 'get_seller'])->name('get_seller');


    Route::post('/delete_accessories',[App\Http\Controllers\SalesController::class, 'delete_accessories'])->name('delete_accessories');
    Route::get('/updateBalance', [App\Http\Controllers\PurchaseController::class, 'updateBalance'])->name('updateBalance');

    Route::resource('/marketing', App\Http\Controllers\MarketingController::class);
    Route::get('/view/marketing/requests', [App\Http\Controllers\MarketingController::class, 'view_marketing_request'])->name('marketing.view_request');
    Route::get('/view/approved/requests', [App\Http\Controllers\MarketingController::class, 'view_approved'])->name('marketing.view_approved');
    Route::get('/view/rejected/requests', [App\Http\Controllers\MarketingController::class, 'view_rejected'])->name('marketing.view_rejected');
    Route::get('/view/all/requests', [App\Http\Controllers\MarketingController::class, 'view_all_request'])->name('marketing.view_all_request');
    Route::get('/marketing_summary', [App\Http\Controllers\MarketingController::class, 'marketing_summary'])->name('marketing.summary');
    Route::post('/marketing/summary/store', [App\Http\Controllers\MarketingController::class, 'store_marketing_summary'])->name('marketing.summary_store');
    Route::get('/marketing/view/summary', [App\Http\Controllers\MarketingController::class, 'marketing_view_summary'])->name('marketing.view_summary');
    Route::get('/marketing/view/all/summary', [App\Http\Controllers\MarketingController::class, 'marketing_view_all_summary'])->name('marketing.view_all_summary');
    Route::get('/marketing_view/datewise_request/{id}', [App\Http\Controllers\MarketingController::class, 'marketing_view_datewise_request'])->name('marketing.view_datewise_request');
    Route::get('/marketing_view/all_datewise_request/{id}', [App\Http\Controllers\MarketingController::class, 'marketing_view_all_datewise_request'])->name('marketing.view_all_datewise_request');
    Route::post('/marketing/approve_all/{id}', [App\Http\Controllers\MarketingController::class, 'marketing_approve_all'])->name('marketing.approve');

    Route::post('marketing_edit_name/{id}',[App\Http\Controllers\MarketingController::class, 'marketing_edit_name'])->name('marketing_edit_name');
    Route::post('marketing_edit_contact/{id}',[App\Http\Controllers\MarketingController::class, 'marketing_edit_contact'])->name('marketing_edit_contact');
    Route::post('marketing_edit_job_role/{id}',[App\Http\Controllers\MarketingController::class, 'marketing_edit_job_role'])->name('marketing_edit_job_role');
    Route::post('marketing_edit_company_name/{id}',[App\Http\Controllers\MarketingController::class, 'marketing_edit_company_name'])->name('marketing_edit_company_name');
    Route::post('marketing_edit_company_category/{id}',[App\Http\Controllers\MarketingController::class, 'marketing_edit_company_category'])->name('marketing_edit_company_category');
    Route::post('marketing_edit_company_place/{id}',[App\Http\Controllers\MarketingController::class, 'marketing_edit_company_place'])->name('marketing_edit_company_place');
    Route::post('marketing_edit_km_to_location/{id}',[App\Http\Controllers\MarketingController::class, 'marketing_edit_km_to_location'])->name('marketing_edit_km_to_location');
    Route::post('marketing_edit_petrol_amount/{id}',[App\Http\Controllers\MarketingController::class, 'marketing_edit_petrol_amount'])->name('marketing_edit_petrol_amount');
    Route::post('marketing_edit_visit/{id}',[App\Http\Controllers\MarketingController::class, 'marketing_edit_visit'])->name('marketing_edit_visit');
    Route::post('marketing_edit_remarks/{id}',[App\Http\Controllers\MarketingController::class, 'marketing_edit_remarks'])->name('marketing_edit_remarks');

    Route::get('/report/customer',[App\Http\Controllers\DaybookController::class,'customer_report'])->name('report.customer');

    Route::get('/getOpeningBalance', [App\Http\Controllers\DaybookController::class, 'getOpeningBalance'])->name('getOpeningBalance');

    Route::resource('/customers', App\Http\Controllers\CustomerController::class);
    Route::post('/addNewCustomer', [App\Http\Controllers\CustomerController::class, 'addNewCustomer'])->name('addNewCustomer');
    Route::get('/getCustomerSales/{id}',[App\Http\Controllers\CustomerController::class, 'getCustomerSales'])->name('getCustomerSales');
    Route::get('/jobcard_sales/{id}/show',[App\Http\Controllers\CustomerController::class, 'show_jobcard_sales'])->name('jobcard_sales.show');
    Route::get('/customer/export/csv',[App\Http\Controllers\CustomerController::class, 'export_csv'])->name('customers.export.csv');

    Route::post('/addSalesReturnInvoicePayment', [App\Http\Controllers\DaybookController::class, 'addSalesReturnInvoicePayment'])->name('addSalesReturnInvoicePayment');
    Route::post('/addInvoicePayment', [App\Http\Controllers\DaybookController::class, 'addInvoicePayment'])->name('addInvoicePayment');
    Route::post('/addJobcardInvoicePayment', [App\Http\Controllers\DaybookController::class, 'addJobcardInvoicePayment'])->name('addJobcardInvoicePayment');
    Route::post('/addExpensePayment', [App\Http\Controllers\DaybookController::class, 'addExpensePayment'])->name('addExpensePayment');
    Route::get('/updateCreditBalance', [App\Http\Controllers\DirectSalesController::class, 'updateCreditBalance'])->name('updateCreditBalance');
    Route::post('/generateReciept', [App\Http\Controllers\DaybookController::class, 'generateReciept'])->name('generateReciept');

    Route::get('/sales/invoice/{id}',[App\Http\Controllers\DirectSalesController::class, 'salesInvoice'])->name('salesInvoice');
    Route::post('/jobcard/summary',[App\Http\Controllers\DirectSalesController::class, 'store_jobcard_invoice'])->name('direct_sales.store_summary');
    Route::get('/stocks/stockout_products',[App\Http\Controllers\StockController::class, 'view_stockout_product'])->name('stockout_product');
    Route::post('/generateCustomerReport', [App\Http\Controllers\DirectSalesController::class, 'generateCustomerReport'])->name('generateCustomerReport');
    Route::post('/generateCompleteCustomerReport', [App\Http\Controllers\DirectSalesController::class, 'generateCompleteCustomerReport'])->name('generateCompleteCustomerReport');
    Route::get('/get_credit_list',[App\Http\Controllers\CustomerController::class, 'view_credit_list'])->name('customers.credit_list');
    Route::get('/credit_sales/{id}',[App\Http\Controllers\CustomerController::class, 'view_credit_sales'])->name('customers.credit_sales');
    Route::post('/customer/single_payment/{id}',[App\Http\Controllers\CustomerController::class, 'single_payment'])->name('customers.add_single_payment');

    Route::post('/cashTransfer', [App\Http\Controllers\DaybookController::class, 'cashTransfer'])->name('cashTransfer');
    Route::get('/purchaseIndex/{id}', [App\Http\Controllers\SellerController::class, 'purchaseIndex'])->name('purchaseIndex');
    Route::get('/sellerSummary/{id}', [App\Http\Controllers\SellerController::class, 'sellerSummary'])->name('sellerSummary');
    Route::post('/addPurchasePayment', [App\Http\Controllers\DaybookController::class, 'addPurchasePayment'])->name('addPurchasePayment');
    Route::post('/addSupplierPayment', [App\Http\Controllers\DaybookController::class, 'addSupplierPayment'])->name('addSupplierPayment');
    Route::post('/generateDaybookReport', [App\Http\Controllers\DaybookController::class, 'generateDaybookReport'])->name('generateDaybookReport');
    Route::post('/store_daybook_summary', [App\Http\Controllers\DaybookController::class, 'store_daybook_summary'])->name('store_daybook_summary');
    Route::get('/daybook_daily_report/{id}', [App\Http\Controllers\DaybookController::class, 'daybook_daily_report'])->name('daybook.daily_report');
    Route::get('/monthlyReport', [App\Http\Controllers\AdminController::class, 'monthlyReport'])->name('monthlyReport');
    Route::get('/generateMonthlyReport',[App\Http\Controllers\AdminController::class, 'generateMonthlyReport'])->name('generateMonthlyReport');
    Route::get('/generate_estimate/{id}',[App\Http\Controllers\EstimateController::class, 'generate_estimate'])->name('generate_estimate');
    Route::get('/generateSalesGSTReport',[App\Http\Controllers\DirectSalesController::class, 'generateSalesGSTReport'])->name('generateSalesGSTReport');
    Route::get('/generatePurchaseGSTReport',[App\Http\Controllers\PurchaseController::class, 'generatePurchaseGSTReport'])->name('generatePurchaseGSTReport');
    Route::get('/sendInvoiceSMS/{id}', [\App\Http\Controllers\DirectSalesController::class, 'sendInvoiceSMS'])->name('sendInvoiceSMS');
    Route::resource('/contact', App\Http\Controllers\ContactController::class);
    Route::get('/getDaybookValues', [\App\Http\Controllers\DaybookController::class, 'getDaybookValues'])->name('getDaybookValues');
    Route::post('/daybookSearch', [\App\Http\Controllers\DaybookController::class, 'daybookSearch'])->name('daybookSearch');
    Route::post('/updateKeywords', [App\Http\Controllers\AdminController::class, 'updateKeywords'])->name('updateKeywords');
    Route::get('/daybook/view/personal', [\App\Http\Controllers\DaybookController::class, 'view_personal'])->name('daybook.view_personal');
    Route::post('/daybook/search/personal', [\App\Http\Controllers\DaybookController::class, 'search_personal'])->name('daybook.search_personal');
    Route::get('/daybooks/get_item_total', [\App\Http\Controllers\DaybookController::class, 'get_item_total'])->name('daybook.get_item_total');

    // field work
    Route::resource('/field', App\Http\Controllers\FieldController::class);
    Route::post('/fields/add_purchase/{id}', [App\Http\Controllers\FieldController::class, 'store_purchase'])->name('field.store_purchase');
    Route::post('/fields/add_invoice/{id}', [App\Http\Controllers\FieldController::class, 'store_invoice'])->name('field.store_invoice');
    Route::post('/fields/edit_purchase/{id}', [App\Http\Controllers\FieldController::class, 'update_purchase'])->name('field.update_purchase');
    Route::post('/fields/deliver/{id}', [App\Http\Controllers\FieldController::class, 'deliver'])->name('field.deliver');
    Route::post('/fields/cancel/{id}', [App\Http\Controllers\FieldController::class, 'cancel'])->name('field.cancel');
    Route::post('/fields/approve/{id}', [App\Http\Controllers\FieldController::class, 'approve'])->name('field.approve');
    Route::post('/field_date/approve/{id}', [App\Http\Controllers\FieldController::class, 'approve_date'])->name('field_date.approve');
    Route::get('/fields/delivered/{id}', [App\Http\Controllers\FieldController::class, 'view_delivered'])->name('field.delivered');
    Route::get('/fields/date_delivered', [App\Http\Controllers\FieldController::class, 'view_date_delivered'])->name('field.date_delivered');
    Route::get('/fields/canceled', [App\Http\Controllers\FieldController::class, 'view_canceled'])->name('field.canceled');
    Route::get('/fields/approved', [App\Http\Controllers\FieldController::class, 'view_approved'])->name('field.approved');
    Route::get('/fields/view_all', [App\Http\Controllers\FieldController::class, 'view_all'])->name('field.view_all');
    Route::get('/fields/get_customers', [App\Http\Controllers\FieldController::class, 'getCustomers'])->name('field.getCustomers');

    //reports
    Route::get('reports/profit_summary', [App\Http\Controllers\ReportController::class, 'profit_summary'])->name('reports.profit_summary');
    Route::get('reports/month/generate_profit_summary', [App\Http\Controllers\ReportController::class, 'generate_profit_summary_month'])->name('reports.month.generate_profit_summary');
    Route::get('reports/date/generate_profit_summary', [App\Http\Controllers\ReportController::class, 'generate_profit_summary_date'])->name('reports.date.generate_profit_summary');
    Route::get('reports/monhtly_summary', [App\Http\Controllers\ReportController::class, 'monhtly_summary'])->name('reports.monhtly_summary');
    Route::get('reports/generate_monthly_summary', [App\Http\Controllers\ReportController::class, 'generate_monthly_summary'])->name('reports.generate_monthly_summary');

    Route::resource('groups',App\Http\Controllers\GroupController::class);
    Route::get('deleteGroup/{id}', [App\Http\Controllers\GroupController::class, 'deleteGroup'])->name('deleteGroup');

    Route::resource('journals', App\Http\Controllers\JournalController::class);

    //daybook prev routes
    Route::resource('/daybook_prev', App\Http\Controllers\DaybookPrevController::class);
    Route::get('/getPrevOpeningBalance', [App\Http\Controllers\DaybookPrevController::class, 'getPrevOpeningBalance'])->name('getPrevOpeningBalance');
    Route::get('/daybook_prevs/export/csv', [App\Http\Controllers\DaybookPrevController::class, 'export'])->name('prev_accounts.export.csv');

    //Proforma Invoice
    Route::resource('/proforma', App\Http\Controllers\ProformaInvoiceController::class);
    Route::get('/invoice_report/{id}', [App\Http\Controllers\ProformaInvoiceController::class, 'invoice_report'])->name('invoice_report');
    Route::get('/generate_invoice/{id}',[App\Http\Controllers\ProformaInvoiceController::class, 'generate_invoice'])->name('generate_invoice');

    //purchase order
    Route::resource('/purchase_order', App\Http\Controllers\PurchaseOrderController::class);
    Route::get('/purchase_orders/delivered', [PurchaseOrderController::class, 'delivered'])->name('purchase_order.delivered');
    Route::get('/getSellerDetails', [App\Http\Controllers\DirectSalesController::class,'getSellerDetails'])->name('getSellerDetails');
    Route::post('/purchase_order/{id}/delete',[App\Http\Controllers\PurchaseOrderController::class, 'delete_purchase_order'])->name('delete_purchase_order');
    Route::post('/purchase_order/new_item',[App\Http\Controllers\PurchaseOrderController::class, 'purchase_order_add_item'])->name('purchase_order.new_item');
    Route::post('/purchase_order/delete/{id}',[App\Http\Controllers\PurchaseOrderController::class, 'purchase_order_delete_item'])->name('purchase_order.delete_item');
    Route::post('/purchase_order/{id}/edit',[App\Http\Controllers\PurchaseOrderController::class, 'purchase_order_item_edit'])->name('purchase_order.edit.items');
    Route::post('/purchase_order/{id}/approve',[App\Http\Controllers\PurchaseOrderController::class, 'approve_purchase_order'])->name('purchase_order.approve');
    Route::get('/purchase_order_report/{id}', [App\Http\Controllers\PurchaseOrderController::class, 'purchase_order_report'])->name('purchase_order_report');
    Route::get('/generate_purchase_order/{id}',[App\Http\Controllers\PurchaseOrderController::class, 'generate_purchase_order'])->name('generate_purchase_order');

    // investment
    Route::resource('/investment', App\Http\Controllers\InvestmentController::class);
    Route::post('/investments/addInvestor',[App\Http\Controllers\InvestmentController::class, 'addInvestor'])->name('investor.store');
    Route::post('/investments/updateInvestor/{id}', [App\Http\Controllers\InvestmentController::class, 'updateInvestor'])->name('investor.update');
    Route::post('/investments/store-investment',[App\Http\Controllers\InvestmentController::class, 'storeInvestment'])->name('investor_investment.store');
    Route::post('/investments/store-withdrawal',[App\Http\Controllers\InvestmentController::class, 'storeWithdrawal'])->name('investor_withdrawal.store');
    Route::post('/generate-investor-report', [App\Http\Controllers\InvestmentController::class, 'generateInvestorReport'])->name('generateInvestorReport');

    // Banks
    Route::resource('/banks', App\Http\Controllers\BanksController::class);
    Route::put('/banks/disable/{id}', [App\Http\Controllers\BanksController::class , 'disable'])->name('banks.disable');
    Route::put('/banks/enable/{id}', [App\Http\Controllers\BanksController::class , 'enable'])->name('banks.enable');
    Route::post('/banks/invest', [App\Http\Controllers\BanksController::class , 'invest'])->name('banks.invest');
    Route::post('/banks/withdraw', [App\Http\Controllers\BanksController::class , 'withdraw'])->name('banks.withdraw');
    Route::post('/generate-bank-entry-report', [App\Http\Controllers\BanksController::class , 'generateBankEntryReport'])->name('generateBankEntryReport');

    //Maintenance Mode
    Route::get('/maintenance', [App\Http\Controllers\AdminController::class, 'maintenance'])->name('maintenance');

    Route::post('/customer/tall_balance',[App\Http\Controllers\CustomerController::class, 'tally_balance'])->name('customers.tally_balance');
});
Route::get('/user_invoice/{id}', [App\Http\Controllers\DirectSalesController::class, 'userInvoice'])->name('userInvoice');
Route::get('/user_estimate/{id}', [App\Http\Controllers\EstimateController::class, 'userEstimate'])->name('userEstimate');
Route::get('/user_job/{id}', [App\Http\Controllers\ConsignmentController::class, 'userJob'])->name('userJob');
Route::get('/Whatsapp_invoice/{id}', [App\Http\Controllers\DirectSalesController::class, 'WhatsappInvoice'])->name('WhatsappInvoice');
Route::get('/Whatsapp_consolidate_invoice/{id}', [App\Http\Controllers\ConsoulidateController::class, 'WhatsappConsolidateInvoice'])->name('WhatsappConsolidateInvoice');
Route::get('/Whatsapp_estimate/{id}', [App\Http\Controllers\EstimateController::class, 'WhatsappEstimate'])->name('WhatsappEstimate');
Route::get('/dailyReport/{id}', [App\Http\Controllers\DaybookController::class, 'dailyReport'])->name('dailyReport');
Route::get('/user_purchase_order/{id}', [App\Http\Controllers\PurchaseOrderController::class, 'whatsappPurchaseOrder'])->name('whatsappPurchaseOrder');
// Route::get('/sales/send-whatsapp/{id}', [App\Http\Controllers\DirectSalesController::class, 'sendInvoiceWhatsapp'])->name('sendInvoiceWhatsapp');

Route::get('/login/total-sales', [App\Http\Controllers\TotalSalesController::class, 'totalSalesLoginView'])->name('total_sales.details.mobile');
Route::post('/loginsubmit/total-sales', [App\Http\Controllers\TotalSalesController::class, 'totalSalesLogin'])->name('loginsubmit.total_ales');
Route::group(['middleware' => ['totalSales']], function () {
    Route::get('/loginsubmit/total-sales/view', [App\Http\Controllers\TotalSalesController::class, 'getTotalSalesDetailsMobile'])->name('loginsubmit.dashboard');
    Route::get('/logout/total-sales', [App\Http\Controllers\TotalSalesController::class, 'logout'])->name('total_sales.logout');
});
