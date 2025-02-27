<?php

Route::get('/', function(){return redirect('/home');});
Route::get('/home', 'UserController@home')->name('home');
Route::get('/blog', 'UserController@blog')->name('blog');
Route::get('/blog/{slug}', 'UserController@show_article')->name('blog.show');
Route::get('/destination', 'UserController@destination')->name('destination');
Route::get('/destination/{slug}', 'UserController@show_destination')->name('destination.show');
Route::get('/contact', 'UserController@contact')->name('contact');
Route::get('/berita', 'UserController@berita')->name('berita');
Route::get('/tatatertib', 'UserController@tatatertib')->name('tatatertib');
Route::get('/pembiasaan', 'UserController@pembiasaan')->name('pembiasaan');
Route::get('/penghargaan', 'UserController@penghargaan')->name('penghargaan');
Route::get('/strukturorganisasi', 'UserController@strukturorganisasi')->name('strukturorganisasi');

Route::get('/ekstrakurikuler/pramuka', 'UserController@ekstrakurikuler_pramuka')->name('ekstrakurikuler.pramuka');
Route::get('/ekstrakurikuler/kesenian', 'UserController@ekstrakurikuler_kesenian')->name('ekstrakurikuler.kesenian');
Route::get('/ekstrakurikuler/karate', 'UserController@ekstrakurikuler_karate')->name('ekstrakurikuler.karate');
Route::get('/ekstrakurikuler/silat', 'UserController@ekstrakurikuler_silat')->name('ekstrakurikuler.silat');
Route::get('/ekstrakurikuler/olimpiade', 'UserController@ekstrakurikuler_olimpiade')->name('ekstrakurikuler.olimpiade');
Route::get('/ekstrakurikuler/paskibra', 'UserController@ekstrakurikuler_paskibra')->name('ekstrakurikuler.paskibra');
Route::get('/ekstrakurikuler/hoki', 'UserController@ekstrakurikuler_hoki')->name('ekstrakurikuler.hoki');
Route::get('/ekstrakurikuler/pmr', 'UserController@ekstrakurikuler_pmr')->name('ekstrakurikuler.pmr');
Route::get('/ekstrakurikuler/renang', 'UserController@ekstrakurikuler_renang')->name('ekstrakurikuler.renang');

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
    
  // Route about
  Route::get('/abouts', 'AboutController@index')->name('abouts.index')->middleware('auth');
  Route::get('/abouts/{about}/edit', 'AboutController@edit')->name('abouts.edit')->middleware('auth');
  Route::put('/abouts/{about}', 'AboutController@update')->name('abouts.update')->middleware('auth');
    
    
});