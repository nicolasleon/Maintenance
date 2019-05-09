<?php
/*************************************************************************************/
/*      This file is part of the Thelia package.                                     */
/*                                                                                   */
/*      Copyright (c) OpenStudio                                                     */
/*      email : dev@thelia.net                                                       */
/*      web : http://www.thelia.net                                                  */
/*                                                                                   */
/*      For the full copyright and license information, please view the LICENSE.txt  */
/*      file that was distributed with this source code.                             */
/*************************************************************************************/

namespace Maintenance\Hook;

use Maintenance\Maintenance;
use Thelia\Core\Event\Hook\HookRenderBlockEvent;
use Thelia\Core\Event\Hook\HookRenderEvent;
use Thelia\Core\Hook\BaseHook;
use Thelia\Model\ConfigQuery;
use Thelia\Tools\URL;

/**
 * Class HookManager
 *
 * @package Tinymce\Hook
 * @author Franck Allimant <franck@cqfdev.fr>
 */
class HookManager extends BaseHook
{
    public function onMainBodyTop(HookRenderEvent $event)
    {
        if (ConfigQuery::read('com.omnitic.maintenance_mode')) {
            $event->add($this->render("maintenance/maintenance_warning.html"));
        }
    }

    public function onMainTopMenuTools(HookRenderBlockEvent $event)
    {
        $event->add(
            [
                'id' => 'tools_menu_tags',
                'class' => '',
                'url' => URL::getInstance()->absoluteUrl('/admin/module/Maintenance'),
                'title' => $this->translator->trans("Mode maintenance", [], Maintenance::MESSAGE_DOMAIN)
            ]
        );
    }

    public function onModuleConfigure(HookRenderEvent $event)
    {
        $event->add($this->render("maintenance/module_configuration.html"));
    }
}
