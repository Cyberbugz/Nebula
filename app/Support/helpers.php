<?php

if (!function_exists('modules_path')) {
    function modules_path(): string {
        return app_path(config('app.modules_path'));
    }
}

if (!function_exists('app_modules')) {
    function app_modules(): array {
        return array_filter(scandir(modules_path()), fn($module) => !in_array($module, ['.', '..']));
    }
}

if (!function_exists('get_module_path')) {
    function get_module_path(string $module, array $subdirectories): string {
        return implode(DIRECTORY_SEPARATOR, [modules_path(), ucfirst($module), ...$subdirectories]);
    }
}

if (!function_exists('get_module_namespace')) {
    function get_module_namespace(string $rootNamespace, string $module, array $subdirectories, string $modulesRoot = ''): string {
        if (!$modulesRoot) {
            $modulesRoot = config('app.modules_path');
        }
        $subdirectories = array_filter($subdirectories);

        return  implode('\\', [str_replace('\\', '', $rootNamespace), $modulesRoot, ucfirst($module), ...$subdirectories]);
    }
}

if (!function_exists('modules_view_paths')) {
    function modules_view_paths(): array
    {
        return array_filter(array_reduce(app_modules(), function($paths, $module) {
            $paths[] = get_module_path($module, ['View']);
            return $paths;
        }, []), fn($path) => file_exists($path));
    }
}
