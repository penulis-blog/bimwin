<?php

namespace App\Helpers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ControllerFileGenerator
{
    public static function generate(string $controllerName, string $uriPranala): void
    {
        // Pastikan awalan 'C_' dan lowercase nama file (misalnya C_menu.php)
        $cleanName = Str::snake($controllerName); // misal: "menu"
        $fileName = "C_{$cleanName}.php";
        $className = "C_" . ucfirst($cleanName); // misal: C_menu

        $controllerPath = base_path("Controllers/{$fileName}");

        if (!File::exists($controllerPath)) {
            $stub = "<?php

                class {$className}
                {
                    public function index()
                    {
                        // Halaman: {$uriPranala}
                        echo 'Controller {$className} aktif.';
                    }
                }
            ";
            File::put($controllerPath, $stub);
        }
    }
}
