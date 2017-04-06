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
                    'label_attr' => [
                        'for' => 'maintenance_mode',
                        'help' => $this->translator->trans(
                            'Lorsque cette case est cochée, votre boutique n\'est plus accessible à vos clients.',
                            [],
                            Maintenance::MESSAGE_DOMAIN
                        )
                    ],
                    'required' => false,
                ))
            ->add('maintenance_template_name', 'text', array(
                    'label' => $translator->trans(
                        "Template name",
                        [],
                        Maintenance::MESSAGE_DOMAIN
                    ),
                    'label_attr' => array(
                        'for' => 'maintenance_template_name',
                        'help' => $this->translator->trans(
                            'This is the name of the HTML template displayed to your customers. The module provides the following templates : "maintenance", "light" and "simple", but feel free to make your own template, and put its name here.',
                            [],
                            Maintenance::MESSAGE_DOMAIN
                        )
                    ),
                    'required' => true,
                    'constraints' => array(
                        new NotBlank(),
                    )
                ))
            ->add('maintenance_message', 'textarea', array(
                    'label' => $translator->trans(
                        "Reminder message",
                        [],
                        Maintenance::MESSAGE_DOMAIN
                    ),
                    'label_attr' => array(
                        'for' => 'maintenance_message',
                        'help' => $this->translator->trans(
                            'This message will be displayed to your customers.',
                            [],
                            Maintenance::MESSAGE_DOMAIN
                        )
                    ),
                    "required" => true,
                    "constraints" => array(
                        new NotBlank(),
                    )
                ))
            ->add('maintenance_allowed_ips', 'text', array(
                    'label' => $translator->trans(
                        "Authorized IP address(es)",
                        [],
                        Maintenance::MESSAGE_DOMAIN
                    ),
                    'label_attr' => array(
                        'for' => 'allowed_ips',
                        'help' => $this->translator->trans(
                            'Enter here a comma separated list of the IP addresses that will be allowed to access the shop when maintenance mode is enabled. Your IP address is currently %ip.',
                            [ "%ip" => $this->getRequest()->getClientIp()],
                            Maintenance::MESSAGE_DOMAIN
                        )
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
