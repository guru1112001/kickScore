<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

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

// Route::get('/', function () {
//     return redirect('/administrator');
//     // return view('welcome');
// });
Route::get('/', function () {
    return view('home');
})->name('home');

// Route::post('/change-language', function (\Illuminate\Http\Request $request) {
//     $language = $request->input('language', 'en');
//     Session::put('locale', $language);
//     App::setLocale($language);
//     return redirect()->back();
// })->name('changeLanguage');

// Route::get('/set-locale/{locale}', function ($locale) {
//     if (in_array($locale, ['en', 'ar'])) { // Add more languages if needed
//         session(['locale' => $locale]);
//     }
//     return redirect()->back();
// })->name('set-locale');
Route::get('/locale-deep-debug', function () {
    return [
        'session_locale' => Session::get('locale'),
        'app_locale' => App::getLocale(),
        'config_locale' => config('app.locale'),
        'current_locale' => app()->getLocale(),
        'translations' => [
            'en' => __('messages.Hero_section_heading', [], 'en'),
            'ar' => __('messages.Hero_section_heading', [], 'ar')
        ]
    ];
});
Route::get('locale/{lang}', function ($lang) {
    if (in_array($lang, ['en', 'ar'])) {
        Session::put('locale', $lang);
        App::setLocale($lang);
        config(['app.locale' => $lang]);
        
        \Log::info('Locale switched successfully:', [
            'session_locale' => Session::get('locale'),
            'app_locale' => App::getLocale(),
            'config_locale' => config('app.locale'),
        ]);
    }
    return redirect()->back();
})->name('locale.switch');
Route::get('/test-translation', function () {
 return [
        'current_locale' => App::getLocale(),
        'session_locale' => Session::get('locale'),
        'request_locale' => request('locale'),
        'en_translation' => __('messages.Hero_section_heading', [], 'en'),
        'ar_translation' => __('messages.Hero_section_heading', [], 'ar')
    ];
});
//Route::get('/api/events/meetings', 'EventController@getMeetings');
//Route::get('/api/events/deadlines', 'EventController@getDeadlines');

Route::get('/linkstorage', function () {
    Artisan::call('storage:link');
});
Route::get('clear-cache', function () {
    //Artisan::call('storage:link');
    Artisan::call('optimize');
	Artisan::call('cache:clear');   
    Artisan::call('config:cache');
    Artisan::call('route:clear');

    return "Cache cleared successfully";
});
