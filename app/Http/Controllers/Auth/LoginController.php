<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->redirectTo = url()->previous();
    }

    protected function attemptLogin(Request $request)
    {
        $credentials = $this->credentials($request);

        $field = filter_var($request->input('email'), FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';
        $user = \App\Models\User::where($field, $credentials[$field])->first();

        if ($user && $user->status == 0) {
            throw ValidationException::withMessages([
                $this->username() => [trans('auth.disabled')],
            ]);
        }

        return $this->guard()->attempt(
            $credentials, $request->boolean('remember')
        );
    }

    protected function credentials(Request $request)
    {
        $field = filter_var($request->input('email'), FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';
        return [
            $field => $request->input('email'),
            'password' => $request->input('password'),
        ];
    }
    protected function validateLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);
    }
    public function username()
    {
        return 'email';
    }
}
