<?php

/**
 * X5 Stud.IP plugin.
 */
class X5Plugin extends StudIPPlugin implements
    /* Plugin Interfaces */
    StandardPlugin
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

    /**
     * Return a template (an instance of the Flexi_Template class)
     * to be rendered on the course summary page. Return NULL to
     * render nothing for this plugin.
     *
     * The template will automatically get a standard layout, which
     * can be configured via attributes set on the template:
     *
     *  title        title to display, defaults to plugin name
     *  icon_url     icon for this plugin (if any)
     *  admin_url    admin link for this plugin (if any)
     *  admin_title  title for admin link (default: Administration)
     *
     * @return object   template object to render or NULL
     */
    function getInfoTemplate($course_id)
    {
        return null;
    }

    /**
     * Return a navigation object representing this plugin in the
     * course overview table or return NULL if you want to display
     * no icon for this plugin (or course). The navigation object's
     * title will not be shown, only the image (and its associated
     * attributes like 'title') and the URL are actually used.
     *
     * By convention, new or changed plugin content is indicated
     * by a different icon and a corresponding tooltip.
     *
     * @param  string   $course_id   course or institute range id
     * @param  int      $last_visit  time of user's last visit
     * @param  string   $user_id     the user to get the navigation for
     *
     * @return object   navigation item to render or NULL
     */
    function getIconNavigation($course_id, $last_visit, $user_id)
    {
        return null;
    }

    /**
     * Return a navigation object representing this plugin in the
     * course overview table or return NULL if you want to display
     * no icon for this plugin (or course). The navigation object's
     * title will not be shown, only the image (and its associated
     * attributes like 'title') and the URL are actually used.
     *
     * By convention, new or changed plugin content is indicated
     * by a different icon and a corresponding tooltip.
     *
     * @param  string   $course_id   course or institute range id
     *
     * @return array    navigation item to render or NULL
     */
    function getTabNavigation($course_id)
    {
        return [ 'oer' => new Navigation('Zusatzmaterialien',
            PluginEngine::getURL($this, [], '')
        )];
    }


    /**
     * Provides metadata like a descriptional text for this module that
     * is shown on the course "+" page to inform users about what the
     * module acutally does. Additionally, a URL can be specified.
     *
     * @return array    metadata containg description and/or url
     */
    function getMetadata()
    {
        return [];
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
