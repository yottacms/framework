# Yotta.CMS Framework Components for Symfony

## Installation
```Bash
composer require yottacms/framework

```
## Usage
Рекурсивная разгрузка зависимых бандлов

```PHP
// src/Kernel.php in Symfony >= v4
use YottaCms\Framework\Component\HttpKernel\PreloadBundlesKernelTrait;
// ...

class Kernel extends BaseKernel
{
    use MicroKernelTrait, PreloadBundlesKernelTrait;

    // remove or rename default "registerBundles" method (it will be replaced by PreloadBundlesKernelTrait)
    public function registerBundlesDisabled()
    {
        $contents = require $this->getProjectDir().'/config/bundles.php';
        foreach ($contents as $class => $envs) {
            if (isset($envs['all']) || isset($envs[$this->environment])) {
                yield new $class();
            }
        }
    }

    // ...
}

// YourBundle.php
namespace YourBundleNS;
use Symfony\Component\HttpKernel\Bundle\Bundle;
// ...

class YourBundle extends Bundle
{
    public function registerBundles()
    {
        return [
            \Symfony\Cmf\Bundle\RoutingBundle\CmfRoutingBundle::class => ['all' => true],   // @example
        ];
    }
}
```
