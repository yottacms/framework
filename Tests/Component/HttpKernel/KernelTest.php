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
		$bundleB = $this->getBundle('BundleB', array(
			$subBundleA, $subBundleB
		));
		
        $kernel = $this->getKernelForTest(array('registerBundles'));
        $kernel
            ->expects($this->once())
            ->method('registerBundles')
            ->will($this->returnValue($kernel->preloadBundles(array($bundleA, $bundleB))))
        ;
		
		$kernel->boot();
        
        $this->assertTrue(array(
			$bundleA->getName() 	=> array($bundleA), 
            $subBundleA->getName()	=> array($subBundleA), 
			$subBundleB->getName()	=> array($subBundleB), 
			$bundleB->getName()		=> array($bundleB)
		) === $kernel->getBundleMap());

	}
    
    public function testPreloadBundleTwice()
	{
		$bundleA = $this->getBundle('BundleA');
		$subBundleA = $this->getBundle('SubBundleA');
		$subBundleB = $this->getBundle('SubBundleB');
		$bundleB = $this->getBundle('BundleB', array(
			$subBundleA, $subBundleB, $bundleA
		));
		
        $kernel = $this->getKernelForTest(array('registerBundles'));
        $kernel
            ->expects($this->once())
            ->method('registerBundles')
            ->will($this->returnValue($kernel->preloadBundles(array($bundleA, $bundleB, $subBundleA))))
        ;
		
		$kernel->boot();
        
        $this->assertTrue(array(
			$bundleA->getName() 	=> array($bundleA), 
            $subBundleA->getName()	=> array($subBundleA), 
			$subBundleB->getName()	=> array($subBundleB), 
			$bundleB->getName()		=> array($bundleB)
		) === $kernel->getBundleMap());

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
            ->setMethods(array('getName', 'registerBundles'))
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
	protected function getKernelForTest(array $methods = array())
    {
        return $this->getMockBuilder('YottaCms\Framework\Tests\Component\HttpKernel\Fixtures\KernelForTest')
            ->setConstructorArgs(array('test', false))
            ->setMethods($methods)
            ->getMock();
    }

}
