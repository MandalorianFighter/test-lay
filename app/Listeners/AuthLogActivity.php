<?php

namespace App\Listeners;

use Illuminate\Auth\Events as LaravelEvents;

class AuthLogActivity
{

    public function login(LaravelEvents\Login $event): void
    {
        $message = "User logged in.";
        $this->logInfo($event, $message);
    }

    public function logout(LaravelEvents\Logout $event)
    {
        // Check if the 'last_logged_out_at' attribute was updated
        if (isset($event->user->getChanges()['last_logged_out_at'])) {
            // Prevent the activity from being logged
            return;
        }
        $message = "User logged out.";
        $this->logInfo($event, $message);
    }

    public function registered(LaravelEvents\Registered $event)
    {
        $message = "New User registered.";
        $this->logInfo($event, $message);
    }

    public function failed(LaravelEvents\Failed $event)
    {
        $message = "User login failed.";
        $this->logInfo($event, $message);
    }

    protected function logInfo(object $event, string $message)
    {
        activity()
            ->causedBy($event->user)
            ->event('auth')
            ->log($message);
    }
}
