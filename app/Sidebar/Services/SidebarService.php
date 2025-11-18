<?php

namespace App\Sidebar\Services;

use App\Sidebar\Link;
use App\Sidebar\Section;
use App\Sidebar\Submenu;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;

class SidebarService
{
    public function build(): Collection
    {
        return collect([
            new Link(
                text: 'Dashboard',
                route: 'dashboard',
                icon: 'fa-solid fa-chart-pie',
                //permission: 'ver_dashboard',
                modulePermissions: ['ver_dashboard']
            ),
            (new Section('Almacén'))
                ->addChild(new Link(
                    text: 'Almacenes',
                    route: null,
                    icon: 'fa-solid fa-warehouse',
                    //permission: 'ver_dashboard',
                    //modulePermissions: ['ver_dashboard']
                ))
                ->addChild((new Submenu(
                    text: 'Compras',
                    icon: 'fa-solid fa-cart-shopping',
                ))
                ->addChild(new Link(
                    text: 'Cotizaciones',
                    route: null,
                    //icon: 'fa-solid fa-boxes-stacked',
                    //permission: 'ver_dashboard',
                    //modulePermissions: ['ver_dashboard']
                ))
                ->addChild(new Link(
                    text: 'Órdenes de Compra',
                    route: null,
                    //icon: 'fa-solid fa-warehouse',
                    //permission: 'ver_dashboard',
                    //modulePermissions: ['ver_dashboard']
                ))),
            (new Submenu(
                text: 'Catálogo',
                icon: 'fa-solid fa-boxes-stacked'
            ))
                ->addChild(new Link(
                    text: 'Productos',
                    route: null,
                    //icon: 'fa-solid fa-boxes-stacked',
                    //permission: 'ver_dashboard',
                    //modulePermissions: ['ver_dashboard']
                ))
                ->addChild(new Link(
                    text: 'Categorías',
                    route: 'categories',
                    //icon: 'fa-solid fa-warehouse',
                    //permission: 'ver_dashboard',
                    //modulePermissions: ['ver_dashboard']
                ))
                ->addChild(new Link(
                    text: 'Colores',
                    route: null,
                    //icon: 'fa-solid fa-boxes-stacked',
                    //permission: 'ver_dashboard',
                    //modulePermissions: ['ver_dashboard']
                ))
                ->addChild(new Link(
                    text: 'Marcas',
                    route: null,
                    //icon: 'fa-solid fa-boxes-stacked',
                    //permission: 'ver_dashboard',
                    //modulePermissions: ['ver_dashboard']
                ))
                ->addChild(new Link(
                    text: 'Modelos',
                    route: null,
                    //icon: 'fa-solid fa-boxes-stacked',
                    //permission: 'ver_dashboard',
                    //modulePermissions: ['ver_dashboard']
                ))
                ->addChild(new Link(
                    text: 'Tallas',
                    route: null,
                    //icon: 'fa-solid fa-boxes-stacked',
                    //permission: 'ver_dashboard',
                    //modulePermissions: ['ver_dashboard']
                )),
            (new Section('Administración'))
                ->addChild(new Link(
                    text: 'Usuarios',
                    route: 'users',
                    icon: 'fa-solid fa-users',
                    //permission: 'ver_usuario',
                    modulePermissions: ['ver_usuario', 'crear_usuario', 'editar_usuario', 'eliminar_usuario']
                ))
                ->addChild(new Link(
                    text: 'Roles y Permisos',
                    route: 'roles',
                    icon: 'fa-solid fa-user-shield',
                    //permission: 'ver_rol',
                    modulePermissions: ['ver_rol', 'crear_rol', 'editar_rol', 'eliminar_rol']
                )),

            (new Section('Reportes'))
                ->addChild(new Link(
                    text: 'Inventario y KPIs',
                    route: null,
                    icon: 'fa-solid fa-chart-line',
                    //permission: 'ver_usuario',
                    //modulePermissions: ['ver_usuario', 'crear_usuario', 'editar_usuario', 'eliminar_usuario']
                ))
                ->addChild(new Link(
                    text: 'Devoluciones',
                    route: null,
                    icon: 'fa-solid fa-rotate-left',
                    //permission: 'ver_rol',
                    //modulePermissions: ['ver_rol', 'crear_rol', 'editar_rol', 'eliminar_rol']
                )),
        ]);
    }

    public function getPermissionsByModule(): array
    {
        $allLinks = $this->extractLinks($this->build());

        return $allLinks
            ->filter(fn($link) => !empty($link->modulePermissions))
            ->groupBy(fn($link) => $link->text)
            ->map(function (Collection $moduleLinks) {
                return $moduleLinks->flatMap(fn($link) => $link->modulePermissions)
                    ->map(fn($permission) => [
                        'name' => $permission,
                        'label' => $this->formatLabel($permission),
                    ])
                    ->values()
                    ->all();
            })
            ->all();
    }

    private function extractLinks(Collection $items): Collection
    {
        return $items->flatMap(function ($item) {
            if ($item instanceof Link) {
                return [$item];
            }

            if (($item instanceof Section || $item instanceof Submenu) && $item->children->isNotEmpty()) {
                return $this->extractLinks($item->children);
            }

            return [];
        });
    }

    private function formatLabel(string $permissionName): string
    {
        return Str::of($permissionName)->replace('_', ' ')->ucfirst()->toString();
    }
}
