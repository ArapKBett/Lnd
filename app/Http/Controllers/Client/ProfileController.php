<?php
namespace App\Http\Controllers\Client;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class ProfileController extends Controller {
    public function edit() {
        return view('client.profile.edit', ['user' => auth()->user()]);
    }

    public function update(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . auth()->id(),
            'id_document' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
        ]);

        $user = auth()->user();
        $user->update($request->only('name', 'email'));

        if ($request->hasFile('id_document')) {
            $file = $request->file('id_document');
            $path = $file->store('documents', 'public');
            // Resize if image
            if (in_array($file->extension(), ['jpg', 'png'])) {
                Image::make(storage_path('app/public/' . $path))->resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save();
            }
            $user->update(['id_document' => $path]);
        }

        return redirect()->route('client.profile.edit')->with('success', 'Profile updated.');
    }
}
