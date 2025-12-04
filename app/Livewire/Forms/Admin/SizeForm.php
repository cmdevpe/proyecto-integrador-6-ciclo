<?php

namespace App\Livewire\Forms\Admin;

use Livewire\Form;
use App\Models\Size;
use Livewire\Attributes\Validate;

class SizeForm extends Form
{
    public ?int $size_id = null;

    #[Validate('required|string|max:255')]
    public string $name = '';

    #[Validate('boolean')]
    public bool $status = true;

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:sizes,name,' . $this->size_id,
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre de la talla es obligatorio.',
            'name.unique' => 'Ya existe una talla con este nombre.',
            'name.max' => 'El nombre no debe superar los 255 caracteres.',
            'status.boolean' => 'El formato del estado es incorrecto.',
        ];
    }

    public function setSize(Size $size): void
    {
        $this->size_id = $size->id;
        $this->name = $size->name;
        $this->status = (bool) $size->status;

        $this->resetValidation();
    }

    public function store(): Size
    {
        $validated = $this->validate();
        return Size::create($validated);
    }

    public function update(): Size
    {
        $validated = $this->validate();
        $size = Size::findOrFail($this->size_id);
        $size->update($validated);
        return $size;
    }

    public function resetForm(): void
    {
        $this->reset();
        $this->status = true;
        $this->resetValidation();
    }
}
