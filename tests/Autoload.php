<?php
class AutoLoader {

	static private $classNames = array();

	/**
	 * Store the filename (sans extension) & full path of all ".php" files found
	 */
	public static function registerDirectory($dirName) {
		$di = new DirectoryIterator($dirName);
		
		foreach ($di as $file) {
			if ($file->isDir() && !$file->isLink() && !$file->isDot()) {
				// recurse into directories other than a few special ones				
				self::registerDirectory($file->getPathname());
				continue;
			}
			
			if(!$file->isDir() && !$file->isLink() && !$file->isDot() && $file->isFile()){
				$classPath = $file->getPathname();
				
				// remove file extension
				$classPath = substr($classPath, 0, -4);
				$convertedClassName = str_replace(DIRECTORY_SEPARATOR, '_', $classPath);
				
				// remove leading libs directory
				if(substr($convertedClassName, 0, 5) === 'core_'){
					$convertedClassName = substr($convertedClassName, 5);
				}
				
				AutoLoader::registerClass($convertedClassName, $file->getPathname());
			}
		}
	}

	public static function registerClass($className, $fileName) {
		$className = strtolower($className);
		AutoLoader::$classNames[$className] = $fileName;
	}

	public static function loadClass($className) {
		$className = strtolower(substr($className, 3));
		
		if (isset(AutoLoader::$classNames[$className])) {
			require_once(AutoLoader::$classNames[$className]);
		}
	}

}
spl_autoload_register(array('AutoLoader', 'loadClass'));
?>