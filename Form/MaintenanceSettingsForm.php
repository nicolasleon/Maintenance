<?php
/*************************************************************************************/
/*      Maintenance mode plugin for Thelia 2                                         */
/*                                                                                   */
/*      Copyright (c) Omnitic                                                        */
/*      email : nicolas@omnitic.com                                                  */
/*      web : http://www.omnitic.com                                                 */
/*                                                                                   */
/*************************************************************************************/
namespace Maintenance\Form;

use Thelia\Form\BaseForm;


class MaintenanceSettingsForm extends BaseForm
{
    protected function buildForm()
    {
        $this->formBuilder
            ->add('maintenance_mode', 'checkbox', array(
                    'label_attr' => array(
                        'for' => 'maintenance_mode'
                    )
                ))
            ->add('maintenance_template_name', 'text', array(
                    'label_attr' => array(
                        'for' => 'maintenance_template_name'
                    )
                ))
            ->add('maintenance_message', 'text', array(
                    'label_attr' => array(
                        'for' => 'maintenance_message'
                    )
                ))
        ;
    }

    public function getName()
    {
        return 'admin_maintenance_settings';
    }
}
