<?php

namespace App\Http\Controllers;

use App\Models\Dokumentasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;

class DokumentasiController extends Controller
{
    private function processAndStoreImage($file, $folder)
    {
        $extension = strtolower($file->getClientOriginalExtension());
        $filename = uniqid() . '-' . time() . '.webp';

        if ($extension === 'webp') {
            return $file->storeAs($folder, $filename, 'public');
        }

        try {
            $image = null;
            if (in_array($extension, ['jpg', 'jpeg'])) {
                $image = @imagecreatefromjpeg($file->getPathname());
            } elseif ($extension === 'png') {
                $image = @imagecreatefrompng($file->getPathname());
                if ($image) {
                    imagepalettetotruecolor($image);
                    imagealphablending($image, true);
                    imagesavealpha($image, true);
                }
            }

            if ($image) {
                $path = storage_path('app/public/' . $folder);
                if (!file_exists($path)) {
                    mkdir($path, 0775, true);
                }
                $fullPath = $path . '/' . $filename;
                $result = @imagewebp($image, $fullPath, 80);
                imagedestroy($image);
                if ($result) {
                    return $folder . '/' . $filename;
                }
            }
        } catch (\Throwable $e) {
            if (isset($image) && $image) {
                imagedestroy($image);
            }
        }

        return $file->storeAs($folder, $filename, 'public');
    }

    public function index()
    {
        Gate::authorize('isAdmin');
        $dokumentasi = Dokumentasi::latest()->paginate(10);
        return view('dokumentasi.index', compact('dokumentasi'));
    }

    public function create()
    {
        Gate::authorize('isAdmin');
        return view('dokumentasi.create');
    }

    public function store(Request $request)
    {
        Gate::authorize('isAdmin');
        
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'foto' => 'required|image|mimes:jpeg,png,jpg,webp|max:15360',
        ]);

        $path = $this->processAndStoreImage($request->file('foto'), 'dokumentasi');

        Dokumentasi::create([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'foto' => $path,
        ]);

        return redirect()->route('dokumentasi.index')->with('success', 'Dokumentasi berhasil ditambahkan.');
    }

    public function show(string $id)
    {
        // Not used
    }

    public function edit(string $id)
    {
        Gate::authorize('isAdmin');
        $dokumentasi = Dokumentasi::findOrFail($id);
        return view('dokumentasi.edit', compact('dokumentasi'));
    }

    public function update(Request $request, string $id)
    {
        Gate::authorize('isAdmin');
        $dokumentasi = Dokumentasi::findOrFail($id);

        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:15360',
        ]);

        $data = [
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
        ];

        if ($request->hasFile('foto')) {
            if (Storage::disk('public')->exists($dokumentasi->foto)) {
                Storage::disk('public')->delete($dokumentasi->foto);
            }
            $data['foto'] = $this->processAndStoreImage($request->file('foto'), 'dokumentasi');
        }

        $dokumentasi->update($data);

        return redirect()->route('dokumentasi.index')->with('success', 'Dokumentasi berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        Gate::authorize('isAdmin');
        $dokumentasi = Dokumentasi::findOrFail($id);

        if (Storage::disk('public')->exists($dokumentasi->foto)) {
            Storage::disk('public')->delete($dokumentasi->foto);
        }
        
        $dokumentasi->delete();

        return redirect()->route('dokumentasi.index')->with('success', 'Dokumentasi berhasil dihapus.');
    }
}
