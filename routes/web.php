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
  Route::get('PingCoreSwitch', [SwitchController::class, 'PingCoreSwitch'])->name('PingCoreSwitch');
  Route::get('PingAccessSwitchMainOffice', [SwitchController::class, 'PingAccessSwitchMainOffice'])->name('PingAccessSwitchMainOffice');
  Route::get('PingAccessSwitchHall1', [SwitchController::class, 'PingAccessSwitchHall1'])->name('PingAccessSwitchHall1');
  Route::get('PingAccessSwitchWorkshop', [SwitchController::class, 'PingAccessSwitchWorkshop'])->name('PingAccessSwitchWorkshop');
  Route::get('PingAccessSwitchHall2', [SwitchController::class, 'PingAccessSwitchHall2'])->name('PingAccessSwitchHall2');
  Route::get('PingAccessSwitchHall3', [SwitchController::class, 'PingAccessSwitchHall3'])->name('PingAccessSwitchHall3');
  Route::get('PingAccessSwitchSmallOfficeArea1', [SwitchController::class, 'PingAccessSwitchSmallOfficeArea1'])->name('PingAccessSwitchSmallOfficeArea1');
  Route::get('PingAccessSwitchSmallOfficeArea2', [SwitchController::class, 'PingAccessSwitchSmallOfficeArea2'])->name('PingAccessSwitchSmallOfficeArea2');
  Route::get('PingAccessSwitchSecurityFront', [SwitchController::class, 'PingAccessSwitchSecurityFront'])->name('PingAccessSwitchSecurityFront');
  Route::get('PingAccessSwitchSecuritySide', [SwitchController::class, 'PingAccessSwitchSecuritySide'])->name('PingAccessSwitchSecuritySide');
  Route::get('PingServerFarmSwitch', [SwitchController::class, 'PingServerFarmSwitch'])->name('PingServerFarmSwitch');
  Route::get('PingWANDistributionSwitchISPCyberplus', [SwitchController::class, 'PingWANDistributionSwitchISPCyberplus'])->name('PingWANDistributionSwitchISPCyberplus');
  Route::get('PingWANDistributionSwitchISPLinknet', [SwitchController::class, 'PingWANDistributionSwitchISPLinknet'])->name('PingWANDistributionSwitchISPLinknet');
  
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
