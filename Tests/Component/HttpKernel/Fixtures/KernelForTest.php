<?php

namespace YottaCms\Framework\Tests\Component\HttpKernel\Fixtures;

use YottaCms\Framework\Component\HttpKernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class KernelForTest extends HttpKernel\Kernel
{
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
