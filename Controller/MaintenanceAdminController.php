<?php
/*************************************************************************************/
/*      Maintenance mode plugin for Thelia 2                                         */
/*                                                                                   */
/*      Copyright (c) Omnitic                                                        */
/*      email : nicolas@omnitic.com                                                  */
/*      web : http://www.omnitic.com                                                 */
/*                                                                                   */
/*************************************************************************************/

namespace Maintenance\Controller;

use Maintenance\Form\MaintenanceSettingsForm;
use Thelia\Controller\Admin\BaseAdminController;
use Thelia\Core\Security\AccessManager;
use Thelia\Core\Security\Resource\AdminResources;
use Thelia\Model\ConfigQuery;


/**
 * Class MaintenanceAdminController
 * @package Maintenance\Controller
 * @author Nicolas Léon <nicolas@omnitic.com>
 */
class MaintenanceAdminController extends BaseAdminController
{

    public function configureAction()
    {
        if (null !== $response = $this->checkAuth([AdminResources::MODULE], ['Maintenance'], AccessManager::UPDATE)) {
            return $response;
        }

        $request = $this->getRequest();

        $m_form = new MaintenanceSettingsForm($request);

        $form = $this->validateForm($m_form);
        $data = $form->getData();

        $maintenance_mode = ConfigQuery::create()->findOneByName('com.omnitic.maintenance_mode');
        $maintenance_mode->setValue($data['maintenance_mode'] ? 1 : 0);
        $maintenance_mode->save();

        $maintenance_mode = ConfigQuery::create()->findOneByName('com.omnitic.maintenance_template_name');
        $maintenance_mode->setValue($data['maintenance_template_name']);
        $maintenance_mode->save();

        $maintenance_mode = ConfigQuery::create()->findOneByName('com.omnitic.maintenance_message');
        $maintenance_mode->setValue($data['maintenance_message']);
        $maintenance_mode->save();

        $this->redirectToRoute("admin.module.configure", [], ['module_code' => 'Maintenance']);
    }

}