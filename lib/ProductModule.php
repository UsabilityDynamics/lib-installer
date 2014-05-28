<?php
namespace UsabilityDynamics\Installers {

  use Composer\Installer\LibraryInstaller;
  use Composer\Package\PackageInterface;
  use Composer\Package\CompletePackage;
  use Composer\Repository\InstalledRepositoryInterface;

  class ProductModule extends LibraryInstaller {

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
     */
    public function install( InstalledRepositoryInterface $repo, PackageInterface $package ) {

      print "Installing::" . $package->getPrettyName() . "::" . $package->getPrettyVersion() . " (ProductModule)\r\n";

      return parent::install( $repo, $package );

    }

    /**
     * We use this class to override where the items will be stored, instead of relying on the config file
     *
     * @todo Add support for install-paths
     */
    protected function getPackageBasePath( PackageInterface $package ) {
      /** Ok, so we have a custom directory for modules */
      $parent_return = parent::getPackageBasePath( $package );
      /** Pull in our package name */
      $package_name = explode( '/', $package->getName() );
      /** Ok, see if we have a vendor and package name */
      if( count( $package_name ) == 2 ) {
        $vendor_name  = $package_name[ 0 ];
        $package_name = $package_name[ 1 ];
      } else {
        $vendor_name  = '';
        $package_name = $package->getName();
      }
      /** Ok, see if we have a valid Dir */
      if( $this->vendorDir ) {
        $install_path = dirname( $this->vendorDir ) . '/' . $this->directory_map[ $package->getType() ];
        /** Ok, now we're going to do our string replacement */
        $install_path = str_ireplace( '::vendor::', $vendor_name, $install_path );
        $install_path = str_ireplace( '::name::', $package_name, $install_path );

        /** Return the vendor dir */

        return $install_path;
      } else {
        /** We just return our package name */
        return $package_name;
      }
    }

    /**
     * Returns which object types we support
     */
    public function supports( $packageType ) {
      return in_array( $packageType, $this->supported );
    }

  }

}