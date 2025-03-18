<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Berita;
use App\Kesiswaan;
use App\Ekstrakurikuler;
use App\Penghargaan;
use App\Pembiasaan;
use App\Tatatertib;
use App\User;
use Illuminate\Support\Facades\File;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (auth()->user()->role !== 'admin' && auth()->user()->role !== 'guru') {
                return redirect()->route('dashboard')->withErrors(['error' => 'Anda tidak memiliki akses ke halaman ini']);
            }
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        $menu = 'Users';
        $berita = Berita::query();
        $kesiswaan = Kesiswaan::query();
        $ekstrakurikuler = Ekstrakurikuler::query();
        $penghargaan = Penghargaan::query();
        $tatatertib = Tatatertib::query();
        $user = User::query();

        if ($request->has('role')) {
            $user->where('role', $request->role);
        }
        $berita_all = Berita::where('b_status', 'DRAFT')->get();
        $publishedMenus = Kesiswaan::where('k_status', 'PUBLISH')->pluck('k_nama_menu')->toArray();

        $kesiswaa_all = Kesiswaan::where('k_status', 'DRAFT')
            ->whereNotIn('k_nama_menu', $publishedMenus) // Hanya mengambil DRAFT yang tidak punya PUBLISH dalam grupnya
            ->get();

        $publishedEkstrakurikulerNames = Ekstrakurikuler::where('e_status', 'PUBLISH')->pluck('e_nama_ekstrakurikuler')->toArray();

        $ekstrakurikuler_all = Ekstrakurikuler::where('e_status', 'DRAFT')
            ->whereNotIn('e_nama_ekstrakurikuler', $publishedEkstrakurikulerNames) // Hanya mengambil DRAFT yang tidak punya PUBLISH dalam grupnya
            ->get();
        $penghargaan_all = Penghargaan::where('ph_status', 'DRAFT')->get();
        $tatatertib_all = Tatatertib::where('t_status', 'DRAFT')->get();
        $pembiasaan_all= Pembiasaan::where('p_status', 'DRAFT')->get();
        $user_all = User::all();
        $kesiswaan->where('k_nama_menu', $menu);
        $berita = $berita->paginate(10);
        $kesiswaan = $kesiswaan->paginate(10);
        $user = $user->paginate(10);
        $user_all = User::where('role', 'guru')->get();
    
        return view('users.index', compact('berita', 'kesiswaan', 'ekstrakurikuler', 'penghargaan', 'tatatertib', 'user', 'menu', 'kesiswaa_all', 'ekstrakurikuler_all', 'penghargaan_all', 'tatatertib_all', 'user_all', 'berita_all', 'pembiasaan_all'));
    }

    public function create(Request $request)
    {
        $berita_all = Berita::where('b_status', 'DRAFT')->get();
        $publishedMenus = Kesiswaan::where('k_status', 'PUBLISH')->pluck('k_nama_menu')->toArray();

        $kesiswaa_all = Kesiswaan::where('k_status', 'DRAFT')
            ->whereNotIn('k_nama_menu', $publishedMenus) // Hanya mengambil DRAFT yang tidak punya PUBLISH dalam grupnya
            ->get();
        $publishedEkstrakurikulerNames = Ekstrakurikuler::where('e_status', 'PUBLISH')->pluck('e_nama_ekstrakurikuler')->toArray();

        $ekstrakurikuler_all = Ekstrakurikuler::where('e_status', 'DRAFT')
            ->whereNotIn('e_nama_ekstrakurikuler', $publishedEkstrakurikulerNames) // Hanya mengambil DRAFT yang tidak punya PUBLISH dalam grupnya
            ->get();
        $penghargaan_all = Penghargaan::where('ph_status', 'DRAFT')->get();
        $tatatertib_all = Tatatertib::where('t_status', 'DRAFT')->get();
        $pembiasaan_all= Pembiasaan::where('p_status', 'DRAFT')->get();
        $user_all = User::all();
        
        $menu = $request->query('menu');
        return view('users.create', compact('menu', 'kesiswaa_all', 'ekstrakurikuler_all', 'penghargaan_all', 'tatatertib_all', 'user_all', 'berita_all', 'pembiasaan_all'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string|in:admin,guru',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->role = $request->role;

        if ($request->hasFile('foto')) {
            $nama_file = "User_" . time() . "_" . $request->file('foto')->getClientOriginalName();
            $request->file('foto')->move('users_foto', $nama_file);
            $user->foto = $nama_file;
        }

        $user->save();
        
        return redirect()->route('admin.users.index')->with('success-isi-content', 'User ' . $user->name . ' Telah Berhasil Ditambahkan');
    }
    
    public function edit($id)
    {
        $berita_all = Berita::where('b_status', 'DRAFT')->get();
        $publishedMenus = Kesiswaan::where('k_status', 'PUBLISH')->pluck('k_nama_menu')->toArray();
        
        $kesiswaa_all = Kesiswaan::where('k_status', 'DRAFT')
        ->whereNotIn('k_nama_menu', $publishedMenus) // Hanya mengambil DRAFT yang tidak punya PUBLISH dalam grupnya
            ->get();
            $publishedEkstrakurikulerNames = Ekstrakurikuler::where('e_status', 'PUBLISH')->pluck('e_nama_ekstrakurikuler')->toArray();
            
        $ekstrakurikuler_all = Ekstrakurikuler::where('e_status', 'DRAFT')
        ->whereNotIn('e_nama_ekstrakurikuler', $publishedEkstrakurikulerNames) // Hanya mengambil DRAFT yang tidak punya PUBLISH dalam grupnya
        ->get();
        $penghargaan_all = Penghargaan::where('ph_status', 'DRAFT')->get();
        $tatatertib_all = Tatatertib::where('t_status', 'DRAFT')->get();
        $pembiasaan_all= Pembiasaan::where('p_status', 'DRAFT')->get();
        $user_all = User::all();

        $menu = 'Users';
        $user = User::findOrFail($id);
        
        return view('users.edit', [
            'user' => $user,
            'menu' => $menu,
            'kesiswaa_all' => $kesiswaa_all,
            'ekstrakurikuler_all' => $ekstrakurikuler_all,
            'penghargaan_all' => $penghargaan_all,
            'tatatertib_all' => $tatatertib_all,
            'user_all' => $user_all,
            'berita_all' => $berita_all,
            'pembiasaan_all' => $pembiasaan_all,
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|string|in:admin,guru',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->password) {
            $user->password = bcrypt($request->password);
        }
        $user->role = $request->role;

        if ($request->hasFile('foto')) {
            if ($user->foto) {
                File::delete('users_foto/' . $user->foto);
            }
            $nama_file = "User_" . time() . "_" . $request->file('foto')->getClientOriginalName();
            $request->file('foto')->move('users_foto', $nama_file);
            $user->foto = $nama_file;
        }

        $user->save();

        return redirect()->route('admin.users.index')->with('success-isi-content', 'User '. $user->name .' Telah Berhasil Diubah');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if ($user->foto) {
            File::delete('users_foto/' . $user->foto);
        }
        $user->delete();
        return redirect()->route('admin.users.index')->with('success-isi-content', 'User '. $user->name .' Telah Berhasil Dihapus');
    }
}
