<?php

namespace App\Livewire\Forms\Admin;

use Livewire\Form;
use App\Models\Color;
use Livewire\Attributes\Validate;

class ColorForm extends Form
{
    public ?int $color_id = null;

    #[Validate('required|string|max:255')]
    public string $name = '';

    #[Validate('boolean')]
    public bool $status = true;

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:colors,name,' . $this->color_id,
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre del color es obligatorio.',
            'name.unique' => 'Ya existe un color con este nombre.',
            'name.max' => 'El nombre no debe superar los 255 caracteres.',
            'status.boolean' => 'El formato del estado es incorrecto.',
        ];
    }

    public function setColor(Color $color): void
    {
        $this->color_id = $color->id;
        $this->name = $color->name;
        $this->status = (bool) $color->status;

        $this->resetValidation();
    }

    public function store(): Color
    {
        $validated = $this->validate();
        return Color::create($validated);
    }

    public function update(): Color
    {
        $validated = $this->validate();
        $color = Color::findOrFail($this->color_id);
        $color->update($validated);

        return $color;
    }

    public function resetForm(): void
    {
        $this->reset();
        $this->status = true;
        $this->resetValidation();
    }
}
