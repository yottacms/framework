<?php

namespace YottaCms\Framework\Tests\Component\HttpKernel\Fixtures;

use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use YottaCms\Framework\Component\HttpKernel\PreloadBundlesKernelTrait;

class KernelForTest extends BaseKernel
{
    use PreloadBundlesKernelTrait;

    public function getProjectDir(): string
    {
        return \realpath(__DIR__ . '/../../../../');
    }

    public function getBundleMap()
    {
        return $this->bundles;
    }

    public function registerBundles()
    {
        return [];
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
    }

    public function isBooted()
    {
        return false;
    }
}
