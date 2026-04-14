<?php

class ClassLoader {
    protected array $directories = [];

    public function __construct(array $directories = []) {
        $this->directories = $directories;
    }

    public function register(): void {
        spl_autoload_register([$this, 'loadClass']);
    }

    protected function loadClass(string $class): void {
        foreach ($this->directories as $directory) {
            // Buscamos el archivo de la clase en cada directorio configurado
            $file = $directory . '/' . $class . '.php';
            
            if (file_exists($file)) {
                require_once $file;
                return;
            }

            // Si tienes subcarpetas (como Domain/Models), esta función recursiva ayuda
            if ($this->loadFromSubdirectories($directory, $class)) {
                return;
            }
        }
    }

    protected function loadFromSubdirectories(string $directory, string $class): bool {
        $it = new RecursiveDirectoryIterator($directory);
        $display = new RecursiveIteratorIterator($it);

        foreach ($display as $file) {
            if ($file->getFilename() === $class . '.php') {
                require_once $file->getPathname();
                return true;
            }
        }
        return false;
    }
}