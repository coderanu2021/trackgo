<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brands = Brand::latest()->get();
        return view('admin.brands.index', compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.brands.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'required|file|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'url' => 'nullable|url',
        ]);

        $data = [
            'name' => $request->name,
            'url' => $request->url,
            'status' => $request->has('status') ? true : false,
        ];

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('brands', 'public');
            $data['logo'] = 'storage/' . $path;
        }

        Brand::create($data);

        return redirect()->route('admin.brands.index')->with('success', 'Brand created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Brand $brand)
    {
        return view('admin.brands.edit', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Brand $brand)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'url' => 'nullable|url',
        ]);

        $data = [
            'name' => $request->name,
            'url' => $request->url,
            'status' => $request->has('status') ? true : false,
        ];

        if ($request->hasFile('logo')) {
            // Delete old logo
            if ($brand->logo) {
                $oldPath = str_replace('storage/', '', $brand->logo);
                Storage::disk('public')->delete($oldPath);
            }
            
            $path = $request->file('logo')->store('brands', 'public');
            $data['logo'] = 'storage/' . $path;
        }

        $brand->update($data);

        return redirect()->route('admin.brands.index')->with('success', 'Brand updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand)
    {
        if ($brand->logo) {
            $oldPath = str_replace('storage/', '', $brand->logo);
            Storage::disk('public')->delete($oldPath);
        }
        
        $brand->delete();

        return redirect()->route('admin.brands.index')->with('success', 'Brand deleted successfully.');
    }
}
