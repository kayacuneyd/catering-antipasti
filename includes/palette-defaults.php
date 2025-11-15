<?php
/**
 * Canonical palette presets shared between the public site and the admin.
 */

if (!function_exists('palette_default_presets')) {
    function palette_default_presets(): array
    {
        return [
            'classic' => [
                'olive' => '#6C1F2B',
                'sangiovese' => '#6C1F2B',
                'verona' => '#F5E6D3',
                'terracotta' => '#E8B944',
                'seagray' => '#7A8C8E',
                'vineyard' => '#6C1F2B',
                'cream' => '#FFFFFF',
            ],
            'toscana' => [
                'olive' => '#5C4A3C',
                'sangiovese' => '#D4704A',
                'verona' => '#F5E6D3',
                'terracotta' => '#E8B944',
                'seagray' => '#7A8C8E',
                'vineyard' => '#3A5A40',
                'cream' => '#FFFFFF',
            ],
            'amalfi' => [
                'olive' => '#023E8A',
                'sangiovese' => '#0077B6',
                'verona' => '#FFFFFF',
                'terracotta' => '#FFD60A',
                'seagray' => '#4D7D8C',
                'vineyard' => '#023E8A',
                'cream' => '#F5FBFF',
            ],
            'sicilia' => [
                'olive' => '#1E3A8A',
                'sangiovese' => '#FB923C',
                'verona' => '#FEFCE8',
                'terracotta' => '#DC2626',
                'seagray' => '#4B5563',
                'vineyard' => '#6B21A8',
                'cream' => '#FFFFFF',
            ],
            'venezia' => [
                'olive' => '#1F2937',
                'sangiovese' => '#F59E0B',
                'verona' => '#FEF3C7',
                'terracotta' => '#991B1B',
                'seagray' => '#4B5563',
                'vineyard' => '#1F2937',
                'cream' => '#FFF8E1',
            ],
        ];
    }
}
