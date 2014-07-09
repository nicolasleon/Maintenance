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
use Thelia\Form\Exception\FormValidationException;
use Thelia\Model\ConfigQuery;

/**
 * Class MaintenanceAdminController
 * @package Maintenance\Controller
 * @author Nicolas Léon <nicolas@omnitic.com>
 * @author Benjamin Perche <bperche@openstudio.fr>
 */
class MaintenanceAdminController extends BaseAdminController
{

    public function configureAction()
    {
        if (null !== $response = $this->checkAuth([AdminResources::MODULE], ['Maintenance'], AccessManager::UPDATE)) {
            return $response;
        }

        $m_form = new MaintenanceSettingsForm($this->getRequest());

        $error_message = null;

        try {
            $form = $this->validateForm($m_form, "post");
            $data = $form->getData();

            ConfigQuery::write('com.omnitic.maintenance_mode', (bool) $data['maintenance_mode']);
            ConfigQuery::write('com.omnitic.maintenance_template_name', $data['maintenance_template_name']);
            ConfigQuery::write('com.omnitic.maintenance_message', $data['maintenance_message']);
            ConfigQuery::write('com.omnitic.maintenance_allowed_ips', $data['allowed_ips']);

        } catch (FormValidationException $e) {
            $error_message = $this->createStandardFormValidationErrorMessage($e);
        } catch (\Exception $e) {
            $error_message = $e->getMessage();
        }

        if ($error_message !== null) {
            $m_form->setErrorMessage($error_message);

            $this->getParserContext()
                ->addForm($m_form)
                ->setGeneralError($error_message)
            ;
        }

        return $this->render(
            "module-configure",
            [
                'module_code' => 'Maintenance'
            ]
        );
    }

}
