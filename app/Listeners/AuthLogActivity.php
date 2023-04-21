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
        $message = "User logged out.";
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


