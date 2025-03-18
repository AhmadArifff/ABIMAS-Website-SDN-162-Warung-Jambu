<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Beasiswa;
use File;

class BeasiswaController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    $status     = $request->get('status');
    $keyword    = $request->get('keyword') ? $request->get('keyword') : '';
    $category   = $request->get('c') ? $request->get('c') : '';

    if($status){
      $beasiswas = Beasiswa::where('status', strtoupper($status))
                                    ->where('title', 'LIKE', "%$keyword%")
                                    ->orderBy('created_at', 'desc')
                                    ->paginate(10);

    }else{
      $beasiswas = Beasiswa::where('title', 'LIKE', "%$keyword%")
                                ->orderBy('created_at', 'desc')
                                ->paginate(10);
    }

    return view('beasiswas.index', compact('beasiswas'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
      return view('beasiswas.create');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
      \Validator::make($request->all(),[
          'title'      => 'required|min:2|max:200',
          'image'      => 'required',
      ])->validate();

      $new_Beasiswa               = new \App\Beasiswa;
      $new_Beasiswa->title        = $request->get('title');
      $new_Beasiswa->slug         = \Str::slug($request->get('title'), '-');
      $new_Beasiswa->content      = $request->get('content');
      $new_Beasiswa->create_by    = \Auth::user()->id;
      $new_Beasiswa->status       = $request->get('save_action');

      if($request->file('image')){
          $nama_file = time()."_".$request->file('image')->getClientOriginalName();
          $image_path = $request->file('image')->move('beasiswas_image', $nama_file);
          $new_Beasiswa->image = $nama_file;
      }

      
      $new_Beasiswa->save();

      return redirect()->route('beasiswas.index')->with('success', 'Beasiswa successfully created');
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
      //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
      $beasiswa = Beasiswa::findOrFail($id);
      return view('beasiswas.edit', compact('beasiswa'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
      $beasiswa = Beasiswa::findOrFail($id);

      $beasiswa->title        = $request->get('title');
      $beasiswa->slug         = \Str::slug($request->get('title'), '-');
      $beasiswa->content      = $request->get('content');
      $beasiswa->status       = $request->get('save_action');
      $beasiswa->update_by    = \Auth::user()->id;

      if($request->file('image')){   
          if($beasiswa->image){
              File::delete('beasiswas_image/'.$beasiswa->image);
          }
          $nama_file = time()."_".$request->file('image')->getClientOriginalName();
          $new_image = $request->file('image')->move('beasiswas_image', $nama_file);
          $beasiswa->image = $nama_file;
      }

      $beasiswa->save();
      return redirect()->route('beasiswas.index')->with('success', 'beasiswa successfully update.');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
      $beasiswa = Beasiswa::findOrFail($id);
      if($beasiswa->image){
          File::delete('beasiswas_image/'.$beasiswa->image);
      }
      $beasiswa->forceDelete();

      return redirect()->route('beasiswas.index')->with('success', 'beasiswa successfully deleted.');
  }
}
