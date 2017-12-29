<?php

namespace YottaCms\Framework\Tests\Component\HttpKernel\Fixtures;

use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use YottaCms\Framework\Component\HttpKernel\PreloadBundlesKernelTrait;

class KernelForTest extends BaseKernel
{
    use PreloadBundlesKernelTrait;
    
    public function getBundleMap()
    {
        return $this->bundleMap;
    }

    public function registerBundles()
    {
        return array();
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
    }

    public function isBooted()
    {
        return false;
    }
}
