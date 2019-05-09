<?php
/*************************************************************************************/
/*      This file is part of the Maintenance module.                                 */
/*                                                                                   */
/*      Copyright (c) Omnitic                                                        */
/*      email : bonjour@omnitic.com                                                  */
/*      web : http://www.omnitic.com                                                 */
/*                                                                                   */
/*      This program is free software; you can redistribute it and/or modify         */
/*      it under the terms of the GNU General Public License as published by         */
/*      the Free Software Foundation; either version 3 of the License                */
/*                                                                                   */
/*      This program is distributed in the hope that it will be useful,              */
/*      but WITHOUT ANY WARRANTY; without even the implied warranty of               */
/*      MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the                */
/*      GNU General Public License for more details.                                 */
/*                                                                                   */
/*      You should have received a copy of the GNU General Public License            */
/*      along with this program. If not, see <http://www.gnu.org/licenses/>.         */
/*                                                                                   */
/*************************************************************************************/

namespace Maintenance\EventListener;

use BackOfficePath\BackOfficePath;
use Maintenance\Controller\MaintenanceController;
use Maintenance\Maintenance;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

use Thelia\Core\HttpKernel\Exception\RedirectException;
use Thelia\Model\ConfigQuery;
use Thelia\Model\ModuleQuery;
use Thelia\Tools\URL;

/**
 * Class MaintenanceListener
 * @package Maintenance\EventListener
 * @author Benjamin Perche <bperche@openstudio.fr>
 * @author Nicolas Léon <nicolas@omnitic.com>
 */
class MaintenanceListener implements EventSubscriberInterface
{
    protected $debugMode;

    /**
     * MaintenanceListener constructor.
     *
     * @param $debugMode
     */
    public function __construct($debugMode)
    {
        $this->debugMode = $debugMode;
    }

    /*
     * Displays the maintenance page according to Admin settings
     *
     * @params FilterResponseEvent $event
     *
     */
    public function setMaintenanceView(GetResponseEvent $event)
    {
        $maintenance_mode = ConfigQuery::read('com.omnitic.maintenance_mode');

        if ($maintenance_mode) {
            /**
             * @var \Thelia\Core\HttpFoundation\Request
             */
            $request = $event->getRequest();

            // Check that the current request ip address is in the white list
            $allowed_ips = explode(',', ConfigQuery::read('com.omnitic.maintenance_allowed_ips'));
            $allowed_ips[] = '127.0.0.1';
            $current_ip = $request->server->get('REMOTE_ADDR');
            $path = $request->getPathInfo();

            if ($path !== '/maintenance') {
                // Check that we're not in debug mode
                if (! $this->debugMode) {
                    // Check that we're not an allowed ip address
                    if (!in_array($current_ip, $allowed_ips)) {
                        // Check that we're not an admin user
                        if ($request->getSession()->getAdminUser() === null) {
                            // Check that we're not accessing admin pages
                            if (!preg_match("#^/admin#i", $path)) {
                                throw new RedirectException(URL::getInstance()->absoluteUrl("/maintenance"));
                            }
                        }
                    }
                }
            }
        }
    }

    /**
     * Returns an array of event names this subscriber wants to listen to.
     */
    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::REQUEST => ["setMaintenanceView", 128]
        );
    }

}
