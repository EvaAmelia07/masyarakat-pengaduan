<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Pengaduan;
use App\Tanggapan;
use App\Role;
use App\User;
use Auth;
use Carbon\Carbon;
use DB;
use PDF;

class BerandaController extends Controller
{
    public function index()
    {
        // tanggal 3bullan
        $bulanan = Pengaduan::where(
            'tanggal_aduan', '>=', Carbon::now()->subDays(30)->toDateTimeString()
        )->count();
        // end tanggal 3 bullan
        $pengaduan = Pengaduan::all();
        $hitung_tanggapapan = Tanggapan::all()->count();
        $hitung_blm_ditanggapi = Pengaduan::where('status', '=', 'proses')->count();
        $hitung_diproses = Pengaduan::where('status', '=', 'proses')->count();
        
        return view('admin.beranda.index', [
            'pengaduan' => $pengaduan,
            'hitung_tanggapapan' => $hitung_tanggapapan,
            'hitung_blm_ditanggapi' => $hitung_blm_ditanggapi,
            'hitung_diproses' => $hitung_diproses,
            'bulanan' => $bulanan,
        ]);
    }

    public function index_petugas()
    {
        $users = Role::find(2)->users;
        // $users->where(
        //     'tanggal_tanggapan', '>=', Carbon::now()->subMonths(3)->toDateTimeString()
        // )->groupBy('tanggal_tanggapan');

        return view('admin.beranda.datapetugas', [
            'users' => $users
            ]);
    }

    public function index_masyarakat()
    {
        $users = $users = Role::find(3)->users;

        // $hitung = DB::table('pengaduans')
        // ->select('user_id', DB::raw('count(*) as total'))
        // ->groupBy('id')->get()->count();

        return view('admin.beranda.datamasyarakat', [
            'users' => $users
            ]);
    }

    public function index_tentang()
    {
        return view('admin.beranda.tentang');
    }

    public function tambah_petugas()
    {
        return view('admin.admin_petugas.tambah');
    }
    public function cetak_laporan()
    {
        return view('admin.beranda.laporan');
    }
    public function periode(Request $request)
    {
       $this->validate($request,[
        'tanggal_awal' => 'required',
        'tanggal_akhir' => 'required'
       ]);

       $pengaduan = pengaduan::all();
       $judul = "Laporan Data Aduan Masyarakat dari tanggal: $request->tanggal_awal sampai $request->tanggal_akhir";
       $pdf = PDF::loadView('admin.beranda.pdf',[
           'pengaduan' => $pengaduan,
           'judul => $judul'
       ]);

       return $pdf->download("[$request->tanggal_awal - $request->tanggal_akhir]-Laporan.pdf");
    }

    public function RegisterPetugas(Request $request)
    {
        $request->validate([
            'nik' => 'required|min:5',
            'name' => 'required',
            'tanggal_lahir' => 'required',
            'alamat' => 'required',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'nik' => $request->nik,
            'name' => $request->name,
            'tanggal_lahir' => $request->tanggal_lahir,
            'alamat' => $request->alamat,
            'password' => bcrypt($request->password),
        ]);

        $role = Role::select('id')->where('name', 'petugas')->first();
        $user->roles()->attach($role);

        return redirect()->route('admin.beranda.petugas');
    }

    public function delete_petugas($id)
    {
        $user = User::find($id);

        if($user) {
            $user->roles()->detach();
            $user->delete();
            return redirect()->route('admin.beranda.petugas');
        }
        return redirect()->route('admin.beranda.petugas');

    }

    public function delete_masyarakat($id)
    {
        $user = User::find($id);

        if($user) {
            $user->roles()->detach();
            $user->delete();
        }
        return redirect()->route('admin.beranda.masyarakat');
    }

    public function aduan_detail($id)
    {
        $pengaduan = Pengaduan::find($id);
        $tanggapan = DB::table('tanggapans')
            ->join('users', 'users.id', '=', 'tanggapans.user_id')
            ->join('pengaduans', 'pengaduans.id', '=', 'tanggapans.pengaduan_id')
            ->select('users.*', 'pengaduans.*', 'tanggapans.*', DB::raw('users.name AS nama_user'))
	        ->where('pengaduan_id', $id)
            ->get();

        return view('admin.beranda.detailaduan', [
            'pengaduan' => $pengaduan,
            'tanggapan' => $tanggapan,
        ]);
    }
}
