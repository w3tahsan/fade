<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CustomerLoginController;
use App\Http\Controllers\CustomerRegisterController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\GithubController;
use App\Http\Controllers\GoogleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleManagementController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SslCommerzPaymentController;
use App\Http\Controllers\StripePaymentController;

Auth::routes();
Route::get('/home', [HomeController::class, 'index'])->name('home');

//frontend
Route::get('/', [FrontendController::class, 'welcome'])->name('index');
Route::get('/product/details/{product_slug}', [FrontendController::class, 'product_details'])->name('product.details');
Route::post('/getSize', [FrontendController::class, 'getSize']);
Route::get('/cart', [FrontendController::class, 'cart'])->name('cart');
Route::get('/checkout', [FrontendController::class, 'checkout'])->name('checkout');
Route::get('/account', [FrontendController::class, 'account'])->name('account');
Route::get('/shop', [FrontendController::class, 'shop'])->name('shop');
Route::post('/getStock', [FrontendController::class, 'getStock']);

//users
Route::get('/users', [UserController::class, 'users'])->name('users');
Route::get('/delete/user/{user_id}', [UserController::class, 'delete'])->name('del.user');
Route::get('/profile', [UserController::class, 'profile'])->name('profile');
Route::post('/name/change', [UserController::class, 'name_change'])->name('name.change');
Route::post('/password/change', [UserController::class, 'password_change'])->name('password.change');
Route::post('/photo/change', [UserController::class, 'photo_change'])->name('photo.change');

//category
Route::get('/category/list', [CategoryController::class, 'category'])->name('category');
Route::post('/category/store', [CategoryController::class, 'store'])->name('category.store');
Route::get('/category/delete/{category_id}', [CategoryController::class, 'delete'])->name('category.delete');
Route::get('/category/hard/delete/{category_id}', [CategoryController::class, 'hard_delete'])->name('category.hard.delete');
Route::get('/category/restore/{category_id}', [CategoryController::class, 'category_restore'])->name('category.restore');
Route::get('/category/edit/{category_id}', [CategoryController::class, 'category_edit'])->name('category.edit');
Route::post('/category/update', [CategoryController::class, 'category_update'])->name('category.update');

//subcategory
Route::get('subcategory', [SubcategoryController::class, 'subcategory'])->name('subcategory');
Route::post('subcategory/store', [SubcategoryController::class, 'subcategory_store'])->name('subcategory.store');
Route::get('subcategory/edit/{subcategory_id}', [SubcategoryController::class, 'subcategory_edit'])->name('subcategory.edit');
Route::post('subcategory/update', [SubcategoryController::class, 'subcategory_update'])->name('subcategory.update');
Route::get('subcategory/delete/{subcategory_id}', [SubcategoryController::class, 'subcategory_delete'])->name('subcategory.delete');

//Product
Route::get('add/product',[ProductController::class, 'add_product'])->name('add.product');
Route::post('/getSubcategory',[ProductController::class, 'getSubcategory']);
Route::post('/product/store',[ProductController::class, 'product_store'])->name('product.store');
Route::get('/product/list',[ProductController::class, 'product_list'])->name('product.list');
Route::get('/product/color/size',[ProductController::class, 'color_size'])->name('add.color.size');
Route::post('add/color',[ProductController::class, 'add_color'])->name('add.color');
Route::post('add/size',[ProductController::class, 'add_size'])->name('add.size');
Route::get('inventory/{product_id}',[ProductController::class, 'inventory'])->name('inventory');
Route::post('add/inventory',[ProductController::class, 'add_inventory'])->name('add.inventory');


//Customer
Route::get('/customer/register/', [CustomerRegisterController::class, 'customer_register'])->name('customer.login.register');
Route::post('/customer/register/store', [CustomerRegisterController::class, 'customer_register_store'])->name('customer.register.store');
Route::post('/customer/login', [CustomerLoginController::class, 'customer_login'])->name('customer.logion');
Route::get('/customer/logout', [CustomerLoginController::class, 'customer_logout'])->name('customer.logout');
Route::get('invoice/downlaod/{order_id}', [CustomerController::class, 'invoicedownlaod'])->name('invoicedownlaod');


//Cart
Route::post('/cart/store', [CartController::class, 'cart_store'])->name('cart.store');
Route::get('/cart/remove/{cart_id}', [CartController::class, 'cart_remove'])->name('remove.cart');
Route::post('/cart/update', [CartController::class, 'cart_update'])->name('cart.update');


//coupon
Route::get('/coupon', [CouponController::class, 'coupon'])->name('coupon');
Route::post('/coupon/store', [CouponController::class, 'coupon_store'])->name('coupon.store');

//Checkout
Route::post('/getCity', [CheckoutController::class, 'getCity']);
Route::post('/order/store', [CheckoutController::class, 'order_store'])->name('order.store');
Route::get('/order/success', [CheckoutController::class, 'order_success'])->name('order.success');

// SSLCOMMERZ Start
Route::get('/example2', [SslCommerzPaymentController::class, 'exampleHostedCheckout']);
Route::get('/pay', [SslCommerzPaymentController::class, 'index'])->name('pay');
Route::post('/success', [SslCommerzPaymentController::class, 'success']);
Route::post('/fail', [SslCommerzPaymentController::class, 'fail']);
Route::post('/cancel', [SslCommerzPaymentController::class, 'cancel']);
Route::post('/ipn', [SslCommerzPaymentController::class, 'ipn']);


//Stripe
Route::post('stripe', [StripePaymentController::class, 'stripePost'])->name('stripe.post');

//review
Route::post('/review', [CustomerController::class, 'review'])->name('review');


//Password Reset
Route::get('/password/reset/request/form', [CustomerController::class, 'password_reset_request_form'])->name('password.reset.request.form');
Route::post('/password/reset/request/send', [CustomerController::class, 'password_reset_request_send'])->name('pass.reset.req.send');
Route::get('/password/reset/form/{reset_token}', [CustomerController::class, 'password_reset_form'])->name('pass.reset.form');
Route::post('/password/reset/update', [CustomerController::class, 'pass_reset_update'])->name('pass.reset.update');

//Email Verify
Route::get('/verify/email/{verify_token}', [CustomerController::class, 'email_veify'])->name('verify.email');


//Github Login
Route::get('/github/redirect', [GithubController::class, 'redirect_provider']);
Route::get('/github/callback', [GithubController::class, 'provider_to_application']);

//Google Login
Route::get('/google/redirect', [GoogleController::class, 'redirect_provider']);
Route::get('/google/callback', [GoogleController::class, 'provider_to_application']);

//Facebook Login
Route::get('/facebook/redirect', [GoogleController::class, 'redirect_provider']);
Route::get('/facebook/callback', [GoogleController::class, 'provider_to_application']);


//Role Manager
Route::get('/role/manager', [RoleManagementController::class, 'role_manager'])->name('role.manager');
Route::post('/add/permission', [RoleManagementController::class, 'add_permission'])->name('add.permission');
Route::post('/add/role', [RoleManagementController::class, 'add_role'])->name('add.role');
Route::post('/assign/role', [RoleManagementController::class, 'assign_role'])->name('assign.role');
Route::get('/edit/permission/{user_id}', [RoleManagementController::class, 'edit_permission'])->name('edit.permission');
Route::post('/update/permission', [RoleManagementController::class, 'update_permission'])->name('update.permission');
Route::get('/remove/role/{user_id}', [RoleManagementController::class, 'remove_role'])->name('remove.role');
Route::get('/role/edit/{role_id}', [RoleManagementController::class, 'role_edit'])->name('role.edit');
Route::post('/role/update', [RoleManagementController::class, 'role_update'])->name('update.role');


//orders manaagement
Route::get('/orders', [OrderController::class, 'orders'])->name('orders');
Route::post('/order/status', [OrderController::class, 'order_status'])->name('order.status');
