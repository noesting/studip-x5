<?php

/**
 * X5 Stud.IP plugin.
 */
class X5Plugin extends StudIPPlugin implements
    /* Plugin Interfaces */
    SystemPlugin
{
    public function __construct()
    {
        parent::__construct();

        require_once 'vendor/autoload.php';
        bindtextdomain('x5', dirname(__FILE__).'/locale');

        $this->setupNavigation();
    }

    /**
     * This method dispatches all actions.
     *
     * @param string   part of the dispatch path that was not consumed
     *
     * @return void
     */
    public function perform($unconsumedPath) {
        $args = explode('/', $unconsumedPath);

        $trailsRoot = $this->getPluginPath();
        $trailsUri  = rtrim(PluginEngine::getLink($this, [], null, true), '/');

        $dispatcher = new Trails_Dispatcher($trailsRoot, $trailsUri, 'oer');
        $dispatcher->plugin = $this;
        try {
            $dispatcher->dispatch($unconsumedPath);
        } catch (Trails_UnknownAction $exception) {
            if (count($args) > 0) {
                throw $exception;
            } else {
                throw new Exception(sprintf('Unknown action: %s', $unconsumedPath));
            }
        }
    }

    private function setupNavigation()
    {
        if (\Navigation::hasItem('/browse')) {
            $navigation = new Navigation(
                'Zusatzmaterialien',
                PluginEngine::getURL($this, [], '')
            );

            Navigation::addItem('/browse/oer', $navigation);
        }
    }
}
