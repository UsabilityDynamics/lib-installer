<?php
namespace UsabilityDynamics\Installers {

  use Composer\Installer\LibraryInstaller;
  use Composer\Package\PackageInterface;
  use Composer\Repository\InstalledRepositoryInterface;

  class ProductModule extends LibraryInstaller {

    private $supportedTypes = array(
      'wordpress'    => 'WordPressInstaller',
      'zend'         => 'ZendInstaller',
      'zikula'       => 'ZikulaInstaller',
      'typo3-flow'   => 'TYPO3FlowInstaller',
      'typo3-cms'    => 'TYPO3CmsInstaller',
    );
    protected $locations = array(
      'plugin'    => 'wp-content/plugins/{$name}/',
      'theme'     => 'wp-content/themes/{$name}/',
      'muplugin'  => 'wp-content/mu-plugins/{$name}/',
    );


    /**
     * Our supported object types
     */
    protected $supported = array(
      'wordpress-package',
      'wordpress-module'
    );

    /**
     * Our supported directory maps
     */
    protected $directory_map = array(
      'wordpress-module' => 'modules/::name::',
      'wordpress-package' => 'packages/::name::'
    );

    /**
     * Our install method overrides the parent class' method so that we can duplicate repos
     * when there are multiple versions needed
     *
     */
    public function install( InstalledRepositoryInterface $repo, PackageInterface $package ) {
      print "Installing::" . $package->getPrettyName() . "::" . $package->getPrettyVersion() . " (ProductModule)\r\n";
      return parent::install( $repo, $package );
    }

    /**
     * Returns which object types we support
     *
     */
    public function supports( $packageType ) {
      return in_array( $packageType, (array) $this->supported );
    }

  }

}