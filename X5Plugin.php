<?php
require_once 'vendor/autoload.php';

use JsonApi\Contracts\JsonApiPlugin;
use X5\RouteMap;

/**
 * X5 Stud.IP plugin.
 */

class X5Plugin extends StudIPPlugin implements
/* Plugin Interfaces */
SystemPlugin,
StandardPlugin,
JsonApiPlugin
{
    use RouteMap;

    public function __construct()
    {
        parent::__construct();

        bindtextdomain('x5', dirname(__FILE__) . '/locale');

        // SimpleORMap::expireTableScheme();

        $this->setupNavigation();

        PageLayout::addScript('https://cdn.jsdelivr.net/npm/vue/dist/vue.js');
        PageLayout::addScript($this->getPluginUrl() . '/dist/main.js');
    }

    /**
     * This method dispatches all actions.
     *
     * @param string   part of the dispatch path that was not consumed
     */
    public function perform($unconsumedPath)
    {
        $args = explode('/', $unconsumedPath);

        $trailsRoot = $this->getPluginPath();
        $trailsUri = rtrim(PluginEngine::getLink($this, [], null, true), '/');

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
     * @return object template object to render or NULL
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function getInfoTemplate($courseId)
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
     * @param string $courseId  course or institute range id
     * @param int    $lastVisit time of user's last visit
     * @param string $userId    the user to get the navigation for
     *
     * @return object navigation item to render or NULL
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function getIconNavigation($courseId, $lastVisit, $userId)
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
     * @param string $courseId course or institute range id
     *
     * @return array navigation item to render or NULL
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function getTabNavigation($courseId)
    {
        // $navigation = new Navigation(
        //     dgettext('x5', 'Zusatzmaterialien'),
        //     $url = PluginEngine::getURL($this, [], 'oer')
        // );
        // $navigation->addSubNavigation('index', new Navigation(dgettext('x5', 'Dozentesnansicht'), $url));
        // $navigation->addSubNavigation('student_view', new Navigation(dgettext('x5', 'Studentenansicht'), $url));
        // return [
        //     'oer' => $navigation,
        // ];
        $navigation = new Navigation('X5GON Material', $url = PluginEngine::getURL($this, [], 'oer'));
        if ($this->currentUserIsDozent()) {
            $navigation->addSubNavigation('dozent_view', new Navigation('Listen bearbeiten', $url));
        }
        $navigation->addSubNavigation('student_view', new Navigation('Studierendenansicht', PluginEngine::getURL($this, [], 'oer/student_view')));

        return array('oer' => $navigation);
    }

    /**
     * Provides metadata like a descriptional text for this module that
     * is shown on the course "+" page to inform users about what the
     * module acutally does. Additionally, a URL can be specified.
     *
     * @return array metadata containg description and/or url
     */
    public function getMetadata()
    {
        return [];
    }

    private function setupNavigation()
    {
        if ($this->currentUserIsDozent()) {
            if (\Navigation::hasItem('/browse')) {
                $navigation = new Navigation(
                    'Zusatzmaterialien',
                    $url = PluginEngine::getURL($this, [], 'browse')
                );

                Navigation::addItem('/browse/oer', $navigation);
                $navigation->addSubNavigation(
                    'index',
                    new Navigation(dgettext('x5', 'Übersicht'), $url)
                );
                $navigation->addSubNavigation(
                    'marcus',
                    new Navigation(dgettext('x5', 'Marcus'), PluginEngine::getURL($this, [], 'browse/foo/' . '17'))
                );
            }
        }
    }

    /**
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    private function currentUserIsDozent()
    {
        return $GLOBALS['perm']->have_perm('dozent');
    }

}
