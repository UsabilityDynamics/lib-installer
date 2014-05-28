<?php

namespace UsabilityDynamics\Installers {

  use \Composer\Composer;
  use \Composer\IO\IOInterface;
  use \Composer\Plugin\PluginInterface;

  class ProductModuleInstaller implements PluginInterface {
      public function activate(Composer $composer, IOInterface $io)
      {
          $installer = new TemplateInstaller($io, $composer);
          $composer->getInstallationManager()->addInstaller($installer);
      }
  }

}