<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    /**
     * Display the gallery grid.
     */
    public function index()
    {
        $images = Image::latest()->paginate(24);
        return view('pages.gallery.index', compact('images'));
    }

    /**
     * Store a newly uploaded image in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120', // Max 5MB
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            // Store the file in the public disk under 'gallery' directory
            $path = $file->storeAs('gallery', $filename, 'public');

            $image = Image::create([
                'filename' => $filename,
                'path' => $path,
                // Generate URL that works regardless of APP_URL configuration
                'url' => Storage::url($path),
            ]);

            if ($request->wantsJson()) {
                return response()->json([
                    'message' => 'Imagem enviada com sucesso.',
                    'image' => $image
                ], 201);
            }

            return redirect()->route('gallery.index')->with('success', 'Imagem enviada com sucesso para a galeria.');
        }

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Ocorreu um erro ao enviar a imagem.'], 400);
        }

        return back()->with('error', 'Ocorreu um erro ao enviar a imagem.');
    }

    /**
     * Remove the specified image from storage and database.
     */
    public function destroy(Image $image)
    {
        // Delete from storage
        if (Storage::disk('public')->exists($image->path)) {
            Storage::disk('public')->delete($image->path);
        }

        // Delete from database
        $image->delete();

        return redirect()->route('gallery.index')->with('success', 'Imagem excluída com sucesso.');
    }
}
