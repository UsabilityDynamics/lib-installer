<?php
namespace UsabilityDynamics\Installers {

use Composer\Installer\LibraryInstaller;
use Composer\Package\PackageInterface;
use Composer\Package\CompletePackage;
use Composer\Repository\InstalledRepositoryInterface;

class ProductModule extends LibraryInstaller
{

  /**
   * Our supported object types
   */
  protected $supported = array(
    'wordpress-plugin',
    'wordpress-muplugin'
  );

  /**
   * Our supported directory maps
   */
  protected $directory_map = array(
    'wordpress-plugin' => 'modules/::name::',
    'wordpress-muplugin' => 'libraries/::vendor::/::name::'
  );

  /**
   * Our install method overrides the parent class' method so that we can duplicate repos
   * when there are multiple versions needed
   */
  public function install( InstalledRepositoryInterface $repo, PackageInterface $package ){

    print "Installing::" . $package->getPrettyName() . "::" . $package->getPrettyVersion() . "\r\n";
    /** First, check to see if we have extra versions to install */
    if( $this->composer->getPackage() && !isset( $package->isClone ) ){
      $extra = $this->composer->getPackage()->getExtra();
      if( @is_array( $extra[ 'wordpress' ][ 'versions' ][ $package->getType() ][ $package->getName() ] ) ){
        $versions = $extra[ 'wordpress' ][ 'versions' ][ $package->getType() ][ $package->getName() ];
        if( count( $versions ) ){
          /** Pull in some vars */
          $package_dist_url = $package->getDistUrl();
          $package_name = explode( '/', $package->getName() );
          $package_name = array_pop( $package_name );
          $package_version = $package->getPrettyVersion() == 'dev-trunk' ? 'master' : $package->getPrettyVersion();
          /** Now, loop through each of our versions */
          foreach( $versions as $version ){
            /** If we have a master, break out */
            if( $version === 'master' ){
              continue;
            }
            /** Ok, we need to change the dist url */
            switch( true ){
              /** If they're from the WP repository */
              case ( stripos( $package_dist_url, 'http://downloads.wordpress.org/plugin/' . $package_name . '.zip' ) !== false ):
              case ( stripos( $package_dist_url, 'http://downloads.wordpress.org/plugin/' . $package_name . '.' . $package_version . '.zip' ) !== false ):
                /** Ok, set the new reference, and set the new dist URL */
                $new_package = new Package( $package->getName() . '-' . $version, $version, $version );
                $new_package->setId( uniqid() );
                $new_package->loadFromParent( $package );
                $new_package->setDistUrl( 'http://downloads.wordpress.org/plugin/' . $package_name . '.' . $version . '.zip' );
                $new_package->setSourceReference( 'tags/' . $version );
                /** For the new package, mark it as a clone */
                $new_package->isClone = true;
                /** Now, add it to the whole thing */
                echo "Adding new version of plugin: " . $new_package->getName() . '::' . $new_package->getPrettyVersion() . "\r\n";
                $repo->addPackage( $new_package );
                /** Also, call the installation */
                parent::install( $repo, $new_package );
                break;
            }
          }
        }
      }
    }
    /** Go ahead and call the parent */
    return parent::install( $repo, $package );

  }

  /**
   * We use this class to override where the items will be stored, instead of relying on the config file
   *
   * @todo Add support for install-paths
   */
  protected function getPackageBasePath( PackageInterface $package ){
    /** Ok, so we have a custom directory for modules */
    $parent_return = parent::getPackageBasePath( $package );
    /** Pull in our package name */
    $package_name = explode( '/', $package->getName() );
    /** Ok, see if we have a vendor and package name */
    if( count( $package_name ) == 2 ){
      $vendor_name = $package_name[ 0 ];
      $package_name = $package_name[ 1 ];
    }else{
      $vendor_name = '';
      $package_name = $package->getName();
    }
    /** Ok, see if we have a valid Dir */
    if( $this->vendorDir ){
      $install_path = dirname( $this->vendorDir ) . '/' . $this->directory_map[ $package->getType() ];
      /** Ok, now we're going to do our string replacement */
      $install_path = str_ireplace( '::vendor::', $vendor_name, $install_path );
      $install_path = str_ireplace( '::name::', $package_name, $install_path );
      /** Return the vendor dir */
      return $install_path;
    }else{
      /** We just return our package name */
      return $package_name;
    }
  }

  /**
   * Returns which object types we support
   */
  public function supports( $packageType ){
    return in_array( $packageType, $this->supported );
  }

}

}