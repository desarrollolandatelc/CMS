<?php

namespace Modules\FileManager\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\FileManager\Models\FileManager;

class FileManagerController extends Controller
{
    public function getAll()
    {
        $files = FileManager::all();
        return response()->json($files);
    }

    public function save(Request $request)
    {
        $request->validate([
            'files.*' => 'mimes:jpg,jpeg,png|max:10240',
        ]);

        $files = $request->file('files');
        $filesToStorage = [];
        foreach ($files as $file) {
            $path = $file->store('files', 'public');
            $filesToStorage[] = [
                'name' => $file->getClientOriginalName(),
                'path' => $path,
                'extension' => $file->extension(),
                'size' => $file->getSize(),
                'mime_type' => $file->getMimeType(),
                'type' => explode(separator: '/', string: $file->getMimeType())[0],
            ];
        }
        // Save files
        DB::table(table: 'file_managers')->insert($filesToStorage);
        return response()->json(DB::table(table: 'file_managers')->get());
    }
}
