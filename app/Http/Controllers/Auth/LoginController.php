<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\AddSupplier;
use App\Models\SubSupplier;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    //Function for login
    public function login() {
        return view('auth.login');
    }

    //Function for Submit Login
    public function submit_login(Request $request) {
        //Validate input fields
        $request->validate(
            [
                'email' => 'required|email',
                'password' => 'required',
                'account_type' => 'required|in:supplier,subsupplier',
            ],
            [
                'email.required' => 'Please enter your email.',
                'email.email' => 'Please enter a valid email address.',
                'password.required' => 'Please enter your password.',
                'account_type.required' => 'Please select account type.',
            ]
        );
        //SUPPLIER LOGIN
        if ($request->account_type === 'supplier') {
            $supplier = AddSupplier::where('email', $request->email)->where('password', $request->password)->first();
            //Email/Password check
            if (!$supplier) {
                $emailExists = AddSupplier::where('email', $request->email)->exists();
                if (!$emailExists) {
                    return back()
                        ->withInput($request->only('email', 'account_type'))
                        ->withErrors([
                            'email' => 'This email is wrong. Please enter the correct email.',
                        ]);
                }
                return back()
                    ->withInput($request->only('email', 'account_type'))
                    ->withErrors([
                        'password' => 'Your password is wrong. Please enter the correct password.',
                    ]);
            }
            //Active check
            if ((int) $supplier->isactive !== 1) {
                return back()
                    ->withInput($request->only('email', 'account_type'))
                    ->withErrors([
                        'email' => 'Your account is not activated. Please contact administrator.',
                    ]);
            }
            //Store supplier login session
            session([
                'login_type' => 'supplier',
                'supplier_id' => $supplier->add_supplier_id,
            ]);
            //Regenerate session
            $request->session()->regenerate();
            //Redirect dashboard
            return redirect()->route('dashboard');
        }
        //SUB SUPPLIER LOGIN
        if ($request->account_type === 'subsupplier') {
            $subSupplier = SubSupplier::where('email', $request->email)->where('password', $request->password)->first();
            //Email/Password check
            if (!$subSupplier) {
                $emailExists = SubSupplier::where('email', $request->email)->exists();
                if (!$emailExists) {
                    return back()
                        ->withInput($request->only('email', 'account_type'))
                        ->withErrors([
                            'email' => 'This email is wrong. Please enter the correct email.',
                        ]);
                }
                return back()
                    ->withInput($request->only('email', 'account_type'))
                    ->withErrors([
                        'password' => 'Your password is wrong. Please enter the correct password.',
                    ]);
            }
            // Active status check
            if ((int) $subSupplier->status !== 1) {
                return back()
                    ->withInput($request->only('email', 'account_type'))
                    ->withErrors([
                        'email' => 'Your account is not activated. Please contact administrator.',
                    ]);
            }
            //Store sub supplier login session
            session([
                'login_type' => 'subsupplier',
                'sub_supplier_id' => $subSupplier->id,
                'supplier_id' => $subSupplier->supplier_id,
            ]);
            //Regenerate session
            $request->session()->regenerate();
            //Redirect dashboard
            return redirect()->route('dashboard');
        }
    }

    //Function for Logout
    public function logout(Request $request) {
        //Remove login session
        $request->session()->forget([
            'login_type',
            'supplier_id',
            'sub_supplier_id',
        ]);
        //Destroy current session
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}