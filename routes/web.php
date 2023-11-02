<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileSecurity;
use App\Http\Controllers\Auth\ADLogin\LoginController;

use App\Http\Controllers\Auth\LoginController as OtpLoginController;

use App\Http\Controllers\Platform\SuperAdmin\DashboardController as SuperAdminDashboardController;



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

Route::get("/ad-login", [LoginController::class, "login"])->name("azure.login");

Route::get('log-viewer', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index'])->middleware(["operation"])->name('log.viewer');

Route::get("/", function () {
    return redirect()->route("login");
});

Route::post("/otp-login", [OtpLoginController::class, "otpSend"])->name(
    "user.otp_login"
);
Route::get(
    "/otp-verification/{uuid}",
    [OtpLoginController::class, "otpVerification"]
)->name("user.otp_verification");
Route::post("/verify-otp", [OtpLoginController::class, "verifyOtp"])->name(
    "user.verify_otp"
);
Route::post("/resend-otp", [OtpLoginController::class, "resendOtp"])->name(
    "user.resend_otp"
);
Route::get("/contents", function () {
    return view("welcome");
})->name("home");


Route::middleware(["auth", "prevent-back-history"])->group(function () {
    Route::prefix("admin")
        ->middleware(["administrator"])
        ->group(function () {
            Route::get("/", [
                SuperAdminDashboardController::class,
                "index",
            ])->name("admin.dashboard");
            // Route::get("/home", [
            //     SuperAdminDashboardController::class,
            //     "index",
            // ])->name("admin.dashboard");
        });
});

Route::get("/files/{any}", [FileSecurity::class, "files"])->where("any", ".*");
require __DIR__ . "/auth.php";
