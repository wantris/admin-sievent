<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// Auth
Route::group(['prefix' => '/'], function () {
    Route::get('/', 'authController@index')->name('auth.index');
    Route::post('/login', 'authController@postLogin')->name('auth.index.post');
    Route::get('/logout', 'authController@logout')->name('auth.logout');
});

Route::group(['prefix' => 'dashboard'], function () {
    Route::get('/', 'dashboardController@index')->name('dashboard');
});

// ======================== admin =====================

Route::group(['prefix' => 'admin'], function () {
    Route::get('/', 'adminController@index')->name('admin.index');
    Route::get('/add', 'adminController@add')->name('admin.add');
    Route::post('/add', 'adminController@save')->name('admin.save');
    Route::get('/edit/{id}', 'adminController@edit')->name('admin.edit');
    Route::patch('/update/{id}', 'adminController@update')->name('admin.update');
    Route::delete('/delete/{id}', 'adminController@edit')->name('admin.delete');
});

// ==================== wadir 3 ==============

Route::group(['prefix' => 'wadir3'], function () {
    Route::get('/', 'wadir3Controller@index')->name('wadir3.index');
    Route::get('/add', 'wadir3Controller@add')->name('wadir3.add');
    Route::post('/add', 'wadir3Controller@save')->name('wadir3.save');
    Route::get('/edit/{id}', 'wadir3Controller@edit')->name('wadir3.edit');
    Route::patch('/update/{id}', 'wadir3Controller@update')->name('wadir3.update');
    Route::delete('/delete/{id}', 'wadir3Controller@delete')->name('wadir3.delete');

    Route::get('/export', 'wadir3Controller@export')->name('wadir3.export');
});

// =================== kategori event ============

Route::group(['prefix' => 'kategorievent'], function () {
    Route::get('/', 'kategoriEventController@index')->name('kategorievent.index');
    Route::get('/add', 'kategoriEventController@add')->name('kategorievent.add');
    Route::post('/add', 'kategoriEventController@save')->name('kategorievent.save');
    Route::get('/edit/{id_kategori}', 'kategoriEventController@edit')->name('kategorievent.edit');
    Route::patch('/update/{id_kategori}', 'kategoriEventController@update')->name('kategorievent.update');
    Route::delete('/delete/{id_kategori}', 'kategoriEventController@delete')->name('kategorievent.delete');
});

//  ==================== ormawa ================ 

Route::group(['prefix' => 'ormawa'], function () {
    Route::get('/', 'ormawaController@index')->name('ormawa.index');
    Route::get('/add', 'ormawaController@add')->name('ormawa.add');
    Route::post('/add', 'ormawaController@save')->name('ormawa.save');
    Route::get('/detail/{id_ormawa}', 'ormawaController@detail')->name('ormawa.detail');
    Route::get('/edit/{id_ormawa}', 'ormawaController@edit')->name('ormawa.edit');
    Route::patch('/update/{id_ormawa}', 'ormawaController@update')->name('ormawa.update');
    Route::delete('/delete/{id_ormawa}', 'ormawaController@delete')->name('ormawa.delete');

    Route::get('/export', 'ormawaController@export')->name('ormawa.export');
});


// ============ cakupan ormawa ====================

Route::group(['prefix' => 'cakupanormawa'], function () {
    Route::get('/', 'cakupanOrmawaController@index')->name('cakupanOrmawa.index');
    Route::get('/add', 'cakupanOrmawaController@add')->name('cakupanOrmawa.add');
    Route::post('/add', 'cakupanOrmawaController@save')->name('cakupanOrmawa.save');
    Route::get('/edit/{id_cakupanOrmawa}', 'cakupanOrmawaController@edit')->name('cakupanOrmawa.edit');
    Route::patch('/update/{id_cakupanOrmawa}', 'cakupanOrmawaController@update')->name('cakupanOrmawa.update');
    Route::delete('/delete/{id_cakupanOrmawa}', 'cakupanOrmawaController@delete')->name('cakupanOrmawa.delete');
});

// ============ Tipe Peserta ====================

Route::group(['prefix' => 'tipepeserta'], function () {
    Route::get('/', 'tipepesertaController@index')->name('tipepeserta.index');
    Route::get('/add', 'tipepesertaController@add')->name('tipepeserta.add');
    Route::post('/add', 'tipepesertaController@save')->name('tipepeserta.save');
    Route::get('/edit/{id_tipepeserta}', 'tipepesertaController@edit')->name('tipepeserta.edit');
    Route::patch('/update/{id_tipepeserta}', 'tipepesertaController@update')->name('tipepeserta.update');
    Route::delete('/delete/{id_tipepeserta}', 'tipepesertaController@delete')->name('tipepeserta.delete');
});


// ================ Pembina =====================

Route::group(['prefix' => 'pembina'], function () {
    Route::get('/', 'pembinaController@index')->name('pembina.index');
    Route::get('/add', 'pembinaController@add')->name('pembina.add');
    Route::post('/add', 'pembinaController@save')->name('pembina.save');
    Route::get('/edit/{id_pembina}', 'pembinaController@edit')->name('pembina.edit');
    Route::patch('/update/{id_pembina}', 'pembinaController@update')->name('pembina.update');
    Route::delete('/delete/{id_pembina}', 'pembinaController@delete')->name('pembina.delete');
});

// ================== participant ===============
Route::group(['prefix' => 'participant'], function () {
    Route::get('/', 'participantController@index')->name('participant.index');
    Route::get('/add', 'participantController@add')->name('participant.add');
    Route::post('/add', 'participantController@save')->name('participant.save');
    Route::get('/edit/{id_participant}', 'participantController@edit')->name('participant.edit');
    Route::patch('/update/{id_participant}', 'participantController@update')->name('participant.update');
    Route::delete('/delete/{id_participant}', 'participantController@delete')->name('participant.delete');
});

// ================== mahasiswa ===============
Route::group(['prefix' => 'mahasiswa'], function () {
    Route::get('/', 'mahasiswaController@index')->name('mahasiswa.index');
    Route::get('/add', 'mahasiswaController@runSeeder')->name('mahasiswa.add');
    Route::post('/add', 'mahasiswaController@save')->name('mahasiswa.save');
    Route::get('/edit/{nim}', 'mahasiswaController@edit')->name('mahasiswa.edit');
    Route::patch('/update/{nim}', 'mahasiswaController@update')->name('mahasiswa.update');
    Route::delete('/delete/{nim}', 'mahasiswaController@delete')->name('mahasiswa.delete');

    Route::get('/export', 'mahasiswaController@export')->name('mahasiswa.export');
    Route::post('/import', 'mahasiswaController@import')->name('mahasiswa.import');
    Route::get('/export/sample', 'mahasiswaController@exportSample')->name('mahasiswa.export');
});

// ================== dosen ===============
Route::group(['prefix' => 'dosen'], function () {
    Route::get('/', 'dosenController@index')->name('dosen.index');
    Route::get('/add', 'dosenController@runSeeder')->name('dosen.add');
    Route::post('/add', 'dosenController@save')->name('dosen.save');
    Route::get('/edit/{nidn}', 'dosenController@edit')->name('dosen.edit');
    Route::patch('/update/{nidn}', 'dosenController@update')->name('dosen.update');
    Route::delete('/delete/{nidn}', 'dosenController@delete')->name('dosen.delete');

    Route::get('/export/sample', 'dosenController@exportSample')->name('dosen.export');
    Route::post('/import', 'dosenController@import')->name('dosen.import');
});

// ================== pengguna ===============
Route::group(['prefix' => 'pengguna'], function () {
    Route::get('/', 'penggunaController@index')->name('pengguna.index');
    Route::get('/add', 'penggunaController@add')->name('pengguna.add');
    Route::post('/add', 'penggunaController@save')->name('pengguna.save');
    Route::get('/edit/{id_pengguna}', 'penggunaController@edit')->name('pengguna.edit');
    Route::get('/relasi/{id_pengguna}', 'penggunaController@relasi')->name('pengguna.relasi');
    Route::patch('/relasi/{id_pengguna}', 'penggunaController@updateRelasi')->name('pengguna.relasi.update');
    Route::patch('/update/{id_pengguna}', 'penggunaController@update')->name('pengguna.update');
    Route::delete('/delete/{id_pengguna}', 'penggunaController@delete')->name('pengguna.delete');
});

// ================== eventinternal ===============
Route::group(['prefix' => 'eventinternal'], function () {
    Route::get('/', 'eventInternalController@index')->name('eventinternal.index');
    Route::get('/add', 'eventInternalController@add')->name('eventinternal.add');
    Route::post('/add', 'eventInternalController@save')->name('eventinternal.save');
    Route::get('/edit/{id_eventinternal}', 'eventInternalController@edit')->name('eventinternal.edit');
    Route::patch('/update/{id_eventinternal}', 'eventInternalController@update')->name('eventinternal.update');
    Route::delete('/delete/{id_eventinternal}', 'eventInternalController@delete')->name('eventinternal.delete');

    Route::get('/pengajuan/{id_eventinternal}', 'eventInternalController@seePengajuan')->name('eventinternal.pengajuan');
    Route::patch('/pengajuan/{id_eventinternal_detail}', 'eventInternalController@updatePengajuan')->name('eventinternal.pengajuan.update');
});

// ================== event eksternal ===============
Route::group(['prefix' => 'eventeksternal'], function () {
    Route::get('/', 'eventeksternalController@index')->name('eventeksternal.index');
    Route::get('/add', 'eventeksternalController@add')->name('eventeksternal.add');
    Route::post('/add', 'eventeksternalController@save')->name('eventeksternal.save');
    Route::get('/edit/{id_eventeksternal}', 'eventeksternalController@edit')->name('eventeksternal.edit');
    Route::patch('/update/{id_eventeksternal}', 'eventeksternalController@update')->name('eventeksternal.update');
    Route::delete('/delete/{id_eventeksternal}', 'eventeksternalController@delete')->name('eventeksternal.delete');

    Route::get('/pengajuan/{id_eventeksternal}', 'eventeksternalController@seePengajuan')->name('eventeksternal.pengajuan');
    Route::patch('/pengajuan/{id_eventeksternal_detail}', 'eventeksternalController@updatePengajuan')->name('eventeksternal.pengajuan.update');
});


//  ==================== team ================ 

Route::group(['prefix' => 'team'], function () {
    Route::get('/{type}', 'teamController@index')->name('team.index');
    Route::get('/add', 'teamController@add')->name('team.add');
    Route::post('/add', 'teamController@save')->name('team.save');
    Route::get('/detail/{id_team}', 'teamController@detail')->name('team.detail');
    Route::get('/edit/{id_team}', 'teamController@edit')->name('team.edit');
    Route::patch('/update/{id_team}', 'teamController@update')->name('team.update');
    Route::delete('/delete/{id_team}', 'teamController@delete')->name('team.delete');
    Route::post('/updatestatus/{id_team}', 'teamController@updateStatus')->name('team.delete');
});

//  ==================== registration =====================

Route::group(['prefix' => 'registration'], function () {
    // eventinternal
    Route::get('/eventinternal', 'EventInternalRegisController@index')->name('registrations.eventinternal.index');
    Route::get('/eventinternal/idevent/{id_eventinternal}', 'EventInternalRegisController@getByEvent')->name('registrations.eventinternal.getbyevent');
    Route::post('/eventinternal/updatestatus/{id_regis}', 'EventInternalRegisController@updateStatus')->name('registrations.eventinternal.updatestatus');
    Route::delete('/eventinternal/delete/{id_regis}', 'EventInternalRegisController@delete')->name('registrations.eventinternal.delete');
    Route::get('/eventinternal/export/excel/{id_eventinternal}', 'EventInternalRegisController@exportExcel')->name('registrations.eventinternal.exportExcel');
    Route::get('/eventinternal/export/pdf/{id_eventinternal}', 'EventInternalRegisController@exportPdf')->name('registrations.eventinternal.exportPdf');
    Route::get('/eventinternal/sertificate', 'EventInternalRegisController@downloadSertificate')->name('registrations.eventinternal.sertificate.download');

    // eventeksternal
    Route::get('/eventeksternal', 'EventEksternalRegisController@index')->name('registrations.eventeksternal.index');
    Route::post('/eventeksternal/updatestatus/{id_regis}', 'EventEksternalRegisController@updateStatus')->name('registrations.eventeksternal.updatestatus');
    Route::get('/eventeksternal/idevent/{id_eventeksternal}', 'EventEksternalRegisController@getByEvent')->name('registrations.eventeksternal.getbyevent');
    Route::get('/eventeksternal/export/excel/{id_eventeksternal}', 'EventEksternalRegisController@exportExcel')->name('registrations.eventeksternal.exportExcel');
    Route::get('/eventeksternal/export/pdf/{id_eventeksternal}', 'EventEksternalRegisController@exportPdf')->name('registrations.eventeksternal.exportPdf');
    Route::get('/eventeksternal/sertificate', 'EventEksternalRegisController@downloadSertificate')->name('registrations.eventeksternal.sertificate.download');
});

# ============== Tahapan Event ================ #
Route::group(['prefix' => 'tahapan'], function () {
    Route::get('/eventinternal', 'tahapanEventInternalController@getByEvent')->name('tahapan.index.byevent');
    Route::post('/eventinternal/save', 'tahapanEventInternalController@save')->name('tahapan.save');
    Route::post('/eventinternal/update', 'tahapanEventInternalController@update')->name('tahapan.update');
    Route::delete('/eventinternal/delete', 'tahapanEventInternalController@delete')->name('tahapan.delete');
    Route::get('/eventinternal', 'tahapanEventInternalController@getByEvent')->name('tahapan.index.byevent');
    Route::get('/eventinternal/pendaftaran', 'tahapanEventInternalController@saveRegistrationStep')->name('tahapan.eventinternal.pendaftaran.save');
    Route::post('/eventinternal/pendaftaran/multiple', 'tahapanEventInternalController@saveRegisStepMultiple')->name('tahapan.eventinternal.pendaftaran.save.multiple');


    Route::get('/eventeksternal', 'tahapanEventEksternalController@getByEvent')->name('tahapan.index.byevent');
    Route::post('/eventeksternal/save', 'tahapanEventEksternalController@save')->name('tahapan.save');
    Route::post('/eventeksternal/update', 'tahapanEventEksternalController@update')->name('tahapan.update');
    Route::delete('/eventeksternal/delete', 'tahapanEventEksternalController@delete')->name('tahapan.delete');
    Route::get('/eventeksternal/pendaftaran', 'tahapanEventEksternalController@saveRegistrationStep')->name('tahapan.eventeksternal.pendaftaran.save');
    Route::post('/eventeksternal/pendaftaran/multiple', 'tahapanEventEksternalController@saveRegisStepMultiple')->name('tahapan.eventeksternal.pendaftaran.save.multiple');
});

// export prestasi
// ============== Account =====================
Route::group(['prefix' => 'prestasi'], function () {
    // eventinternal
    Route::get('/eventinternal', 'prestasiEventInternalController@index')->name('prestasi.eventinternal.index');
    Route::get('/eventinternal/export/excel', 'prestasiEventInternalController@exportAllExcel')->name('prestasi.eventinternal.excel.all');

    // eventeksternal
    Route::get('/eventeksternal', 'prestasiEventEksternalController@index')->name('prestasi.eventeksternal.index');
    Route::get('/eventeksternal/export/excel', 'prestasiEventEksternalController@exportAllExcel')->name('prestasi.eventeksternal.excel.all');
});

// Website Settings

// ============== Slider =====================
Route::group(['prefix' => 'slider'], function () {
    Route::get('/', 'sliderController@index')->name('slider.index');
    Route::post('/add', 'sliderController@save')->name('slider.save');
    Route::post('/update/{id_slider}', 'sliderController@update')->name('slider.update');
    Route::get('/delete/{id_slider}', 'sliderController@delete')->name('slider.delete');
});

// ============== blog =====================
Route::group(['prefix' => 'blog'], function () {
    Route::get('/', 'blogController@index')->name('blog.index');
    Route::get('/add', 'blogController@add')->name('blog.add');
    Route::post('/add', 'blogController@save')->name('blog.save');
    Route::get('/edit/{slug}', 'blogController@edit')->name('blog.edit');
    Route::post('/update/{id_blog}', 'blogController@update')->name('blog.update');
    Route::get('/delete/{id_blog}', 'blogController@delete')->name('blog.delete');
});

// ============== Testimoni =====================
Route::group(['prefix' => 'testimoni'], function () {
    Route::get('/', 'testimoniController@index')->name('testimoni.index');
    Route::post('/add', 'testimoniController@save')->name('testimoni.save');
    Route::post('/update/{id_testimoni}', 'testimoniController@update')->name('testimoni.update');
    Route::get('/delete/{id_testimoni}', 'testimoniController@delete')->name('testimoni.delete');
});

// ============== Account =====================
Route::group(['prefix' => 'account'], function () {
    Route::get('/', 'accountController@index')->name('account.index');
    Route::post('/save', 'accountController@postProfile')->name('account.save');
    Route::get('/delete/{id_account}', 'accountController@delete')->name('account.delete');
});
