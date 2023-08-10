<?php 

namespace App\Http\Composers;

use App\Http\Resources\UserTransformer;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class MainViewComposer {
    public function compose(View $view)
    {
        $user = Auth::user();
        $user->load('roles.permissions');
        $view->with('user', (new UserTransformer($user))->toJson());
    }
}