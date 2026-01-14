<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileController extends Controller
{
    public function index(Request $request)
    {
        $query = File::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc');

        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('original_name', 'like', "%{$search}%")
                  ->orWhere('file_name', 'like', "%{$search}%");
            });
        }

        $files = $query->paginate(15);

        return view('files.index', compact('files'));
    }

    public function create()
    {
        return view('files.upload');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'file' => 'required|file|max:40960', // 40MB max
            ]);

            $uploadedFile = $request->file('file');
            $originalName = $uploadedFile->getClientOriginalName();
            $fileName = time() . '_' . Str::random(10) . '.' . $uploadedFile->getClientOriginalExtension();
            $filePath = $uploadedFile->storeAs('uploads', $fileName, 'public');
            $downloadToken = Str::random(32);

            $file = File::create([
                'user_id' => auth()->id(),
                'original_name' => $originalName,
                'file_name' => $fileName,
                'file_path' => $filePath,
                'mime_type' => $uploadedFile->getMimeType(),
                'file_size' => $uploadedFile->getSize(),
                'download_token' => $downloadToken,
            ]);

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'File uploaded successfully',
                    'file' => [
                        'id' => $file->id,
                        'name' => $file->original_name,
                        'size' => $file->formatted_size,
                        'download_url' => route('files.download', $file->download_token),
                    ]
                ]);
            }

            return redirect()->route('files.index')->with('success', 'File uploaded successfully');
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Upload failed',
                    'errors' => $e->errors()
                ], 422);
            }
            throw $e;
        } catch (\Exception $e) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'An error occurred during upload: ' . $e->getMessage()
                ], 500);
            }
            throw $e;
        }
    }

    public function download($token)
    {
        $file = File::where('download_token', $token)->firstOrFail();

        $filePath = Storage::disk('public')->path($file->file_path);
        
        if (!file_exists($filePath)) {
            abort(404);
        }

        return response()->download($filePath, $file->original_name);
    }

    public function view($token)
    {
        $file = File::where('download_token', $token)->firstOrFail();

        $filePath = Storage::disk('public')->path($file->file_path);
        
        if (!file_exists($filePath)) {
            abort(404);
        }

        // Return file for inline viewing (not forcing download)
        return response()->file($filePath, [
            'Content-Type' => $file->mime_type,
            'Content-Disposition' => 'inline; filename="' . $file->original_name . '"'
        ]);
    }

    public function destroy(File $file)
    {
        if ($file->user_id !== auth()->id()) {
            abort(403);
        }

        Storage::disk('public')->delete($file->file_path);
        $file->delete();

        return redirect()->route('files.index')->with('success', 'File deleted successfully');
    }
}
