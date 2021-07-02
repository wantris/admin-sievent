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

class dashboardController extends Controller
{
    public function index()
    {
        $title = "Dashboard ";
        $headerTitle = "Dashboard";

        $ormawa = Ormawa::all()->count();
        $admin = Admin::all()->count();
        $ps = Participant::all()->count();
        $mhs = Pengguna::where('is_mahasiswa', 1)->get()->count();
        $ei = EventInternal::all()->count();
        $ee = EventEksternal::all()->count();
        $pembina = Pembina::all()->count();
        $tim = TimEvent::all()->count();
        $eir = EventInternalRegistration::all()->count();
        $eer = EventEksternalRegistration::all()->count();

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
        ));
    }
}
