<?php
namespace UsabilityDynamics\Installers {

  class ModuleInstaller extends BaseInstaller {
      protected $locations = array(
        'product-module'    => 'modules/{$name}/'
      );
  }

}