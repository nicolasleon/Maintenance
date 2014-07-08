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

use Maintenance\Maintenance;
use Symfony\Component\Validator\Constraints\NotBlank;
use Thelia\Core\Translation\Translator;
use Thelia\Form\BaseForm;

/**
 * Class MaintenanceSettingsForm
 * @package Maintenance\Form
 * @author Nicolas Léon <nicolas@omnitic.com>
 * @author Benjamin Perche <bperche@openstudio.fr>
 */
class MaintenanceSettingsForm extends BaseForm
{
    protected function buildForm()
    {
        $translator = Translator::getInstance();

        $this->formBuilder
            ->add('maintenance_mode', 'checkbox', array(
                    'label' => $translator->trans(
                        "Put the store in maintenance mode",
                        [],
                        Maintenance::MESSAGE_DOMAIN
                    ),
                    'label_attr' => ['for' => 'maintenance_mode' ],
                    'required' => false,
                ))
            ->add('maintenance_template_name', 'text', array(
                    'label' => $translator->trans(
                        "Template name",
                        [],
                        Maintenance::MESSAGE_DOMAIN
                    ),
                    'label_attr' => array(
                        'for' => 'maintenance_template_name'
                    ),
                    'required' => true,
                    'constraints' => array(
                        new NotBlank(),
                    )
                ))
            ->add('maintenance_message', 'text', array(
                    'label' => $translator->trans(
                        "Reminder message",
                        [],
                        Maintenance::MESSAGE_DOMAIN
                    ),
                    'label_attr' => array(
                        'for' => 'maintenance_message'
                    ),
                    "required" => true,
                    "constraints" => array(
                        new NotBlank(),
                    )
                ))
            ->add('allowed_ips', 'text', array(
                    'label' => $translator->trans(
                        "Authorized IP address(es)",
                        [],
                        Maintenance::MESSAGE_DOMAIN
                    ),
                    'label_attr' => array(
                        'for' => 'allowed_ips'
                    ),
                    "required" => false,
                    // "constraints" => array(
                    //     new NotBlank(),
                    // )
                ))
        ;
    }

    public function getName()
    {
        return 'admin_maintenance_settings';
    }
}
