<?php
namespace UsabilityDynamics\Installers;

class ModuleInstaller extends BaseInstaller
{
    protected $locations = array(
        'module'    => 'modules/{$name}/'
    );
}
