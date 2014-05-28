<?php
namespace UsabilityDynamics\Installers {

  use Composer\Installer\LibraryInstaller;
  use Composer\Package\PackageInterface;
  use Composer\Repository\InstalledRepositoryInterface;

  class ProductModule extends LibraryInstaller {

    protected $locations = array(
      'package'   => 'wp-content/package/{$name}/',
      'module'    => 'wp-content/module/{$name}/'
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
     * {@inheritDoc}
     */
    public function getPackageBasePath(PackageInterface $package) {

      $prefix = substr($package->getPrettyName(), 0, 23);

      if ('wp-module-' !== $prefix) {
        // throw new \InvalidArgumentException( 'Unable to install template, WP Module templates should always start with wp-module-' );
      }

      return 'vendor/module/'.substr($package->getPrettyName(), 23);

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