<?php

/**
 * Site
 *
 * @author  Maxence CAUDERLIER
 * @link    https://github.com/ZestCMS/ZestCMS
 * @license http://opensource.org/licenses/MIT The MIT License
 */

namespace Zest\Responses;

use Zest\Utils\URLBuilder as URLBuilder;

/**
 * Container to inject templates
 * When Response is returned on Zest class, output() is called
 */
class Admin extends Site
{

    /**
     * Display the response
     * 
     * @return string Content of all tpl added
     */
    public function output()
    {
        $layout  = new \Zest\Templates\Template('admin' . DS . 'layout.tpl');
        $layout->set('page_title', $this->title);
        $layout  = $this->fillFlashMessages($layout);
        $content = '';
        foreach ($this->tpl as $tpl) {
            $content .= $tpl->output();
        }

        $menu = $this->buildMenus();

        $layout->set('SIDEBAR_ADMIN_MENU', $menu->output());
        $layout->set('content', $content);
        return $layout->output();
    }

    /**
     *
     * @return \Zest\Menus\Menu Admin Menu
     */
    private function buildMenus()
    {
        $menu = new \Zest\Menus\Menu('sidebar-admin-menu', 'menu');
        $menu = $this->buildCoreItems($menu);
        $menu = \Zest\Core\HookManager::execute_filter('edit_admin_menu', $menu);
        return $menu;
    }

    private function buildCoreItems(\Zest\Menus\Menu $menu)
    {
        $menu->addItem('Close Sidebar', [
            'url' => 'javascript:void(0)',
            'id'  => 'close-sidebar'], 1);
        $menu->addItem('Go to Site', [
            'url' => ROOT_URL], 5);
        $articles = $menu->addItem('Articles', [
            'url' => URLBuilder::getURLAdminArticlesList(),
            'id'  => 'articles']);
        $articles->addItem('Articles List', [
            'url' => URLBuilder::getURLAdminArticlesList()]);
        $articles->addItem('New Article', [
            'url' => URLBuilder::getURLAdminArticleWrite()]);
        $plugins  = $menu->addItem('Plugins', [
            'id'  => 'plugins',
            'url' => URLBuilder::getURLAdminPluginsManagement()]);
        $config   = $menu->addItem('Config', [
            'id'  => 'config',
            'url' => URLBuilder::getURLAdminConfiguration()]);
        return $menu;
    }

}
