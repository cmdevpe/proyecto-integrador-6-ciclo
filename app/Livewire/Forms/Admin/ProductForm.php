<?php

namespace App\Livewire\Forms\Admin;

use Livewire\Form;
use App\Models\Product;
use Livewire\Attributes\Validate;

class ProductForm extends Form
{
    public ?int $product_id = null;

    #[Validate('required|exists:categories,id')]
    public $category_id = '';

    #[Validate('nullable|exists:sizes,id')]
    public $size_id = '';

    #[Validate('nullable|exists:product_models,id')]
    public $product_model_id = '';

    #[Validate('nullable|exists:brands,id')]
    public $brand_id = '';

    #[Validate('nullable|exists:colors,id')]
    public $color_id = '';

    #[Validate('required|string|max:255')]
    public string $name = '';

    #[Validate('nullable|string|max:50')]
    public string $sku = '';

    #[Validate('boolean')]
    public bool $status = true;

    public function rules(): array
    {
        return [
            'sku' => 'nullable|string|max:50|unique:products,sku,' . $this->product_id,
        ];
    }

    public function setProduct(Product $product): void
    {
        $this->product_id = $product->id;
        $this->category_id = $product->category_id;
        $this->size_id = $product->size_id;
        $this->product_model_id = $product->product_model_id;
        $this->brand_id = $product->brand_id;
        $this->color_id = $product->color_id;
        $this->name = $product->name;
        $this->sku = $product->sku;
        $this->status = (bool) $product->status;

        $this->resetValidation();
    }

    public function store(): Product
    {
        $validated = $this->validate();
        
        $validated['size_id'] = $validated['size_id'] ?: null;
        $validated['product_model_id'] = $validated['product_model_id'] ?: null;
        $validated['brand_id'] = $validated['brand_id'] ?: null;
        $validated['color_id'] = $validated['color_id'] ?: null;

        return Product::create($validated);
    }

    public function update(): Product
    {
        $validated = $this->validate();

        $validated['size_id'] = $validated['size_id'] ?: null;
        $validated['product_model_id'] = $validated['product_model_id'] ?: null;
        $validated['brand_id'] = $validated['brand_id'] ?: null;
        $validated['color_id'] = $validated['color_id'] ?: null;

        $product = Product::findOrFail($this->product_id);
        $product->update($validated);

        return $product;
    }

    public function resetForm(): void
    {
        $this->reset();
        $this->status = true;
        $this->resetValidation();
    }
}
