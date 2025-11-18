<?php

namespace App\Livewire\Forms\Admin;

use App\Models\Category;
use Livewire\Attributes\Validate;
use Livewire\Form;

class CategoryForm extends Form
{
    public ?int $category_id = null;

    #[Validate('required|string|max:255')]
    public string $name = '';

    #[Validate('boolean')]
    public bool $status = true;

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:categories,name,' . $this->category_id,
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre de la categoría es obligatorio.',
            'name.unique' => 'Ya existe una categoría con este nombre.',
            'name.max' => 'El nombre no debe superar los 255 caracteres.',
            'status.boolean' => 'El formato del estado es incorrecto.',
        ];
    }

    public function setCategory(Category $category): void
    {
        $this->category_id = $category->id;
        $this->name = $category->name;
        $this->status = (bool) $category->status;

        $this->resetValidation();
    }

    public function store(): Category
    {
        $validated = $this->validate();

        return Category::create($validated);
    }

    public function update(): Category
    {
        $validated = $this->validate();

        $category = Category::findOrFail($this->category_id);

        $category->update($validated);

        return $category;
    }

    public function resetForm(): void
    {
        $this->reset();
        $this->status = true;
        $this->resetValidation();
    }
}
