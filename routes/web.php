<?php

use App\Http\Livewire\CartComponent;
use App\Http\Livewire\HomeComponent;
use App\Http\Livewire\ShopComponent;
use App\Http\Livewire\AboutComponent;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\ReciboComponent;
use App\Http\Livewire\SearchComponent;
use App\Http\Livewire\ContactComponent;
use App\Http\Livewire\DetailsComponent;
use App\Http\Livewire\CategoryComponent;
use App\Http\Livewire\CheckoutComponent;
use App\Http\Controllers\HelperFunctions;
use App\Http\Controllers\ProfileController;
use App\Http\Livewire\Admin\OrderComponent;
use App\Http\Livewire\CustomTshirtComponent;
use App\Http\Livewire\Admin\CategoriesComponent;
use App\Http\Livewire\Admin\StatisticsComponent;
use App\Http\Livewire\User\OrdersHistoryComponent;
use App\Http\Livewire\User\UserDashboardComponent;
use App\Http\Livewire\Admin\AdminDashboardComponent;
use App\Http\Livewire\Admin\ColorsComponent;
use App\Http\Livewire\Admin\ImagesComponent;
use App\Http\Livewire\Employee\EmployeeDashboardComponent;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//Route::get('/default', function () {
//    return view('welcome');
//});

Route::get('/',HomeComponent::class)->name('home.index');
Route::get('/about',AboutComponent::class)->name('about');
Route::get('/contact',ContactComponent::class)->name('contact');

//Anónimo
Route::get('/product/{product}',DetailsComponent::class)->name('product.details');

Route::get('/shop',ShopComponent::class)->name('shop');

Route::GET('/cart',CartComponent::class)->name('shop.cart');

Route::get('/product-category/{name}',CategoryComponent::class)->name('product.category');

Route::get('/search',SearchComponent::class)->name('product.search');

Route::get('/merge_image64/{tshirt}/{estampa}/{background}',[HelperFunctions::class,'merge64'])->name('merge_imageb64');
Route::get('/merge_image/{tshirt}/{estampa}',[HelperFunctions::class,'merge'])->name('merge_tshirt');


// campo verified indica que o utilizador deve ter o email confirmado para poder acessar
// Quando se faz páginas especificamente para o user
Route::middleware(['auth','authuser','verified'])->group(function(){
    //dashboard user
    Route::get('/user/dashboard',UserDashboardComponent::class)->name('user.dashboard');
    Route::patch('/user/profile/address/{customer}', [UserDashboardComponent::class, 'update_address'])->name('profile.update.address');
    Route::put('/user/profile/photo/{user}', [UserDashboardComponent::class, 'update_photo'])->name('profile.update.photo');
    Route::get('/user/order/{order}',OrdersHistoryComponent::class)->name('user.order');

    //custom tshirt
    Route::get('/user/custom_product',CustomTshirtComponent::class)->name('custom.product');
    Route::post('/user/custom_product',[CustomTshirtComponent::class,'upload_photo'])->name('custom.photo');

    //checkout
    Route::get('/user/checkout',CheckoutComponent::class)->name('shop.checkout');
    Route::post('/user/checkout/{user}',[CheckoutComponent::class,'proceed_checkout'])->name('shop.proceed_checkout');

    //custom tshirts
    Route::get('/user/custom_tshirts',[UserDashboardComponent::class,'index_custom'])->name('user.custom.tshirts');
    Route::get('/user/select_custom_tshirts/{tshirt}',[UserDashboardComponent::class,'add_custom_tshirt'])->name('user.select.custom.tshirts');
    Route::delete('/user/custom_tshirts/{tshirt}',[UserDashboardComponent::class,'del_custom_tshirt'])->name('user.delete.custom.tshirt');

    //download/view PDF
    route::get('/user/download_pdf/{order}', [OrdersHistoryComponent::class, 'download_pdf'])->name('download.pdf');
    route::get('/user/show_pdf/{order}', [OrdersHistoryComponent::class, 'show_pdf'])->name('show.pdf');

    //Altera perfil (dados mais criticos)
    Route::get('/user/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/user/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/user/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

// Quando se faz páginas especificamente para o admin
Route::middleware(['auth', 'authadmin'])->group(function(){
    Route::get('/admin/statistics', StatisticsComponent::class)->name('admin.statistics');
    Route::get('/admin/search',[AdminDashboardComponent::class,'search'])->name('admin.search');
    Route::get('/admin/dashboard',AdminDashboardComponent::class)->name('admin.dashboard');
    Route::put('/admin/undodeleted',[AdminDashboardComponent::class,'undo_deleted'])->name('admin.undo.delete');
    Route::put('/admin/undoALLdeleted',[AdminDashboardComponent::class,'undo_all_deleted'])->name('admin.undoAllDeleted');


    Route::get('/admin/images',ImagesComponent::class)->name('admin.images');
    Route::post('/admin/new_image',[ImagesComponent::class,'new_image'])->name('admin.new.image');
    Route::put('/admin/images/{image}',[ImagesComponent::class,'edit_image'])->name('admin.edit.image');
    Route::delete('/admin/images/{image}',[ImagesComponent::class,'del_image'])->name('admin.destroy.image');

    //Alterações no catalogo
    Route::get('/admin/prices',[AdminDashboardComponent::class,'index_prices'])->name('admin.prices');
    Route::put('/admin/prices',[AdminDashboardComponent::class,'change_prices'])->name('admin.change.prices');

    Route::get('/admin/show_colors',ColorsComponent::class)->name('admin.colors');
    Route::post('/admin/add_color',[ColorsComponent::class,'add_color'])->name('admin.add.color');
    Route::put('/admin/edit_color/{color}',[ColorsComponent::class,'edit_color'])->name('admin.edit.color');
    Route::delete('/admin/delcolors/{color}',[ColorsComponent::class,'delete_color'])->name('admin.destroy.color');

    Route::get('/admin/categories',CategoriesComponent::class)->name('admin.categories');
    Route::post('/admin/category',[CategoriesComponent::class,'new_category'])->name('admin.create.category');
    Route::put('/admin/category/{category}',[CategoriesComponent::class,'update_category'])->name('admin.update.category');
    Route::delete('/admin/category/{category}',[CategoriesComponent::class,'delete_category'])->name('admin.destroy.category');

    Route::put('/admin/blockChange/{admin}',[AdminDashboardComponent::class,'block_change'])->name('admin.blockChange');

    Route::get('/admin/dashboard/order',OrderComponent::class)->name('admin.order');
    route::get('/admin/show_pdf/{order}', [OrderComponent::class, 'show_pdf'])->name('admin.show.pdf');
    route::get('/admin/download_pdf/{order}', [OrderComponent::class, 'download_pdf'])->name('admin.download.pdf');
    Route::put('/admin/dashboard/order',[OrderComponent::class,'changeStatus'])->name('admin.changeStatus');

    Route::resource('/admin', AdminDashboardComponent::class);
});

// Quando se faz páginas especificamente para o empregado/funcionario
Route::middleware(['auth', 'authemployee'])->group(function(){
    Route::get('/employee/dashboard',EmployeeDashboardComponent::class)->name('employee.dashboard');
    Route::put('/employee/dashboard',[EmployeeDashboardComponent::class,'changeStatus'])->name('employee.changeStatus');
    Route::get('/employee/change_password',[EmployeeDashboardComponent::class,'change_password'])->name('employee.change.password');
});


//Route::get('/dashboard', function () {
//    return view('dashboard');
//})->middleware(['auth', 'verified'])->name('dashboard');

//Route::middleware('auth')->group(function () {
//    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
//});

require __DIR__.'/auth.php';
