<?php

class BrowseController extends \X5\TrailsController
{
    /**
     * @SuppressWarnings(PHPMD.CamelCaseMethodName)
     */
    public function index_action()
    {
        \PageLayout::setHelpKeyword('Basis.X5Browse');

        if (\Navigation::hasItem('/browse/oer/index')) {
            \Navigation::activateItem('/browse/oer/index');
        }
        // just render template for now
    }

    public function foo_action($foo_id)
    {
        if (\Navigation::hasItem('/browse/oer/marcus')) {
            \Navigation::activateItem('/browse/oer/marcus');
        }
        $this->name = $foo_id;
    }
}
