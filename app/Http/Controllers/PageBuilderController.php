<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PageBuilderController extends Controller
{
    // Frontend: Show general page (About, Contact, etc.)
    public function show($slug)
    {
        $page = Page::where('slug', $slug)->where('is_active', true)->firstOrFail();
        return view('front.page', compact('page'));
    }

    // Frontend: Show page by route name (for about, contact, etc.)
    public function showBySlug(Request $request)
    {
        $routeName = $request->route()->getName();
        $slug = $routeName; // Use route name as slug (about, contact, etc.)
        
        $page = Page::where('slug', $slug)->where('is_active', true)->first();
        
        if (!$page) {
            // If no dynamic page exists, fall back to static view
            return view('front.' . $slug);
        }
        
        return view('front.page', compact('page'));
    }

    // Admin: List all general pages
    public function index()
    {
        $pages = Page::where('is_enquiry', false)->latest()->get();
        return view('admin.pages.index', compact('pages'));
    }

    // Admin: Create general page form
    public function create()
    {
        return view('admin.pages.create');
    }

    // Admin: Store new general page
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:pages',
            'hero_image' => 'nullable|url',
            'blocks' => 'required|json',
        ]);

        $slug = $request->slug ? Str::slug($request->slug) : Str::slug($request->title);

        Page::create([
            'title' => $request->title,
            'slug' => $slug,
            'thumbnail' => $request->hero_image,
            'content' => json_decode($request->blocks, true),
            'is_active' => true,
            'is_enquiry' => false,
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'meta_keywords' => $request->meta_keywords,
        ]);

        return redirect()->route('admin.pages.index')->with('success', 'Page created successfully!');
    }

    // Admin: Edit general page form
    public function edit($id)
    {
        $page = Page::findOrFail($id);
        return view('admin.pages.edit', compact('page'));
    }

    // Admin: Update general page
    public function update(Request $request, $id)
    {
        $page = Page::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:pages,slug,' . $id,
            'hero_image' => 'nullable|url',
            'blocks' => 'required|json',
        ]);

        $slug = $request->slug ? Str::slug($request->slug) : Str::slug($request->title);

        $page->update([
            'title' => $request->title,
            'slug' => $slug,
            'thumbnail' => $request->hero_image,
            'content' => json_decode($request->blocks, true),
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'meta_keywords' => $request->meta_keywords,
        ]);

        return redirect()->route('admin.pages.index')->with('success', 'Page updated successfully!');
    }

    // Admin: Delete general page
    public function destroy($id)
    {
        $page = Page::findOrFail($id);
        $page->delete();
        return redirect()->route('admin.pages.index')->with('success', 'Page deleted successfully!');
    }

    // Admin: Upload image for page builder
    public function upload(Request $request)
    {
        // Log everything we can about the request
        \Log::info('Upload request received', [
            'method' => $request->method(),
            'content_type' => $request->header('Content-Type'),
            'content_length' => $request->header('Content-Length'),
            'has_file_image' => $request->hasFile('image'),
            'all_files' => $request->allFiles(),
            'file_keys' => array_keys($request->allFiles()),
            'input_keys' => array_keys($request->all()),
            'raw_files' => $_FILES ?? [],
            'server_content_length' => $_SERVER['CONTENT_LENGTH'] ?? 'not set',
            'server_content_type' => $_SERVER['CONTENT_TYPE'] ?? 'not set',
        ]);

        // Check if we have any files at all
        if (empty($request->allFiles())) {
            \Log::error('No files in request at all');
            return response()->json(['error' => 'No files in request'], 400);
        }

        // Check specifically for 'image' field
        if (!$request->hasFile('image')) {
            \Log::error('No image field in request', [
                'available_files' => array_keys($request->allFiles())
            ]);
            return response()->json(['error' => 'No file uploaded in image field'], 400);
        }

        $file = $request->file('image');
        
        \Log::info('File received', [
            'original_name' => $file->getClientOriginalName(),
            'size' => $file->getSize(),
            'mime_type' => $file->getMimeType(),
            'error' => $file->getError(),
            'is_valid' => $file->isValid(),
            'temp_path' => $file->path(),
        ]);
        
        // Check for upload errors
        if ($file->getError() !== UPLOAD_ERR_OK) {
            $errorMessages = [
                UPLOAD_ERR_INI_SIZE => 'File too large (exceeds upload_max_filesize)',
                UPLOAD_ERR_FORM_SIZE => 'File too large (exceeds MAX_FILE_SIZE)',
                UPLOAD_ERR_PARTIAL => 'File was only partially uploaded',
                UPLOAD_ERR_NO_FILE => 'No file was uploaded',
                UPLOAD_ERR_NO_TMP_DIR => 'Missing temporary folder',
                UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk',
                UPLOAD_ERR_EXTENSION => 'File upload stopped by extension',
            ];
            
            $errorMessage = $errorMessages[$file->getError()] ?? 'Unknown upload error';
            \Log::error('File upload error: ' . $errorMessage);
            return response()->json(['error' => $errorMessage], 400);
        }

        // Check if file is valid
        if (!$file->isValid()) {
            \Log::error('File is not valid');
            return response()->json(['error' => 'Invalid file'], 400);
        }

        try {
            // Validate file
            $validator = \Validator::make($request->all(), [
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            ]);

            if ($validator->fails()) {
                \Log::error('Validation failed', $validator->errors()->toArray());
                return response()->json([
                    'error' => 'Validation failed: ' . implode(', ', $validator->errors()->all())
                ], 422);
            }

            // Generate unique filename
            $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
            
            // Move file to public/uploads directory directly
            $file->move(public_path('uploads'), $filename);
            
            $url = asset('uploads/' . $filename);
            
            \Log::info('File uploaded successfully', ['path' => 'uploads/' . $filename, 'url' => $url]);
            
            return response()->json([
                'success' => true,
                'url' => $url,
                'path' => 'uploads/' . $filename
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Upload exception: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => 'Upload failed: ' . $e->getMessage()], 500);
        }
    }
}
