<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CompanyDetails;

class CompanySettingController extends Controller
{
    
    public function index()
    {
        $companyDetail = CompanyDetails::first(); // Get the first and only record
        return view('setting.company.index', compact('companyDetail'));
    }

    public function edit($id)
    {
        $companyDetail = CompanyDetails::findOrFail($id); // Find the company by ID
        return view('setting.company.companySetting', compact('companyDetail'));
    }

    
    
    public function store(Request $request)
    {
        // Validate the form data
        $request->validate([
            'title' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'contact' => 'nullable|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'website' => 'nullable|string|max:255',
            'poweredByText' => 'nullable|string|max:255',
            'footertext' => 'nullable|string|max:255',
        ]);

        // Handle file upload
        if ($request->hasFile('logo')) {
            $logoName = time() . '.' . $request->logo->extension();
            $request->logo->move(public_path('images/logos'), $logoName);
        } else {
            $logoName = null;
        }

        // Get the existing company detail or create a new one
        $companyDetail = CompanyDetails::first();
        if (!$companyDetail) {
            $companyDetail = new CompanyDetails();
        }

       
        $companyDetail->title = $request->title;
        $companyDetail->address = $request->address;
        $companyDetail->email = $request->email;
        $companyDetail->contact = $request->contact;
        $companyDetail->logo = $logoName ?? $companyDetail->logo;
        $companyDetail->website = $request->website;
        $companyDetail->poweredbytext = $request->poweredByText;
        $companyDetail->footertext = $request->footertext;
        $companyDetail->save();

        
        return redirect()->back()->with('success', 'Company details saved successfully.');
    }


    public function getCompanyLogo()
    {
        $companyDetail = CompanyDetails::first();
        return $companyDetail ? $companyDetail->logo : 'default-logo.png';
    }

    public function update(Request $request, $id)
    {
        //dd($request);
        $company = CompanyDetails::findOrFail($id);
        $company->title = $request->input('title');
        $company->address = $request->input('address');
        $company->email = $request->input('email');
        $company->contact = $request->input('contact');
        $company->website = $request->input('website');
        $company->poweredbytext = $request->input('poweredByText');
        $company->footertext = $request->input('footertext');

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/logos'), $filename);
            $company->logo = $filename;
        }

        $company->save();

        return redirect()->route('company.index')->with('success', 'Company details updated successfully.');
    }

}

