<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class MakeService extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:service {name : The name of the service}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'creates and stores a new service class in the app/services folder';
    /**
     * Generate the content for the service file.
     *
     * @param string $name
     * @return string
     */
    protected function getServiceContent($name)
    {
        $className = $this->getServiceClassName($name);

        return <<<PHP
<?php

namespace App\Services;

class $className
{
    // Add your service logic here
    // ...
}
PHP;
    }
    protected function getServiceFileName($name)
    {
        return $this->getServiceClassName($name) . '.php';
    }
    /**
     * Generate the class name for the service.
     *
     * @param string $name
     * @return string
     */
    protected function getServiceClassName($name)
    {
        return ucfirst(Str::camel($name)) . 'Service';
    }
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');
        $serviceContent = $this->getServiceContent($name);
        $fileName = $this->getServiceFileName($name);

        $path = app_path('Services');
        if (!is_dir($path)) {
            mkdir($path, 0755, true);
        }
        file_put_contents($path . '/' . $fileName, $serviceContent);
        $this->info('Service [' . $path . '/' . $fileName . '] created successfully!');
    }
}