<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\TrackVisitor;
use Illuminate\Support\Facades\Auth;

Route::middleware([TrackVisitor::class])->group(function () {
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
  Route::get('/ekstrakurikuler/{nama}', 'UserController@show')->name('ekstrakurikuler.show');
  Route::get('/strukturorganisasi', 'UserController@strukturorganisasi')->name('strukturorganisasi');
});

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
  Route::get('/dashboard', 'DashboardController@index')->name('dashboard')->middleware('auth');
  
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
    
  // Route abouts
  Route::get('/abouts', 'AboutProfileController@index')->name('abouts.index')->middleware('auth');
  Route::get('/abouts/create', 'AboutProfileController@create')->name('abouts.create')->middleware('auth');
  Route::post('/abouts', 'AboutProfileController@store')->name('abouts.store')->middleware('auth');
  Route::get('/abouts/{about}/edit', 'AboutProfileController@edit')->name('abouts.edit')->middleware('auth');
  Route::put('/abouts/{about}', 'AboutProfileController@update')->name('abouts.update')->middleware('auth');
  
  // Route pembiasaan
  Route::resource('pembiasaan', 'PembiasaanController')->except(['show']);
  Route::get('/kesiswaan/pembiasaan', 'PembiasaanController@index')->name('admin.kesiswaan.pembiasaan.index')->middleware('auth');
  Route::get('/kesiswaan/pembiasaan/create', 'PembiasaanController@create')->name('admin.kesiswaan.pembiasaan.create')->middleware('auth');
  Route::post('/kesiswaan/pembiasaan', 'PembiasaanController@store')->name('admin.kesiswaan.pembiasaan.store')->middleware('auth');
  Route::get('/kesiswaan/pembiasaan/{pembiasaan}/edit', 'PembiasaanController@edit')->name('admin.kesiswaan.pembiasaan.edit')->middleware('auth');
  Route::put('/kesiswaan/pembiasaan/{pembiasaan}', 'PembiasaanController@update')->name('admin.kesiswaan.pembiasaan.update')->middleware('auth');
  Route::delete('/kesiswaan/pembiasaan/{pembiasaan}/destroyrecycle', 'PembiasaanController@destroyrecycle')->name('admin.kesiswaan.pembiasaan.destroyrecycle')->middleware('auth');
  Route::delete('/kesiswaan/pembiasaan/{pembiasaan}', 'PembiasaanController@destroy')->name('admin.kesiswaan.pembiasaan.destroy')->middleware('auth');
  Route::post('/kesiswaan/pembiasaan/{pembiasaan}/restore', 'PembiasaanController@restore')->name('admin.kesiswaan.pembiasaan.restore')->middleware('auth');
  Route::post('/kesiswaan/pembiasaan/{pembiasaan}/publish', 'PembiasaanController@publish')->name('publish.pembiasaan')->middleware('auth');
  
  // Route kesiswaan
  Route::resource('kesiswaan', 'KesiswaanController')->except(['show']);
  Route::get('/kesiswaan/create', 'KesiswaanController@create')->name('admin.kesiswaan.kesiswaan.create')->middleware('auth');
  Route::post('/kesiswaan', 'KesiswaanController@store')->name('admin.kesiswaan.kesiswaan.store')->middleware('auth');
  Route::get('/kesiswaan/{kesiswaan}/edit', 'KesiswaanController@edit')->name('admin.kesiswaan.kesiswaan.edit')->middleware('auth');
  Route::put('/kesiswaan/{kesiswaan}', 'KesiswaanController@update')->name('admin.kesiswaan.kesiswaan.update')->middleware('auth');
  Route::delete('/kesiswaan/{kesiswaan}/destroyrecycle', 'KesiswaanController@destroyrecycle')->name('admin.kesiswaan.kesiswaan.destroyrecycle')->middleware('auth');
  Route::delete('/kesiswaan/{kesiswaan}', 'KesiswaanController@destroy')->name('admin.kesiswaan.kesiswaan.destroy')->middleware('auth');
  Route::post('/kesiswaan/{kesiswaan}/restore', 'KesiswaanController@restore')->name('admin.kesiswaan.kesiswaan.restore')->middleware('auth');
  Route::post('/kesiswaan/{kesiswaan}/publish', 'KesiswaanController@publish')->name('publish.kesiswaan')->middleware('auth');
  
  // Route penghargaan
  Route::resource('penghargaan', 'PenghargaanController')->except(['show']);
  Route::get('/kesiswaan/penghargaan', 'PenghargaanController@index')->name('admin.kesiswaan.penghargaan.index')->middleware('auth');
  Route::get('/kesiswaan/penghargaan/create', 'PenghargaanController@create')->name('admin.kesiswaan.penghargaan.create')->middleware('auth');
  Route::post('/kesiswaan/penghargaan', 'PenghargaanController@store')->name('admin.kesiswaan.penghargaan.store')->middleware('auth');
  Route::get('/kesiswaan/penghargaan/{penghargaan}/edit', 'PenghargaanController@edit')->name('admin.kesiswaan.penghargaan.edit')->middleware('auth');
  Route::put('/kesiswaan/penghargaan/{penghargaan}', 'PenghargaanController@update')->name('admin.kesiswaan.penghargaan.update')->middleware('auth');
  Route::delete('/kesiswaan/penghargaan/{penghargaan}/destroyrecycle', 'PenghargaanController@destroyrecycle')->name('admin.kesiswaan.penghargaan.destroyrecycle')->middleware('auth');
  Route::delete('/kesiswaan/penghargaan/{penghargaan}', 'PenghargaanController@destroy')->name('admin.kesiswaan.penghargaan.destroy')->middleware('auth');
  Route::post('/kesiswaan/penghargaan/{penghargaan}/restore', 'PenghargaanController@restore')->name('admin.kesiswaan.penghargaan.restore')->middleware('auth');
  Route::post('/kesiswaan/penghargaan/{penghargaan}/restore', 'PenghargaanController@restore')->name('admin.kesiswaan.penghargaan.restore')->middleware('auth');
  Route::post('/kesiswaan/penghargaan/{penghargaan}/publish', 'PenghargaanController@publish')->name('publish.penghargaan')->middleware('auth');
  
  // Route ekstrakurikuler
  Route::resource('ekstrakurikuler', 'EkstrakurikulerController')->except(['show']);
  Route::get('/kesiswaan/ekstrakurikuler', 'EkstrakurikulerController@index')->name('admin.kesiswaan.ekstrakurikuler.index')->middleware('auth');
  Route::get('/kesiswaan/ekstrakurikuler/create', 'EkstrakurikulerController@create')->name('admin.kesiswaan.ekstrakurikuler.create')->middleware('auth');
  Route::post('/kesiswaan/ekstrakurikuler', 'EkstrakurikulerController@store')->name('admin.kesiswaan.ekstrakurikuler.store')->middleware('auth');
  Route::get('/kesiswaan/ekstrakurikuler/{ekstrakurikuler}/edit', 'EkstrakurikulerController@edit')->name('admin.kesiswaan.ekstrakurikuler.edit')->middleware('auth');
  Route::put('/kesiswaan/ekstrakurikuler/{ekstrakurikuler}', 'EkstrakurikulerController@update')->name('admin.kesiswaan.ekstrakurikuler.update')->middleware('auth');
  Route::delete('/kesiswaan/ekstrakurikuler/{ekstrakurikuler}/destroyrecycle', 'EkstrakurikulerController@destroyrecycle')->name('admin.kesiswaan.ekstrakurikuler.destroyrecycle')->middleware('auth');
  Route::delete('/kesiswaan/ekstrakurikuler/{ekstrakurikuler}', 'EkstrakurikulerController@destroy')->name('admin.kesiswaan.ekstrakurikuler.destroy')->middleware('auth');
  Route::post('/kesiswaan/ekstrakurikuler/{ekstrakurikuler}/restore', 'EkstrakurikulerController@restore')->name('admin.kesiswaan.ekstrakurikuler.restore')->middleware('auth');
  Route::post('/kesiswaan/ekstrakurikuler/{ekstrakurikuler}/publish', 'EkstrakurikulerController@publish')->name('publish.ekstrakurikuler')->middleware('auth');
  
  // Route tatatertib
  Route::resource('tatatertib', 'TatatertibController')->except(['show']);
  Route::get('/kesiswaan/tatatertib', 'TatatertibController@index')->name('admin.kesiswaan.tatatertib.index')->middleware('auth');
  Route::get('/kesiswaan/tatatertib/create', 'TatatertibController@create')->name('admin.kesiswaan.tatatertib.create')->middleware('auth');
  Route::post('/kesiswaan/tatatertib', 'TatatertibController@store')->name('admin.kesiswaan.tatatertib.store')->middleware('auth');
  Route::get('/kesiswaan/tatatertib/{tatatertib}/edit', 'TatatertibController@edit')->name('admin.kesiswaan.tatatertib.edit')->middleware('auth');
  Route::put('/kesiswaan/tatatertib/{tatatertib}', 'TatatertibController@update')->name('admin.kesiswaan.tatatertib.update')->middleware('auth');
  Route::delete('/kesiswaan/tatatertib/{tatatertib}/destroyrecycle', 'TatatertibController@destroyrecycle')->name('admin.kesiswaan.tatatertib.destroyrecycle')->middleware('auth');
  Route::delete('/kesiswaan/tatatertib/{tatatertib}', 'TatatertibController@destroy')->name('admin.kesiswaan.tatatertib.destroy')->middleware('auth');
  Route::post('/kesiswaan/tatatertib/{tatatertib}/restore', 'TatatertibController@restore')->name('admin.kesiswaan.tatatertib.restore')->middleware('auth');
  Route::post('/kesiswaan/tatatertib/{tatatertib}/publish', 'TatatertibController@publish')->name('publish.tatatertib')->middleware('auth');

  // Route about
  Route::resource('about', 'AboutController')->except(['show']);
  Route::get('/about', 'AboutController@index')->name('admin.about.index')->middleware('auth');
  Route::get('/about/create', 'AboutController@create')->name('admin.about.create')->middleware('auth');
  Route::post('/about', 'AboutController@store')->name('admin.about.store')->middleware('auth');
  Route::get('/about/{about}/edit', 'AboutController@edit')->name('admin.about.edit')->middleware('auth');
  Route::put('/about/{about}', 'AboutController@update')->name('admin.about.update')->middleware('auth');
  Route::delete('/about/{about}/destroyrecycle', 'AboutController@destroyrecycle')->name('admin.about.destroyrecycle')->middleware('auth');
  Route::delete('/about/{about}', 'AboutController@destroy')->name('admin.about.destroy')->middleware('auth');
  Route::post('/about/{about}/restore', 'AboutController@restore')->name('admin.about.restore')->middleware('auth');
  Route::post('/about/{about}/publish', 'AboutController@publish')->name('publish.about')->middleware('auth');
});
