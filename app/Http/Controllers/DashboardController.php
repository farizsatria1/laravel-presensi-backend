<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Pembimbing;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::where('role', 'peserta')->count();
        $totalPembimbing = Pembimbing::count();
        $totalAdmin = User::where('role', 'admin')->count();
        $company = Company::first();

        return view('pages.dashboard', compact('totalUsers', 'totalPembimbing', 'totalAdmin','company'));
    }

    //edit
    public function edit($id){
        $company = Company::find($id);
        return view('pages.company.edit', compact('company'));
    }

    //update
    public function update(Request $request, Company $company){
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'address' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'radius_km' => 'required',
            'time_in' => 'required',
            'time_out' => 'required',
        ]);

        $company->update([
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'radius_km' => $request->radius_km,
            'time_in' => $request->time_in,
            'time_out' => $request->time_out,
        ]);

        return redirect()->route('company.show', 1)->with('success', 'Company updated successfully');
    }
}
