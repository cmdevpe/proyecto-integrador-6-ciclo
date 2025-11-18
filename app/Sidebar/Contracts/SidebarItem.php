<?php

namespace App\Sidebar\Contracts;

interface SidebarItem
{
    /**
     * Determina si el componente debe ser visible para el usuario.
     */
    public function authorize(): bool;

    /**
     * Genera la representación HTML del componente.
     */
    public function render(): string;

    /**
     * Comprueba si la ruta del componente coincide con la ruta actual.
     */
    public function isActive(): bool;
}
