<?php

namespace App\Http\Controllers;

use App\Engines\ProfileEngine;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function __construct(protected ProfileEngine $engine) {}

    public function index(Request $request): View
    {
        $user = $request->user();

        return view('profile.show', [
            'user' => $user,
            'completion' => $this->engine->completion($user),
            'cvCompletion' => $this->engine->cvCompletion($user),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        $data = $request->except(['photo', '_token', '_method']);

        if ($request->hasFile('photo')) {
            $request->validate([
                'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            ]);
            $user->updateProfilePhoto($request->file('photo'));
        }

        $this->engine->update($user, $data);

        return back()->with('status', 'Profile updated successfully.');
    }

    public function destroyPhoto(Request $request): RedirectResponse
    {
        $request->user()->deleteProfilePhoto();

        return back()->with('status', 'Profile photo removed.');
    }

    public function deactivate(Request $request): RedirectResponse
    {
        $this->engine->deactivate($request->user());

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')
            ->with('status', 'Your account has been deactivated.');
    }
}
