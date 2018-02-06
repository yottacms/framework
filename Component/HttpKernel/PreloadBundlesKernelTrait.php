<?php

namespace YottaCms\Framework\Component\HttpKernel;

/**
 * Extend base symfony kernel
 */
trait PreloadBundlesKernelTrait
{
    /**
     * Bundles array after calling $this->preloadBundles
     * @var array
     */
    protected $bundlesArray = [];
    

	/**
	 * Preload bundles with sub depend bundles
	 * @param  array  $bundles
	 * @return array
	 */
	public function preloadBundles(array $bundles) 
	{
		foreach ($bundles as $bundle) {
            
			if (is_object($bundle)) {
				$lastLoadedBundle = !$this->isBundleLoaded(get_class($bundle)) ? $bundle : false;
			}
			else if (class_exists($bundle)) {
				$lastLoadedBundle = !$this->isBundleLoaded($bundle) ? new $bundle() : false;
			}
            else {
                throw new \InvalidArgumentException(sprintf('Bundle "%s" does not exist or it is not enabled.', $bundle));
            }
			
            if (false != $lastLoadedBundle) {
    			
                if (method_exists($lastLoadedBundle, 'registerBundles')) {
    				$this->bundlesArray = array_merge($this->bundlesArray, $this->preloadBundles($lastLoadedBundle->registerBundles()));
    			}
    			
    			$this->bundlesArray[get_class($lastLoadedBundle)] = $lastLoadedBundle;
                
            }

		}
		
		return $this->bundlesArray;
	}
    
    /**
     * Check is Bundle already loaded
     * @param  string  $bundleName
     * @return boolean
     */
    protected function isBundleLoaded($bundleName) {
        return isset($this->bundlesArray[$bundleName]);
    }
    
    /**
     * Replacing default registerBundles
     * @return array
     */
    public function registerBundles()
    {
        $bundles = [];
        $contents = require $this->getProjectDir().'/config/bundles.php';
        foreach ($contents as $class => $envs) {
            if (isset($envs['all']) || isset($envs[$this->environment])) {
                $bundles[] = $class;
            }
        }
        return $this->preloadBundles($bundles);
    }
}
