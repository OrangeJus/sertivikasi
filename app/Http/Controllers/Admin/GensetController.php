<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Genset;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class GensetController extends Controller
{
    public function index(Request $request)
    {
        // Query utama + relasi categories
        $query = Genset::with('categories');

        // 🔍 Filter pencarian nama genset
        if ($q = $request->input('q')) {
            $query->where('nama_genset', 'like', "%{$q}%");
        }

        // 🔍 Filter status genset (tersedia/disewa/rusak)
        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        // 🔍 Filter berdasarkan kategori (optional)
        if ($categoryId = $request->input('category_id')) {
            $query->whereHas('categories', function($sub) use ($categoryId) {
                $sub->where('categories.id', $categoryId);
            });
        }

        $gensets = $query->orderBy('created_at','desc')->paginate(10)->withQueryString();
        $categories = Category::orderBy('nama_kategori')->get();

        return view('admin.gensets.index', compact('gensets','categories'));
    }

    public function create()
    {
        $categories = Category::orderBy('nama_kategori')->get();
        return view('admin.gensets.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_genset' => 'required|string|max:255',
            'kapasitas' => 'nullable|string|max:100',
            'harga_sewa' => 'required|numeric|min:0',
            'status' => 'required|in:tersedia,disewa,rusak',
            'deskripsi' => 'nullable|string',
            'category_ids' => 'required|array|min:1',
            'category_ids.*' => 'exists:categories,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $categoryIds = $validated['category_ids'];
        unset($validated['category_ids']);

        // handle file upload
        if ($request->hasFile('image')) {
            // Simpan file ke storage/app/public/gensets
            $path = $request->file('image')->store('gensets', 'public');
            // Simpan path relatif (tanpa 'public/')
            $validated['image'] = $path;
        }


        $genset = Genset::create($validated);
        $genset->categories()->sync($categoryIds);

        return redirect()->route('admin.gensets.index')->with('success', 'Genset berhasil ditambahkan.');
    }

    public function edit(Genset $genset)
    {
        $categories = Category::orderBy('nama_kategori')->get();
        $genset->load('categories');
        return view('admin.gensets.edit', compact('genset','categories'));
    }

    public function update(Request $request, Genset $genset)
    {
        $validated = $request->validate([
            'nama_genset' => 'required|string|max:255',
            'kapasitas' => 'nullable|string|max:100',
            'harga_sewa' => 'required|numeric|min:0',
            'status' => 'required|in:tersedia,disewa,rusak',
            'deskripsi' => 'nullable|string',
            'category_ids' => 'required|array|min:1',
            'category_ids.*' => 'exists:categories,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $categoryIds = $validated['category_ids'];
        unset($validated['category_ids']);

        // handle new image
        if ($request->hasFile('image')) {
            if ($genset->image && Storage::disk('public')->exists($genset->image)) {
                Storage::disk('public')->delete($genset->image);
            }

            $path = $request->file('image')->store('gensets', 'public');
            $validated['image'] = $path;
        }


        $genset->update($validated);
        $genset->categories()->sync($categoryIds);

        return redirect()->route('admin.gensets.index')->with('success', 'Genset berhasil diperbarui.');
    }

    public function destroy(Genset $genset)
    {
        // hapus image file
        if ($genset->image && Storage::disk('public')->exists($genset->image)) {
            Storage::disk('public')->delete($genset->image);
        }


        $genset->categories()->detach();
        $genset->delete();
        return redirect()->route('admin.gensets.index')->with('success', 'Genset berhasil dihapus.');
    }
}
