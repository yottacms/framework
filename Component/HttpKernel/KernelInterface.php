<?php

namespace YottaCms\Framework\Component\HttpKernel;

use Symfony\Component\HttpKernel;

interface KernelInterface extends HttpKernel\KernelInterface
{
	/**
	 * Preload bundles with sub depend bundles
	 * @param  array  $bundles
	 * @return array
	 */
	public function preloadBundles(array $bundles);

}
