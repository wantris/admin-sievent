<?php

namespace App\Http\Controllers;

use App\Ormawa;
use Illuminate\Http\Request;
use App\Admin;
use App\EventEksternal;
use App\EventEksternalRegistration;
use App\EventInternal;
use App\EventInternalRegistration;
use App\Participant;
use App\Pembina;
use App\Pengguna;
use App\TimEvent;
use Illuminate\Support\Facades\DB;

class dashboardController extends Controller
{
    public function index()
    {
        $title = "Dashboard ";
        $headerTitle = "Dashboard";

        $ormawa = Ormawa::all();
        $admin = Admin::all();
        $ps = Participant::all();
        $mhs = Pengguna::where('is_mahasiswa', 1)->get();
        $dosens = Pengguna::where('is_dosen', 1)->get();
        $ei = EventInternal::all();
        $ee = EventEksternal::all();
        $pembina = Pembina::all();
        $tim = TimEvent::all();
        $eir = EventInternalRegistration::all();
        $eer = EventEksternalRegistration::all();


        return view('dashboard', compact(
            'title',
            'headerTitle',
            'ormawa',
            'admin',
            'ps',
            'mhs',
            'ei',
            'ee',
            'pembina',
            'tim',
            'eir',
            'eer',
            'dosens'
        ));
    }
}
