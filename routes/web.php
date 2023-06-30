<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ServerController;
use App\Http\Controllers\SwitchController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FirewallController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/', function () {
  return redirect()->route('login');
});

Route::get('/dashboard', function () {
  if (Auth::check() && Auth::user()->role == 'admin') {
    return redirect()->route('admin.index');
  }
  if (Auth::check() && Auth::user()->role == 'user') {
    return redirect()->route('user.index');
  }
  return redirect()->route('login');
});

// ACCESS ADMIN
Route::prefix('admin')->name('admin.')->middleware('isAdmin')->group(function () {
  Route::get('dashboard', [DashboardController::class, 'index'])->name('index');
  // CREATE USER AND ADMIN
  Route::resource('user', UserController::class);
  Route::resource('admin', AdminController::class);
});

// ACCESS USER
Route::prefix('user')->name('user.')->middleware('isUser')->group(function () {
  Route::get('dashboard', [DashboardController::class, 'index'])->name('index');
});
 

Route::middleware(['auth'])->group(function () {
  Route::get('/profile', function () {
    return view('profile');
  })->name('profile');
  Route::patch('updateDataUser/{id}', [UserController::class, 'updateDataUser'])->name('updateDataUser');

  // GET SIDEBAR
  Route::get('switch', [SwitchController::class, 'index'])->name('switch.index');
  Route::get('firewall', [FirewallController::class, 'index'])->name('firewall.index');
  Route::get('server', [ServerController::class, 'index'])->name('server.index');


  // GET API MAIN DASHBOARD
  Route::get('NetworkTrafficCyberplus', [DashboardController::class, 'NetworkTrafficCyberplus'])->name('NetworkTrafficCyberplus');
  Route::get('NetworkTrafficLinknet', [DashboardController::class, 'NetworkTrafficLinknet'])->name('NetworkTrafficLinknet');
  Route::get('PingGatewayISPCyberplus', [DashboardController::class, 'PingGatewayISPCyberplus'])->name('PingGatewayISPCyberplus');
  Route::get('PingGatewayISPLinknet', [DashboardController::class, 'PingGatewayISPLinknet'])->name('PingGatewayISPLinknet');
  Route::get('PinglossCyberplus', [DashboardController::class, 'PinglossCyberplus'])->name('PinglossCyberplus');
  Route::get('PinglossLinknet', [DashboardController::class, 'PinglossLinknet'])->name('PinglossLinknet');
  Route::get('Ping8888', [DashboardController::class, 'Ping8888'])->name('Ping8888');
  Route::get('Pingdetikcom', [DashboardController::class, 'Pingdetikcom'])->name('Pingdetikcom');
  Route::get('Pingteamsmicrosoftcom', [DashboardController::class, 'Pingteamsmicrosoftcom'])->name('Pingteamsmicrosoftcom');
  Route::get('MemoryUsage', [DashboardController::class, 'MemoryUsage'])->name('MemoryUsage');
  Route::get('CPUUtilization', [DashboardController::class, 'CPUUtilization'])->name('CPUUtilization');
  Route::get('DiskSpaceUsage', [DashboardController::class, 'DiskSpaceUsage'])->name('DiskSpaceUsage');
  
  
  // GET API SWITCH
  Route::get('Networktrafficint112Uplink', [SwitchController::class, 'Networktrafficint112Uplink'])->name('Networktrafficint112Uplink');
  Route::get('Networktrafficint141DownlinkMainOffice', [SwitchController::class, 'Networktrafficint141DownlinkMainOffice'])->name('Networktrafficint141DownlinkMainOffice');
  Route::get('Networktrafficint121DownlinkHall1', [SwitchController::class, 'Networktrafficint121DownlinkHall1'])->name('Networktrafficint121DownlinkHall1');
  Route::get('Networktrafficint122DownlinkWorkshop', [SwitchController::class, 'Networktrafficint122DownlinkWorkshop'])->name('Networktrafficint122DownlinkWorkshop');
  Route::get('Networktrafficint142DownlinkHall2', [SwitchController::class, 'Networktrafficint142DownlinkHall2'])->name('Networktrafficint142DownlinkHall2');
  Route::get('Networktrafficint143DownlinkHall3', [SwitchController::class, 'Networktrafficint143DownlinkHall3'])->name('Networktrafficint143DownlinkHall3');
  Route::get('Networktrafficint131DownlinkSmalloffice1', [SwitchController::class, 'Networktrafficint131DownlinkSmalloffice1'])->name('Networktrafficint131DownlinkSmalloffice1');
  Route::get('Networktrafficint132DownlinkSmalloffice2', [SwitchController::class, 'Networktrafficint132DownlinkSmalloffice2'])->name('Networktrafficint132DownlinkSmalloffice2');
  // Route::get('Networktrafficint121ISPCyberplus', [SwitchController::class, 'Networktrafficint121ISPCyberplus'])->name('Networktrafficint121ISPCyberplus');
  // Route::get('Networktrafficint112ISPLinknet', [SwitchController::class, 'Networktrafficint112ISPLinknet'])->name('Networktrafficint112ISPLinknet');
  
  // GET API FIREWALL
  Route::get('CurrentRAMUsage', [FirewallController::class, 'CurrentRAMUsage'])->name('CurrentRAMUsage');
  Route::get('CurrentCPUUtil', [FirewallController::class, 'CurrentCPUUtil'])->name('CurrentCPUUtil');


    // GET API SERVER
    Route::get('MemoryUsageQAD', [ServerController::class, 'MemoryUsageQAD'])->name('MemoryUsageQAD');
    Route::get('CPUUtillQAD', [ServerController::class, 'CPUUtillQAD'])->name('CPUUtillQAD');
    Route::get('DiskSpaceUsageQAD', [ServerController::class, 'DiskSpaceUsageQAD'])->name('DiskSpaceUsageQAD');
    Route::get('MemoryUtilATT', [ServerController::class, 'MemoryUtilATT'])->name('MemoryUtilATT');
    Route::get('CPUUtillATT', [ServerController::class, 'CPUUtillATT'])->name('CPUUtillATT');
    Route::get('DiskSpaceUsageATT', [ServerController::class, 'DiskSpaceUsageATT'])->name('DiskSpaceUsageATT');
});

require __DIR__ . '/auth.php';
