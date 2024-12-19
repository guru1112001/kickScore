<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LanguageSwitcher 
{
    public function handle(Request $request, Closure $next): Response 
{
  // Retrieve the locale from the session or fallback to the app default
  $locale = Session::get('locale', config('app.locale'));
        
  // Apply the locale
  App::setLocale($locale);
  config(['app.locale' => $locale]); // Update the config for consistency

  // Log for debugging
  \Log::info('Locale Middleware Deep Debug:', [
      'session_locale' => Session::get('locale'),
      'app_locale' => App::getLocale(),
      'config_locale' => config('app.locale'),
      'current_locale' => app()->getLocale(),
  ]);

  return $next($request);
}
}