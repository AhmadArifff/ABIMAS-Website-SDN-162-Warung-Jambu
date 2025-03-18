<?php

use Illuminate\Support\Facades\Route;
// use App\Http\Middleware\TrackVisitor;
use Illuminate\Support\Facades\Auth;

Route::get('/', function(){ return redirect('/home'); });

// Route::middleware(['trackvisitor'])->group(function () {
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
  Route::get('/pembiasaan/detail/{id}', 'UserController@pembiasaandetail')->name('pembiasaan.detail');
  Route::get('/penghargaan/detail/{id}', 'UserController@penghargaandetail')->name('penghargaan.detail');
// });

Route::prefix('admin')->group(function(){
  Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login')->withoutMiddleware(['trackvisitor']);
  Route::post('/login', 'Auth\LoginController@login')->name('login.post')->withoutMiddleware(['trackvisitor']);
  Route::post('/logout', 'Auth\LoginController@logout')->name('logout')->withoutMiddleware(['trackvisitor']);

  Route::get('/', function () {
    return redirect()->route('dashboard');
  })->middleware('auth');

  Route::match(['GET', 'POST'], '/register', function () {
    return redirect('/login');
  })->name('register')->withoutMiddleware(['trackvisitor']);

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

  // Route berita
  Route::resource('berita', 'BeritaController')->except(['show']);
  Route::get('/berita', 'BeritaController@index')->name('admin.berita.index')->middleware('auth');
  Route::get('/berita/create', 'BeritaController@create')->name('admin.berita.create')->middleware('auth');
  Route::post('/berita', 'BeritaController@store')->name('admin.berita.store')->middleware('auth');
  Route::get('/berita/{berita}/edit', 'BeritaController@edit')->name('admin.berita.edit')->middleware('auth');
  Route::put('/berita/{berita}', 'BeritaController@update')->name('admin.berita.update')->middleware('auth');
  Route::delete('/berita/{berita}/destroyrecycle', 'BeritaController@destroyrecycle')->name('admin.berita.destroyrecycle')->middleware('auth');
  Route::delete('/berita/{berita}', 'BeritaController@destroy')->name('admin.berita.destroy')->middleware('auth');
  Route::post('/berita/{berita}/restore', 'BeritaController@restore')->name('admin.berita.restore')->middleware('auth');
  Route::post('/berita/{berita}/publish', 'BeritaController@publish')->name('publish.berita')->middleware('auth');

  // Route users
  Route::resource('users', 'UsersController')->except(['show']);
  Route::get('/users', 'UsersController@index')->name('admin.users.index')->middleware('auth');
  Route::get('/users/create', 'UsersController@create')->name('admin.users.create')->middleware('auth');
  Route::post('/users', 'UsersController@store')->name('admin.users.store')->middleware('auth');
  Route::get('/users/{user}/edit', 'UsersController@edit')->name('admin.users.edit')->middleware('auth');
  Route::put('/users/{user}', 'UsersController@update')->name('admin.users.update')->middleware('auth');
  Route::delete('/users/{user}/destroyrecycle', 'UsersController@destroyrecycle')->name('admin.users.destroyrecycle')->middleware('auth');
  Route::delete('/users/{user}', 'UsersController@destroy')->name('admin.users.destroy')->middleware('auth');
  Route::post('/users/{user}/restore', 'UsersController@restore')->name('admin.users.restore')->middleware('auth');
  Route::post('/users/{user}/publish', 'UsersController@publish')->name('publish.users')->middleware('auth');

  // Route informasi & media sosial
  Route::get('/informasi-media', 'InformasiMediaController@index')->name('admin.informasi-media.index')->middleware('auth');
  Route::get('/informasi-media/create', 'InformasiMediaController@create')->name('admin.informasi-media.create')->middleware('auth');
  Route::post('/informasi-media', 'InformasiMediaController@store')->name('admin.informasi-media.store')->middleware('auth');
  Route::get('/informasi-media/{informasiMedia}/edit', 'InformasiMediaController@edit')->name('admin.informasi-media.edit')->middleware('auth');
  Route::put('/informasi-media/{informasiMedia}', 'InformasiMediaController@update')->name('admin.informasi-media.update')->middleware('auth');
  Route::delete('/informasi-media/{informasiMedia}/destroyrecycle', 'InformasiMediaController@destroyrecycle')->name('admin.informasi-media.destroyrecycle')->middleware('auth');
  Route::delete('/informasi-media/{informasiMedia}', 'InformasiMediaController@destroy')->name('admin.informasi-media.destroy')->middleware('auth');
  Route::post('/informasi-media/{informasiMedia}/restore', 'InformasiMediaController@restore')->name('admin.informasi-media.restore')->middleware('auth');
  Route::post('/informasi-media/{informasiMedia}/publish', 'InformasiMediaController@publish')->name('publish.informasi-media')->middleware('auth');
});
