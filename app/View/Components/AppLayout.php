<?php

namespace App\View\Components;

use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\View\Component;
use Illuminate\View\View;

class AppLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        $token = [
            'value' => bin2hex(random_bytes(16)),
            'expires_at' => Carbon::now()->addMinutes(15)->timestamp,
        ];
        $encryptedToken = Crypt::encrypt($token);

        return view('layouts.app', ['appointmentToken' => $encryptedToken]);
    }
}
