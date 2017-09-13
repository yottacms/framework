<?php

namespace YottaCms\Framework\Component\HttpKernel;

use Symfony\Component\HttpKernel;

interface KernelInterface extends HttpKernel\KernelInterface
{
	/**
	 * Preloading bundles with sub depend bundles
	 * @param  array  $bundles
	 * @return array
	 */
	public function preloadingBundles(array $bundles);

}
