<?php

class OerController extends \X5\TrailsController
{
    /**
     * @SuppressWarnings(PHPMD.CamelCaseMethodName)
     */
    public function index_action()
    {
        \PageLayout::setHelpKeyword('Basis.X5Course');

        if (\Navigation::hasItem('/course/oer/index')) {
            \Navigation::activateItem('/course/oer/index');
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
}
