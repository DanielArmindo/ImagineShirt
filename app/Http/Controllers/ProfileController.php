<?php

namespace App\Http\Controllers;

use App\Models\customer;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ProfileUpdateRequest;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $stand=true;

        if (Session::get('errors') !=null) {
            $stand = false;
        }

        if (session('status') === 'address-not-updated' or session('status') === 'address-updated') {
            $stand = false;
        }

        $customer = customer::where('id',$request->user()->id)->first();

        return view('profile.edit', [
            'user' => $request->user(), 'customer'=>$customer,'stand'=>$stand
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        if ($request->user()->email == $request->email and $request->user()->name == $request->name) {
            return redirect()->route('profile.edit')->with('status', 'not_updated');
        }

        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        try {
            $user->save(['blocked'=>1]);
            $user->customerRef->delete();
            $user->delete();

        } catch (\Throwable $th) {
            //bloquear user e fazer com que nao possa fazer login
            $request->session()->invalidate();
            session()->flush();
            return redirect()->route('home.index');

        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
