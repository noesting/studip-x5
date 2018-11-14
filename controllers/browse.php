<?php

class BrowseController extends \X5\TrailsController
{
    /**
     * @SuppressWarnings(PHPMD.CamelCaseMethodName)
     */
    public function index_action()
    {
        \PageLayout::setHelpKeyword('Basis.X5Browse');

        if (\Navigation::hasItem('/browse/oer')) {
            \Navigation::activateItem('/browse/oer');
        }
        // just render template for now
    }
}
