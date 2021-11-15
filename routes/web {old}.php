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
Auth::routes();


Route::get('/', 'HomeController@index')->name('home');
Route::get('/produto/{slug}', 'HomeController@single')->name('produto.single');
Route::get('categorias/{category}', 'CategoriesController@index')->name('categorias');
Route::get('subcategorias/{category}', 'CategoriesController@subCategoryIndex')->name('sub_categorias');
Route::post('encontre', 'SearchController@index')->name('search');
Route::prefix('cart')->name('cart.')->group(function(){
    Route::get('/', 'CartController@index')->name('index');
    
        Route::group(['middleware' => ['amount.check']], function (){
            //Route::post('add', 'CartOptionController@add')->name('add');
            Route::post('add', 'CartController@add')->name('add');
        });

    Route::group(['middleware' => ['cartOp.check']], function (){
        //Route::post('cartOperator', 'CartOptionController@cartOperator')->name('cartOp');
        Route::post('cartOperator', 'CartController@cartOperator')->name('cartOp');
    });
    Route::get('remove/{product}', 'CartController@remove')->name('remove');
    Route::post('remove/', 'CartOptionController@removeJS')->name('remove.js');
    Route::get('cencel', 'CartOptionController@cancel')->name('cancel');
    //Route::get('cencel', 'CartController@cancel')->name('cancel');
});

    Route::get('/areadocliente', 'UserPanelController@index')->name('cliente');
    Route::get('/areadocliente/endereço', 'UserPanelController@address')->name('cliente.endereço');
    Route::get('/areadocliente/pedidos', 'UserPanelController@orders')->name('cliente.pedidos');
    Route::get('/areadocliente/editardados/{user}', 'UserPanelController@dataShow')->name('editar.dadospessoais');
    Route::put('/update/{user}', 'Admin\UserController@update')->name('atualizar.cliente');
    Route::get('/areadocliente/editarendereço/{user}', 'UserPanelController@addressShow')->name('editar.endereco');
    Route::put('/updateendereco/{user}', 'Admin\UserController@updateAddress')->name('atualizar.endereco');
    Route::post('/favoritar', 'FavoritesController@favorite')->name('favorite');
    Route::post('/desfavoritar', 'FavoritesController@unfavorite')->name('unfavorite');
    Route::prefix('checkout')->name('checkout.')->group(function(){
        Route::get('/endereco', 'CheckoutController@index')->name('index');
        Route::post('/criarendereco', 'CheckoutController@createAddress')->name('create.address');
        Route::post('/editarndereco/{address}', 'CheckoutController@updateAddress')->name('update.address');
        Route::post('/deletarendereco', 'CheckoutController@deleteAddress')->name('delete.address');
        Route::post('/setendereco', 'CheckoutController@setAddress')->name('set.address');
        Route::group(['middleware' => ['address.check']], function (){
            Route::get('/entrega', 'CheckoutController@indexShipping')->name('index.shipping');
            Route::get('/listafretes', 'CheckoutController@getShippings')->name('get.shipping');
            Route::post('/setfretes', 'CheckoutController@setShipping')->name('set.shipping');
            Route::get('/pagamento', 'CheckoutController@indexPayment')->name('index.payment');
        });
        Route::post('/fretes', 'CheckoutController@fretes')->name('correios');
        Route::post('/proccess', 'CheckoutController@proccess')->name('proccess');
        Route::get('/whatsapp', 'CheckoutController@whatsapp')->name('whatsapp');
        Route::get('/whatsfinish', 'CheckoutController@whatsappFinish')->name('whats.finish');
        //rotas acessadas no ajax do pagamento
        Route::get('/obrigado', 'CheckoutController@telaObrigado')->name('obrigado');
        Route::get('/erro', 'CheckoutController@error')->name('error');
        Route::post('/notification', 'CheckoutController@notification')->name('notification');
    });


Route::group(['middleware' => ['auth', 'auth.admin']], function () {
    Route::prefix('admin')->name('admin.')->namespace('Admin')->group(function(){
        Route::resource('dashboard', 'DashboardController');
        Route::resource('products', 'ProductsController');
        Route::resource('options', 'OptionsController');
        Route::post('image/remove/', 'ProductsimagesController@removeImage')->name('image.remove');
        Route::resource('categories', 'CategoriesController');
        Route::get('edit/{category}', 'CategoriesController@editSubCategory')->name('subcategory.edit');
        Route::post('update{category}', 'CategoriesController@updateSubCategories')->name('subcategory.update');
        Route::resource('users', 'UserController');
        Route::resource('sales', 'SalesController');
        Route::post('sales/codigo-rastreio/{sale}', 'SalesController@codigoEnvio')->name('codigo-rastreio');
        Route::get('/sessions', 'SessionsController@index')->name('session.index');
        Route::get('/frontend', 'FrontController@index')->name('front.index');
        Route::resource('testimonial', 'TestimonialsController');
        Route::resource('header', 'HeaderController');
        Route::resource('upcontent', 'UpContentController');
        Route::resource('midcontent', 'MiddleContentController');
        Route::post('upcontent/news', 'UpContentController@news')->name('upcontent.news');
    });
});