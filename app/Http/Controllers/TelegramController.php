<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\RegisterNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Notification;

class TelegramController extends Controller
{

    protected $telegramId = '-852083579';

    public function auth(Request $request)
    {
        $user_id = $request->input('id');
        
        $this->checkAuthorizationHash($request);

        // Check if the user is already logged in
        if (Auth::check()) {
            // Redirect the user to the home page
            return redirect('/');
        }

        // Try to find the user by their Telegram user ID
        $user = User::where('telegram_id', $user_id)->first();

        // If the user doesn't exist, auto-register them
        if (!$user) {
            $user = User::create([
                'name' => $request->input('last_name') ? $request->input('first_name') . ' ' . $request->input('last_name') : $request->input('first_name'),
                'email' => $user_id .'@example.com', // You can set any email here
                'password' => bcrypt($request->input('username') . $user_id), // Generate a password from telegram_username and telegram_id
                'telegram_id' => $user_id, // Save the Telegram user ID
                'telegram_username' => $request->input('username'),
                'photo_url' => $request->input('photo_url'),
            ]);
            Notification::route('telegram', $this->telegramId) // send notification to the admin group in Telegram
            ->notify(new RegisterNotification($user));
        }

        // Log the user in
        Auth::login($user);

        // Redirect the user to the home page

        if (auth()->user()->is_admin) return redirect('/admin/users');
        return redirect(RouteServiceProvider::HOME);
    }

    private function checkAuthorizationHash(Request $request)
    {
        $checkHash = $request->input('hash');
        $authData = $request->except(['hash']);

        $dataCheck = [];
        foreach ($authData as $key => $value) {
            $dataCheck[] = $key . '=' . $value;
        }
        sort($dataCheck);
        $strCheck = implode("\n", $dataCheck);
        $secretKey = hash('sha256', env('TELEGRAM_BOT_TOKEN'), true);
        $hash = hash_hmac('sha256', $strCheck, $secretKey);

        if (strcmp($hash, $checkHash) !== 0) {
            abort(401, 'Invalid Telegram authorization hash');
          }

        if ((time() - $authData['auth_date']) > 86400) {
            abort(401, 'Data is outdated');
        }
    }
}

