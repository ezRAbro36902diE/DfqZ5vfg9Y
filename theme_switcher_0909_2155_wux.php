<?php
// 代码生成时间: 2025-09-09 21:55:48
class ThemeSwitcherController extends Phalcon\Mvc\Controller {

    /**
     * @var Di
     */
    protected $di;

    /**
     * Constructor
     *
     * Initialize the DI container and set the theme.
     */
    public function __construct() {
        $this->di = Phalcon\Di::getDefault();
    }

    /**
     * Set Theme Action
     *
     * Allows user to switch between themes.
     *
     * @param string $themeName
     *
     * @return bool
     */
    public function setAction($themeName) {
        // Validate theme name
        if (!$this->isValidTheme($themeName)) {
            // Log error and return false
            error_log("Invalid theme name: {$themeName}");
            return false;
        }

        // Set the theme in the session
        $this->di['session']->set('theme', $themeName);

        // Set the theme in the view
        $this->di['view']->setTheme($themeName);

        // Return true to indicate success
        return true;
    }

    /**
     * Check if the theme is valid
     *
     * @param string $themeName
     *
     * @return bool
     */
    protected function isValidTheme($themeName) {
        // Define valid themes
        $validThemes = ['default', 'dark', 'light'];

        // Check if the theme is in the list of valid themes
        return in_array($themeName, $validThemes);
    }
}
