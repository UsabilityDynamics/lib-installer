<?php
/**
 * Module Manager
 *
 * The current manager:
 * Installs, activates, loads and upgrades modules
 */
namespace UsabilityDynamics\Installers {

  /**
   * Class ModuleLoader
   *
   * @package UsabilityDynamics\Installers
   */
  class ModuleLoader {

    /**
     * Constructor
     *
     */
    public function __construct() {
    
    }
    
    /**
     * Make API call to UD to get list of modules that my system can support.
     *
     */
    public function moduleLoadout() {
      
    }
    
    /**
     * If module does not already exist, do not install it. (optional)
     *
     */
    public function upgrade() {
      
    }
    
    /**
     * Download any missing / outdated modules from repository
     *
     */
    public function upgradeModules() {
      
    }
    
    /**
     * Validate a specific module - make sure it can be enabled, etc
     *
     */
    public function validateModule() {
      
    }
    
    /**
     * Activate (instantiate) loaded modules
     *
     */
    public function enableModules() {
      
    }
    
    /**
     * Install Module from Repository
     *
     */
    public function install() {
      
    }
    
    /**
     * Similar to legacy WPP_F::get_api_key() method, 
     * either returns an Access Token determined automatically based on domain, 
     * or validates provided key (if set). 
     * Key should be stored in DB as it will be needed to get downloadable module URLs.
     *
     */
    public function validateKey() {
      
    }
    
    /**
     * Ability to define directories to walk for look for modules 
     * and generate list of all found modules and their settings 
     * (extracted from PHP header or composer.json). 
     * http://screencast.com/t/r6rC9WNcl
     *
     */
    public function loadModules() {
      
    }

  }

}