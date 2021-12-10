<?php

namespace App\Http\Livewire\Settings\Theme;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Button extends Component
{
    public $configData;
    public $page;
    // mount
    public function mount($configData)
    {
        $this->configData = $configData;
        // get current page full url
        $this->page = url()->full();
    }
    public function changetheme()
    {
        // get current user
        $user = Auth::user();
        if($user->theme == 'dark'){
            $user->theme = 'light';
        }else{
            $user->theme = 'dark';
        }
        $user->save();
        return redirect($this->page);
    }
    public function render()
    {
        return view('livewire.settings.theme.button');
    }
}
