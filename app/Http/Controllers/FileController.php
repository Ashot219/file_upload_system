<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class FileController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:pdf,docx|max:10240'  // 10MB limit
        ]);

        $file = $request->file('file');
        $filePath = $file->storeAs('uploads', time() . '.' . $file->getClientOriginalExtension());

        File::create([
            'filename' => $file->getClientOriginalName(),
            'path' => $filePath,
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize(),
            'uploaded_at' => now(),
        ]);

        return redirect()->back()->with('success', 'File uploaded successfully!');
    }

    public function index()
    {
        $files = File::all();
        return view('files.index', compact('files'));
    }

    public function destroy($id)
    {
        try {
            $file = File::findOrFail($id);

            if ($file->path) {
                Storage::delete($file->path);
            }

            $file->delete();

            dispatch(new \App\Jobs\FileDeleted($file));

            return response()->json([
                'status' => 'success',
                'message' => 'File deleted successfully!',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error occurred while deleting the file. ' . $e->getMessage(),
            ], 500);
        }
    }
}
