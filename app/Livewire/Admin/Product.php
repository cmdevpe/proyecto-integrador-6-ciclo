<?php

namespace App\Livewire\Admin;

use App\Models\Size;
use App\Models\Brand;
use App\Models\Color;
use Livewire\Component;
use App\Models\Category;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use App\Models\ProductModel as Model;
use App\Models\Product as ProductModel;
use App\Livewire\Forms\Admin\ProductForm;

#[Layout('layouts.app')]
#[Title('Productos')]
class Product extends Component
{
    use WithPagination;
    public ProductForm $form;
    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function create(): void
    {
        $this->form->resetForm();
        $this->dispatch('open-modal', name: 'product-form-modal');
    }

    public function edit(ProductModel $product): void
    {
        $this->form->setProduct($product);
        $this->dispatch('open-modal', name: 'product-form-modal');
    }

    public function save(): void
    {
        if ($this->form->product_id) {
            $product = $this->form->update();
            $this->dispatch('toast', type: 'success', message: "Producto actualizado correctamente.");
        } else {
            $product = $this->form->store();
            $this->dispatch('toast', type: 'success', message: "Producto creado correctamente.");
        }

        $this->dispatch('close-modal', name: 'product-form-modal');
        $this->form->resetForm();
    }

    public function delete(ProductModel $product): void
    {
        $product->delete();
        $this->dispatch('toast', type: 'success', message: "Producto eliminado.");
    }

    public function render()
    {
        $products = ProductModel::with(['category', 'size', 'productModel', 'brand', 'color'])
            ->where(function($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('sku', 'like', '%' . $this->search . '%');
            })
            ->orderBy('id', 'desc')
            ->paginate(5);

        return view('livewire.admin.product', [
            'products' => $products,
            'categories' => Category::where('status', true)->orderBy('name')->get(),
            'sizes' => Size::where('status', true)->orderBy('name')->get(),
            'models' => Model::where('status', true)->orderBy('name')->get(),
            'brands' => Brand::where('status', true)->orderBy('name')->get(),
            'colors' => Color::where('status', true)->orderBy('name')->get(),
        ]);
    }
}
