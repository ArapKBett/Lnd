<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ClientController extends Controller {
    public function index() {
        $clients = User::where('role', 'client')->with('savings', 'loans')->paginate(10);
        return view('admin.clients', compact('clients'));
    }

    public function show($id) {
        $client = User::where('role', 'client')->with('savings', 'loans')->findOrFail($id);
        return view('admin.clients.show', compact('client'));
    }

    public function update(Request $request, $id) {
        $client = User::findOrFail($id);
        $client->update($request->only('name', 'email'));
        return redirect()->route('admin.clients.index')->with('success', 'Client updated.');
    }

    public function destroy($id) {
        $client = User::findOrFail($id);
        $client->delete();
        return redirect()->route('admin.clients.index')->with('success', 'Client deleted.');
    }
}
