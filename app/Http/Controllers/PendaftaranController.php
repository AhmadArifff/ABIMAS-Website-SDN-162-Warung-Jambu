<?php

namespace App\Http\Controllers;

use App\Pendaftaran;
use Illuminate\Http\Request;
use File;

class PendaftaranController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $pendaftarans = \App\Pendaftaran::get();
    // dd($pendaftarans);
    return view('pendaftarans.index', ['pendaftarans' => $pendaftarans ]);
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
   * @param  \App\Pendaftaran  $pendaftaran
   * @return \Illuminate\Http\Response
   */
  public function show(Pendaftaran $pendaftaran)
  {
      //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Pendaftaran  $pendaftaran
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
      $pendaftaran = \App\Pendaftaran::findOrFail($id);
      return view('pendaftarans.edit', ['pendaftaran' => $pendaftaran]);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Pendaftaran  $pendaftaran
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
      $pendaftaran = \App\Pendaftaran::findOrFail($id);

      \Validator::make($request->all(),[
          'caption'     => 'required|min:15',
      ])->validate();
      
      $pendaftaran->caption         = $request->get('caption');        

      if($request->file('image')){
          // if($pendaftaran->image && file_exists(storage_path('app/public/'.$pendaftaran->image))){
          //     \Storage::delete('public/'.$pendaftaran->image);
          // }

          if($pendaftaran->image){
              File::delete('pendaftaran_image/'.$pendaftaran->image);
          }

          // $new_image = $request->file('image')->store('pendaftaran_image', 'public');
          $nama_file = time()."_".$request->file('image')->getClientOriginalName();
          $new_image = $request->file('image')->move('pendaftaran_image', $nama_file);
          $pendaftaran->image = $nama_file;
      }

      $pendaftaran->save();

      return redirect()->route('pendaftarans.index')->with('success', 'Data successfully updated');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Pendaftaran  $pendaftaran
   * @return \Illuminate\Http\Response
   */
  public function destroy(Pendaftaran $pendaftaran)
  {
      //
  }
}
