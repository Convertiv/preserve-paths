<?php

/**
 * @file
 * Contains Convertiv\PreservePaths\Plugin.
 */

namespace Convertiv\PreservePaths;

use Composer\Composer;
use Composer\EventDispatcher\EventSubscriberInterface;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;
use Composer\Installer\PackageEvent;
use Composer\Script\ScriptEvents;

/**
 * Class Plugin.
 */
class Plugin implements PluginInterface, EventSubscriberInterface
{

    /**
     * @var \Convertiv\PreservePaths\PluginWrapper
     */
    protected $wrapper;

    /**
     * {@inheritdoc}
     */
    public function activate(Composer $composer, IOInterface $io)
    {
        $this->wrapper = new PluginWrapper($composer, $io);
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            ScriptEvents::PRE_PACKAGE_INSTALL => 'prePackage',
            ScriptEvents::POST_PACKAGE_INSTALL => 'postPackage',
            ScriptEvents::PRE_PACKAGE_UPDATE => 'prePackage',
            ScriptEvents::POST_PACKAGE_UPDATE => 'postPackage',
            ScriptEvents::PRE_PACKAGE_UNINSTALL => 'prePackage',
            ScriptEvents::POST_PACKAGE_UNINSTALL => 'postPackage',
        );
    }

    /**
     * Pre Package event behaviour for backing up preserved paths.
     *
     * @param \Composer\Installer\PackageEvent $event
     */
    public function prePackage(PackageEvent $event)
    {

        $this->wrapper->prePackage($event);
    }

    /**
     * Pre Package event behaviour for backing up preserved paths.
     *
     * @param \Composer\Installer\PackageEvent $event
     */
    public function postPackage(PackageEvent $event)
    {
        $this->wrapper->postPackage($event);
    }

    /**
     * Remove any hooks from Composer
     *
     * This will be called when a plugin is deactivated before being
     * uninstalled, but also before it gets upgraded to a new version
     * so the old one can be deactivated and the new one activated.
     *
     * @param Composer    $composer
     * @param IOInterface $io
     */
    public function deactivate(Composer $composer, IOInterface $io)
    {
    }

    /**
     * Prepare the plugin to be uninstalled
     *
     * This will be called after deactivate.
     *
     * @param Composer    $composer
     * @param IOInterface $io
     */
    public function uninstall(Composer $composer, IOInterface $io)
    {
    }
}
