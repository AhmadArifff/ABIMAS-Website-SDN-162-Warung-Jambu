<?php
use App\Http\Controllers\GuruController;
use Illuminate\Support\Facades\Route;

Route::resource('guru', 'GuruController')->middleware('auth');
Route::get('/guru-user', [GuruController::class, 'userIndex'])->name('user.guru.index');
Route::get('/guru-user/{id}', [GuruController::class, 'userShow'])->name('user.guru.show');
Route::get('/daftar-guru', [GuruController::class, 'userView'])->name('guru.userView');

Route::get('/', function(){return redirect('/home');});
Route::get('/home', 'UserController@home')->name('home');
Route::get('/informasi', 'UserController@informasi')->name('informasi');
Route::get('/blog', 'UserController@blog')->name('blog');
Route::get('/blog/{slug}', 'UserController@show_article')->name('blog.show');
Route::get('/destination', 'UserController@destination')->name('destination');
Route::get('/destination/{slug}', 'UserController@show_destination')->name('destination.show');
Route::get('/contact', 'UserController@contact')->name('contact');
Route::get('/user-guru', 'UserController@show')->name('guru');
Route::get('/beasiswa', 'UserController@beasiswa')->name('beasiswa');
Route::get('/beasiswa/{slug}', 'UserController@show_beasiswa')->name('beasiswa.show');

Route::prefix('admin')->group(function(){

  Route::get('/', function(){
    return view('auth/login');
  });
  
  // handle route register
  Route::match(["GET", "POST"], "/register", function(){ 
    return redirect("/login"); 
  })->name("register");
  
  Auth::routes();
  
  // Route Dashboard
  Route::get('/dashboard', 'DashboardController@index')->middleware('auth');
  
  // route categories
  Route::get('/categories/{category}/restore', 'CategoryController@restore')->name('categories.restore');
  Route::delete('/categories/{category}/delete-permanent', 'CategoryController@deletePermanent')->name('categories.delete-permanent');
  Route::get('/ajax/categories/search', 'CategoryController@ajaxSearch');
  Route::resource('categories', 'CategoryController')->middleware('auth');
  
  // route article
  Route::post('/articles/upload', 'ArticleController@upload')->name('articles.upload')->middleware('auth');
  Route::resource('/articles', 'ArticleController')->middleware('auth');
  
  // route destination
  Route::resource('/destinations', 'DestinationController')->middleware('auth');
  Route::resource('/beasiswas', 'BeasiswaController')->middleware('auth');
    
  // Route about
  Route::get('/abouts', 'AboutController@index')->name('abouts.index')->middleware('auth');
  Route::get('/abouts/{about}/edit', 'AboutController@edit')->name('abouts.edit')->middleware('auth');
  Route::put('/abouts/{about}', 'AboutController@update')->name('abouts.update')->middleware('auth');
  
// Route pendaftaran
Route::get('/pendaftarans', 'PendaftaranController@index')->name('pendaftarans.index')->middleware('auth');
Route::get('/pendaftarans/{pendaftaran}/edit', 'PendaftaranController@edit')->name('pendaftarans.edit')->middleware('auth');
Route::put('/pendaftarans/{pendaftaran}', 'PendaftaranController@update')->name('pendaftarans.update')->middleware('auth');
  

    
});