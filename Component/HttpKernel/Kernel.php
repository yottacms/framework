<?php

namespace YottaCms\Framework\Component\HttpKernel;

use Symfony\Component\HttpKernel;

/**
 * Redesign base symfony kernel
 */
abstract class Kernel extends HttpKernel\Kernel implements KernelInterface
{
	
	/**
	 * Preloading bundles with sub depend bundles
	 * @param  array  $bundles
	 * @return array
	 */
	public function preloadingBundles(array $bundles) 
	{
		
		$bundlesArray = [];
		foreach ($bundles as $bundle) {
			
			if (is_object($bundle)) {
				$lastLoadedBundle = $bundle;
			}
			else if (class_exists($bundle)) {
				$lastLoadedBundle = new $bundle();
			}
			else {
				throw new \InvalidArgumentException(sprintf('Bundle "%s" does not exist or it is not enabled.', $bundle));
			}
			
			if (method_exists($lastLoadedBundle, 'registerBundles')) {
				$bundlesArray = array_merge($bundlesArray, $this->preloadingBundles($lastLoadedBundle->registerBundles()));
			}
			
			$bundlesArray[] = $lastLoadedBundle;

		}
		
		return $bundlesArray;
		
	}

}
