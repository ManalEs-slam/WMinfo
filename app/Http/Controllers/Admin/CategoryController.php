<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with('parent')->orderBy('name')->paginate(12);

        return view('admin.categories.index', [
            'categories' => $categories,
            'parents' => Category::orderBy('name')->get(),
        ]);
    }

    public function store(CategoryRequest $request)
    {
        $data = $request->validated();
        $data['slug'] = Str::slug($data['name']);
        $data['is_active'] = (bool) ($data['is_active'] ?? false);

        Category::create($data);

        return back()->with('success', 'Categorie creee.');
    }

    public function update(CategoryRequest $request, Category $category)
    {
        $data = $request->validated();
        $data['slug'] = Str::slug($data['name']);
        $data['is_active'] = (bool) ($data['is_active'] ?? false);

        $category->update($data);

        return back()->with('success', 'Categorie mise a jour.');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return back()->with('success', 'Categorie supprimee.');
    }
}
