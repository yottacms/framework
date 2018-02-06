<?php

namespace YottaCms\Framework\Tests\Component\HttpKernel;

use YottaCms\Framework\Component\HttpKernel;

class KernelTest extends \PHPUnit_Framework_TestCase 
{
	
	public function testPreloadBundles()
	{
		$bundleA = $this->getBundle('BundleA');
		$subBundleA = $this->getBundle('SubBundleA');
		$subBundleB = $this->getBundle('SubBundleB');
		$bundleB = $this->getBundle('BundleB', [$subBundleA, $subBundleB]);
		
        $kernel = $this->getKernelForTest(['registerBundles']);
        $kernel
            ->expects($this->once())
            ->method('registerBundles')
            ->will($this->returnValue($kernel->preloadBundles([$bundleA, $bundleB])))
        ;
		
		$kernel->boot();
		
        $this->assertTrue([
			$bundleA->getName() 	=> $bundleA, 
            $subBundleA->getName()	=> $subBundleA, 
			$subBundleB->getName()	=> $subBundleB, 
			$bundleB->getName()		=> $bundleB
		] === $kernel->getBundleMap());

	}
    
    public function testPreloadBundleTwice()
	{
		$bundleA = $this->getBundle('BundleA');
		$subBundleA = $this->getBundle('SubBundleA');
		$subBundleB = $this->getBundle('SubBundleB');
		$bundleB = $this->getBundle('BundleB', [$subBundleA, $subBundleB, $bundleA]);
		
        $kernel = $this->getKernelForTest(['registerBundles']);
        $kernel
            ->expects($this->once())
            ->method('registerBundles')
            ->will($this->returnValue($kernel->preloadBundles([$bundleA, $bundleB, $subBundleA])))
        ;
		
		$kernel->boot();
        
        $this->assertTrue([
			$bundleA->getName() 	=> ($bundleA), 
            $subBundleA->getName()	=> ($subBundleA), 
			$subBundleB->getName()	=> ($subBundleB), 
			$bundleB->getName()		=> ($bundleB)
		] === $kernel->getBundleMap());

	}
	
	/**
     * Returns a mock for the BundleInterface.
     *
     * @return BundleInterface
     */
    protected function getBundle($className = null, array $subBundles = [])
    {
        $bundle = $this
            ->getMockBuilder('Symfony\Component\HttpKernel\Bundle\BundleInterface')
            ->setMethods(['getName', 'registerBundles'])
            ->disableOriginalConstructor()
        ;

        if ($className) {
            $bundle->setMockClassName($className);
        }

        $bundle = $bundle->getMockForAbstractClass();

        $bundle
            ->expects($this->any())
            ->method('getName')
            ->will($this->returnValue(get_class($bundle)))
        ;

        $bundle
            ->expects($this->any())
            ->method('registerBundles')
            ->will($this->returnValue($subBundles))
        ;

        return $bundle;
    }
	
	/**
     * Returns a mock for the Kernel
     *
     * @return Kernel
     */
	protected function getKernelForTest(array $methods = [])
    {
        return $this->getMockBuilder('YottaCms\Framework\Tests\Component\HttpKernel\Fixtures\KernelForTest')
            ->setConstructorArgs(['test', false])
            ->setMethods($methods)
            ->getMock();
    }

}
