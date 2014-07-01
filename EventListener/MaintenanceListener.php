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

use Maintenance\Controller\MaintenanceController;
use Maintenance\Maintenance;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

use Thelia\Model\ConfigQuery;

/**
 * Class MaintenanceListener
 * @package Maintenance\EventListener
 * @author Benjamin Perche <bperche@openstudio.fr>
 * @author Nicolas Léon <nicolas@omnitic.com>
 */
class MaintenanceListener implements EventSubscriberInterface
{
    protected $container;

    protected $maintenance_mode;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /*
     * Displays the maintenance page according to Admin settings
     *
     * @params FilterResponseEvent $event
     *
     */
    public function setMaintenanceView(FilterResponseEvent $event)
    {
        if ((new Maintenance())->getModuleModel()->getActivate()) {
            $maintenance_mode = $this->maintenance_mode = ConfigQuery::read('com.omnitic.maintenance_mode');

            if($maintenance_mode) {
                /**
                 * @var \Thelia\Core\HttpFoundation\Request
                 */
                $request = $event->getRequest();

                // Check that we're not an admin user
                if($request->getSession()->getAdminUser() === null) {
                    $path = $request->getPathInfo();

                    // Check that we're not accessing admin pages
                    if (!preg_match("#^(/admin)#i", $path)) {
                        // If not, use the controller to generate the response
                        $controller = new MaintenanceController();
                        $controller->setContainer($this->container);

                        $event->setResponse(
                            $controller->displayMaintenance()
                        );

                        $event->stopPropagation();
                    }
                } else {
                    /**
                     * Only display a notice
                     * WARNING: This must be a temporary solution before the hooks.
                     */
                    $response = $event->getResponse();

                    /**
                     * We only get the actual response, parse it with DOMDocument,
                     * and add the required tag at the beginning
                     */
                    $content = $response->getContent();

                    /**
                     * Parse the actual response
                     */
                    $dom = new \DOMDocument();
                    libxml_use_internal_errors(true);
                    $dom->loadHTML($content);
                    libxml_clear_errors();

                    /**
                     * Get the "body" node
                     */
                    $body = $dom->getElementsByTagName("body");

                    /**
                     * Just check that the response has a body node
                     */
                    if ($body->length > 0) {
                        $real_body = $body->item(0);

                        $maintenance_message = ConfigQuery::read('com.omnitic.maintenance_message');
                        $class_name  = ConfigQuery::read('com.omnitic.maintenance_class_name');
                        $wrapper_tag = ConfigQuery::read('com.omnitic.maintenance_wrapper_tag');

                        /**
                         * Then create a Document element with the variables define
                         * up there.
                         */
                        $element = new \DOMElement($wrapper_tag, $maintenance_message);

                        /**
                         * Insert the element to make it writable
                         */
                        /** @var \DOMElement $inserted_element */
                        $inserted_element = $real_body->insertBefore(
                            $element,
                            $real_body->firstChild
                        );

                        /**
                         * Then add the attribute "class"
                         */
                        $inserted_element->setAttribute("class", $class_name);

                        /**
                         * Generate a string and set the new content into the response
                         */
                        $content = $dom->saveHTML();
                        $response->setContent($content);
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
            KernelEvents::RESPONSE => ["setMaintenanceView", 128]
        );
    }

}
