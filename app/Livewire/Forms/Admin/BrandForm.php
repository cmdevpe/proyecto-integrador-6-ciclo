<?php

namespace App\Livewire\Forms\Admin;

use Livewire\Form;
use App\Models\Brand;
use Livewire\Attributes\Validate;

class BrandForm extends Form
{
    public ?int $brand_id = null;

    #[Validate('required|string|max:255')]
    public string $name = '';

    #[Validate('boolean')]
    public bool $status = true;

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:brands,name,' . $this->brand_id,
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre de la marca es obligatorio.',
            'name.unique' => 'Ya existe una marca con este nombre.',
            'name.max' => 'El nombre no debe superar los 255 caracteres.',
            'status.boolean' => 'El formato del estado es incorrecto.',
        ];
    }

    public function setBrand(Brand $brand): void
    {
        $this->brand_id = $brand->id;
        $this->name = $brand->name;
        $this->status = (bool) $brand->status;
        $this->resetValidation();
    }

    public function store(): Brand
    {
        $validated = $this->validate();
        return Brand::create($validated);
    }

    public function update(): Brand
    {
        $validated = $this->validate();
        $brand = Brand::findOrFail($this->brand_id);
        $brand->update($validated);
        return $brand;
    }

    public function resetForm(): void
    {
        $this->reset();
        $this->status = true;
        $this->resetValidation();
    }
}
