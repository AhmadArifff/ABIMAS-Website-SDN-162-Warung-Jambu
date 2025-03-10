<?php

namespace App\Http\Controllers;

use App\About;
use Illuminate\Http\Request;
use File;
use App\Pembiasaan;
use App\Kesiswaan;
use App\Ekstrakurikuler;
use App\Penghargaan;
use App\Tatatertib;
use App\User;

class AboutController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
    public function index()
    {
        $pembiasaan_all=Pembiasaan::where('p_status', 'DRAFT')->get();
        $publishedMenus = Kesiswaan::where('k_status', 'PUBLISH')->pluck('k_nama_menu')->toArray();

        $kesiswaa_all = Kesiswaan::where('k_status', 'DRAFT')
            ->whereNotIn('k_nama_menu', $publishedMenus) // Hanya mengambil DRAFT yang tidak punya PUBLISH dalam grupnya
            ->get();
        $publishedEkstrakurikulerNames = Ekstrakurikuler::where('e_status', 'PUBLISH')->pluck('e_nama_ekstrakurikuler')->toArray();

        $ekstrakurikuler_all = Ekstrakurikuler::where('e_status', 'DRAFT')
            ->whereNotIn('e_nama_ekstrakurikuler', $publishedEkstrakurikulerNames) // Hanya mengambil DRAFT yang tidak punya PUBLISH dalam grupnya
            ->get();
        $penghargaan_all=Penghargaan::where('ph_status', 'DRAFT')->get();
        $tatatertib_all=Tatatertib::where('t_status', 'DRAFT')->get();
        $user_all=User::all();
        $menu = 'About';

        $abouts = \App\About::get();
        // dd($abouts);
        return view('abouts.index', ['abouts' => $abouts , 'pembiasaan_all' => $pembiasaan_all, 'kesiswaa_all' => $kesiswaa_all, 'ekstrakurikuler_all' => $ekstrakurikuler_all, 'penghargaan_all' => $penghargaan_all, 'tatatertib_all' => $tatatertib_all, 'user_all' => $user_all, 'menu' => $menu]);
    }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
      //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
      //
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\About  $about
   * @return \Illuminate\Http\Response
   */
  public function show(About $about)
  {
      //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\About  $about
   * @return \Illuminate\Http\Response
   */
    public function edit($id)
    {
        $pembiasaan_all=Pembiasaan::where('p_status', 'DRAFT')->get();
        $publishedMenus = Kesiswaan::where('k_status', 'PUBLISH')->pluck('k_nama_menu')->toArray();

        $kesiswaa_all = Kesiswaan::where('k_status', 'DRAFT')
            ->whereNotIn('k_nama_menu', $publishedMenus) // Hanya mengambil DRAFT yang tidak punya PUBLISH dalam grupnya
            ->get();
        $publishedEkstrakurikulerNames = Ekstrakurikuler::where('e_status', 'PUBLISH')->pluck('e_nama_ekstrakurikuler')->toArray();

        $ekstrakurikuler_all = Ekstrakurikuler::where('e_status', 'DRAFT')
            ->whereNotIn('e_nama_ekstrakurikuler', $publishedEkstrakurikulerNames) // Hanya mengambil DRAFT yang tidak punya PUBLISH dalam grupnya
            ->get();
        $penghargaan_all=Penghargaan::where('ph_status', 'DRAFT')->get();
        $tatatertib_all=Tatatertib::where('t_status', 'DRAFT')->get();
        $user_all=User::all();

        $menu = 'About';
        $about = \App\About::findOrFail($id);
        return view('abouts.edit', ['about' => $about, 'pembiasaan_all' => $pembiasaan_all, 'kesiswaa_all' => $kesiswaa_all, 'ekstrakurikuler_all' => $ekstrakurikuler_all, 'penghargaan_all' => $penghargaan_all, 'tatatertib_all' => $tatatertib_all, 'user_all' => $user_all, 'menu' => $menu]);
    }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\About  $about
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
      $about = \App\About::findOrFail($id);

      \Validator::make($request->all(),[
          'caption'     => 'required|min:15',
      ])->validate();
      
      $about->caption         = $request->get('caption');        

      if($request->file('image')){
          // if($about->image && file_exists(storage_path('app/public/'.$about->image))){
          //     \Storage::delete('public/'.$about->image);
          // }

          if($about->image){
              File::delete('about_image/'.$about->image);
          }

          // $new_image = $request->file('image')->store('about_image', 'public');
          $nama_file = time()."_".$request->file('image')->getClientOriginalName();
          $new_image = $request->file('image')->move('about_image', $nama_file);
          $about->image = $nama_file;
      }

      $about->save();

      return redirect()->route('abouts.index')->with('success', 'Data successfully updated');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\About  $about
   * @return \Illuminate\Http\Response
   */
  public function destroy(About $about)
  {
      //
  }
}
