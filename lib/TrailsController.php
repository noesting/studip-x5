<?php

namespace X5;

abstract class TrailsController extends \StudipController
{
    public function __construct($dispatcher)
    {
        parent::__construct($dispatcher);
        $this->plugin = $dispatcher->plugin;
    }

    /**
     * @SuppressWarnings(PHPMD.CamelCaseMethodName)
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    public function before_filter(&$action, &$args)
    {
        parent::before_filter($action, $args);
        $this->flash = \Trails_Flash::instance();
        $this->set_layout(
            $GLOBALS['template_factory']->open(\Request::isXhr() ? 'layouts/dialog' : 'layouts/base')
        );
        $this->setDefaultPageTitle();
    }

    /**
     * @SuppressWarnings(PHPMD.CamelCaseMethodName)
     */
    public function url_for($toAction = '')
    {
        $args = func_get_args();

        // find params
        $params = [];
        if (is_array(end($args))) {
            $params = array_pop($args);
        }

        // urlencode all but the first argument
        $args = array_map('urlencode', $args);
        $args[0] = $toAction;

        return \PluginEngine::getURL($this->dispatcher->plugin, $params, implode('/', $args));
    }

    protected function setDefaultPageTitle()
    {
        \PageLayout::setTitle(dgettext('x5', 'Zusatzmaterialien'));
    }
}
