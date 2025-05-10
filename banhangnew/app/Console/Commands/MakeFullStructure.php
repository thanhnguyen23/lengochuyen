<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeFullStructure extends Command
{

    protected $signature = 'make:full-structure {name}';
    protected $description = 'Tạo Controller, Repository, Resource cùng một lúc';

    public function handle()
    {
        $name = $this->argument('name');

        // Tạo Controller
        // $this->call('make:controller', [
        //     'name' => "{$name}Controller"
        // ]);

        // Tạo Resource
        // $this->call('make:resource', [
        //     'name' => "{$name}Resource"
        // ]);

        // Tạo Repository Interface
        $interfacePath = app_path("Repositories/Contracts/{$name}RepositoryInterface.php");
        $this->createFile($interfacePath, $this->getInterfaceStub($name));

        // Tạo Repository Implementation
        $repositoryPath = app_path("Repositories/Eloquent/{$name}Repository.php");
        $this->createFile($repositoryPath, $this->getRepositoryStub($name));

        $this->info("Đã tạo Controller, Repository, và Resource cho {$name}.");
    }

    private function createFile($path, $content)
    {
        if (!File::exists(dirname($path))) {
            File::makeDirectory(dirname($path), 0755, true);
        }

        File::put($path, $content);
    }

    private function getInterfaceStub($name)
    {
        return <<<PHP
        <?php

        namespace App\Repositories\Contracts;

        interface {$name}RepositoryInterface
        {
            // Định nghĩa các hàm cần thiết
        }
        PHP;
    }

    private function getRepositoryStub($name)
    {
        return <<<PHP
        <?php

        namespace App\Repositories\Eloquent;

        use App\Repositories\Contracts\\{$name}RepositoryInterface;

        class {$name}Repository implements {$name}RepositoryInterface
        {
            // Triển khai các hàm của Interface
        }
        PHP;
    }
}
