<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Organization;


class OrganizationController extends Controller
{
    public function index()
    {
        $organizations = Organization::all();
        return view('organizations.index', compact('organizations'));
    }

    public function create()
    {
        return view('organizations.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:organizations,email',
            'password' => 'required|string|min:8|confirmed',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'color_scheme' => 'nullable|string|max:7',
            'background_color' => 'nullable|string|max:7',
            'addresses' => 'nullable|array|min:1',
            'addresses.*.office_address' => 'nullable|string',
            'addresses.*.office_number' => 'nullable|string',
            'addresses.*.fax_number' => 'nullable|string',
        ]);

        $data = $request->except(['logo', 'password_confirmation', 'addresses']);
        $data['password'] = bcrypt($request->password);

        // Handle logo upload
        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $logoName = time() . '_' . uniqid() . '.' . $logo->getClientOriginalExtension();
            $logo->move(public_path('uploads/organizations'), $logoName);
            $data['logo'] = $logoName;
        }

        $organization = Organization::create($data);

        // Save addresses
        foreach ($request->addresses as $addressData) {
            $organization->addresses()->create($addressData);
        }

        return redirect()->route('organizations.index')->with('success', 'Organization created!');
    }

    public function show(Organization $organization)
    {
        return view('organizations.show', compact('organization'));
    }

    public function edit(Organization $organization)
    {
        return view('organizations.edit', compact('organization'));
    }

    public function update(Request $request, Organization $organization)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:organizations,email,' . $organization->id,
            'password' => 'nullable|string|min:8|confirmed',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'color_scheme' => 'nullable|string|max:7',
            'background_color' => 'nullable|string|max:7',
            'addresses' => 'required|array|min:1',
            'addresses.*.office_address' => 'required|string',
            'addresses.*.office_number' => 'required|string',
            'addresses.*.fax_number' => 'nullable|string',
        ]);

        $data = $request->except(['logo', 'password', 'password_confirmation', 'addresses']);
        
        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        // Handle logo upload
        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($organization->logo && file_exists(public_path('uploads/organizations/' . $organization->logo))) {
                unlink(public_path('uploads/organizations/' . $organization->logo));
            }
            
            $logo = $request->file('logo');
            $logoName = time() . '_' . uniqid() . '.' . $logo->getClientOriginalExtension();
            $logo->move(public_path('uploads/organizations'), $logoName);
            $data['logo'] = $logoName;
        }

        $organization->update($data);

        // Sync addresses
        $keepIds = [];
        foreach ($request->addresses as $addressData) {
            if (isset($addressData['id'])) {
                $address = $organization->addresses()->find($addressData['id']);
                if ($address) {
                    $address->update($addressData);
                    $keepIds[] = $address->id;
                }
            } else {
                $newAddress = $organization->addresses()->create($addressData);
                $keepIds[] = $newAddress->id;
            }
        }
        // Delete removed addresses
        $organization->addresses()->whereNotIn('id', $keepIds)->delete();

        return redirect()->route('organizations.index')->with('success', 'Organization updated!');
    }

    public function destroy(Organization $organization)
    {
        $organization->delete();
        return redirect()->route('organizations.index')->with('success', 'Organization deleted!');
    }

    public function profile()
    {
        $organization = auth()->guard('organization')->user();
        if (!$organization) {
            abort(403);
        }
        return view('organizations.edit', compact('organization'));
    }

    public function updateProfile(Request $request)
    {
        $organization = auth()->guard('organization')->user();
        if (!$organization) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:organizations,email,' . $organization->id,
            'password' => 'nullable|string|min:8|confirmed',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'color_scheme' => 'nullable|string|max:7',
            'background_color' => 'nullable|string|max:7',
            'addresses' => 'required|array|min:1',
            'addresses.*.office_address' => 'required|string',
            'addresses.*.office_number' => 'required|string',
            'addresses.*.fax_number' => 'nullable|string',
        ]);

        $data = $request->except(['logo', 'password', 'password_confirmation', 'addresses']);
        
        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        // Handle logo upload
        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($organization->logo && file_exists(public_path('uploads/organizations/' . $organization->logo))) {
                unlink(public_path('uploads/organizations/' . $organization->logo));
            }
            
            $logo = $request->file('logo');
            $logoName = time() . '_' . uniqid() . '.' . $logo->getClientOriginalExtension();
            $logo->move(public_path('uploads/organizations'), $logoName);
            $data['logo'] = $logoName;
        }

        $organization->update($data);

        // Sync addresses
        $keepIds = [];
        foreach ($request->addresses as $addressData) {
            if (isset($addressData['id'])) {
                $address = $organization->addresses()->find($addressData['id']);
                if ($address) {
                    $address->update($addressData);
                    $keepIds[] = $address->id;
                }
            } else {
                $newAddress = $organization->addresses()->create($addressData);
                $keepIds[] = $newAddress->id;
            }
        }
        $organization->addresses()->whereNotIn('id', $keepIds)->delete();

        return redirect()->route('dashboard')->with('success', 'Profile updated successfully!');
    }

    public function getAddresses($id)
    {
        $organization = Organization::findOrFail($id);
        return response()->json($organization->addresses);
    }
}

