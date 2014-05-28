<?php
namespace UsabilityDynamics\Installers {

  class ProductInstaller extends BaseInstaller {
      protected $locations = array(
        'product-module'    => 'modules/{$name}/'
      );
  }

}