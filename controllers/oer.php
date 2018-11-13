<?php

class OerController extends \StudipController
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
        $this->flash = Trails_Flash::instance();
        $this->set_layout(
            $GLOBALS['template_factory']->open(\Request::isXhr() ? 'layouts/dialog' : 'layouts/base')
        );
        $this->setDefaultPageTitle();
    }

    /**
     * @SuppressWarnings(PHPMD.CamelCaseMethodName)
     */
    public function index_action()
    {
        \PageLayout::setHelpKeyword('Basis.X5');

        if (\Navigation::hasItem('/browse/oer')) {
            \Navigation::activateItem('/browse/oer');
        }

        // just render template for now
    }

    /**
     * @SuppressWarnings(PHPMD.CamelCaseMethodName)
     */
    public function foo_action($arg)
    {
        var_dump(__METHOD__, $arg);
        exit;
    }

    /**
     * @SuppressWarnings(PHPMD.CamelCaseMethodName)
     */
    public function bar_action()
    {
        $bar1 = \Request::get('bar1');
        $bar2 = \Request::get('bar2');

        $result = $this->doSomething($bar1, $bar2);

        if (true) {
            $this->flash['message'] = dgettext('x5', 'Erfolg!');
        } else {
            $this->flash['error'] = dgettext('x5', 'Fehler!');
        }

        $this->redirect('oer/index');
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    private function doSomething($arg1, $arg2)
    {
        return true;
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
