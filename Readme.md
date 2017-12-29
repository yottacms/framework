# Yotta.CMS Framework Components for Symfony

## Installation
```Bash
composer require yottacms/framework

```
## Usage
Рекурсивная разгрузка зависимых бандлов

```PHP
// app/AppKernel.php or src/Kernel.php in Symfony >= v3.4
use YottaCms\Framework\Component\HttpKernel\PreloadBundlesKernelTrait;
// ...

class AppKernel extends BaseKernel
{
    use PreloadBundlesKernelTrait;
    
    public function registerBundles()
    {
        $bundles = array(
            // ...
            \YourBundleNS\YourBundle::class
            // OR new YourBundleNS\YourBundle()
        );
        // ...
        
        return $this->preloadBundles($bundles);
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
            \Symfony\Cmf\Bundle\RoutingBundle\CmfRoutingBundle::class   // @example
        ];
    }
}
```
