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

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
// use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

use Thelia\Core\Template\ParserInterface;
use Thelia\Core\Template\TemplateHelper;
use Thelia\Model\ConfigQuery;

/**
 * Class SendEMail
 * @package IciRelais\Listener
 * @author Thelia <info@thelia.net>
 */
class MaintenanceListener implements EventSubscriberInterface
{
    /**
     * @var ParserInterface
     */
    protected $parser;

    protected $maintenance_mode;

    public function __construct(ParserInterface $parser)
    {
        $this->parser = $parser;
    }

    /*
     * Displays the maintenance page according to Admin settings
     *
     * @params FilterResponseEvent $event
     *
     */
    public function setMaintenanceView(FilterResponseEvent $event)
    {
        $maintenance_mode = $this->maintenance_mode = ConfigQuery::read('com.omnitic.maintenance_mode');

        if($maintenance_mode) {
            $request = $event->getRequest();

            // Check that we're not an admin user
            if($request->getSession()->getAdminUser() === null) {
                $path = $request->getPathInfo();

                // Check that we're not accessing admin pages
                if (!preg_match("#^(/admin)#i", $path)) {
                    // Define the template that will be use to render the store front maintenance page
                    $this->parser->setTemplateDefinition(TemplateHelper::getInstance()->getActiveFrontTemplate());
                    $maintenance_template_name = ConfigQuery::read('com.omnitic.maintenance_template_name');

                    $content = $this->parser->render($maintenance_template_name . ".html");

                    if ($content instanceof Response) {
                        $response = $content;
                    } else {
                        $response = new Response($content, $this->parser->getStatus() ?: 200);
                    }
                    $event->setResponse($response);

                }
            }

        }
    }

    /**
     * Displays a maintenance mode reminder for logged in store admins
     *
     * @params FilterResponseEvent $event
     *
     */
    public function displayMaintenanceReminder(FilterResponseEvent $event)
    {
        if($this->maintenance_mode) {
            $response = $event->getResponse();
            $request = $event->getRequest();


            $maintenance_message = ConfigQuery::read('com.omnitic.maintenance_message');
            $class_name = ConfigQuery::read('com.omnitic.maintenance_class_name');
            $wrapper_tag = ConfigQuery::read('com.omnitic.maintenance_wrapper_tag');
            $message = <<<MM
            <$wrapper_tag class="{$class_name}">
                $maintenance_message
            </$wrapper_tag>
MM;
            // Check that we're an admin and not viewing the store backend
            $path = $request->getPathInfo();
            if ($request->getSession()->getAdminUser() && !preg_match("#^(/admin)#i", $path)) {
                $content = preg_replace('/(<body[^>]*>)/i', '$1' . $message, $response->getContent());
                $response = new Response($content, $this->parser->getStatus() ?: 200);
                $event->setResponse($response);
            }
        }
    }


    /**
     * Returns an array of event names this subscriber wants to listen to.
     */
    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::RESPONSE => [
                ["setMaintenanceView", 128],
                ["displayMaintenanceReminder", 128]
            ]
        );
    }

}
