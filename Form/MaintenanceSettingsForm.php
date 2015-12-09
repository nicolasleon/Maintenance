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

use Thelia\Model\ConfigQuery;

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

        $selected_template = ConfigQuery::read('com.omnitic.maintenance_template_name');
        $allowed_ips = ConfigQuery::read('com.omnitic.maintenance_allowed_ips');
        $image = ConfigQuery::read('com.omnitic.maintenance_image');
        $image_alt = ConfigQuery::read('com.omnitic.maintenance_image_alt');

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
            ->add('maintenance_image', 'text', array(
                    'label' => $translator->trans(
                        "Image filename",
                        [],
                        Maintenance::MESSAGE_DOMAIN
                    ),
                    'label_attr' => array(
                        'for' => 'maintenance_image',
                        'help' => $translator->trans(
                            "Image path from the active template folder. Ex: assets/img/my-image.jpg",
                            [],
                            Maintenance::MESSAGE_DOMAIN
                        )
                    ),
                    'data' => $image,
                    "required" => false,
                ))
            ->add('maintenance_image_alt', 'text', array(
                    'label' => $translator->trans(
                        "Image alternative text attribute",
                        [],
                        Maintenance::MESSAGE_DOMAIN
                    ),
                    'label_attr' => array(
                        'for' => 'maintenance_image',
                        'help' => $translator->trans(
                            "Alt text when image is not visible",
                            [],
                            Maintenance::MESSAGE_DOMAIN
                        )
                    ),
                    'data' => $image_alt,
                    "required" => false,
                ))
            ->add('maintenance_template_name', 'choice', array(
                    'label' => $translator->trans(
                        "Template name",
                        [],
                        Maintenance::MESSAGE_DOMAIN
                    ),
                    'choices' => ['light' => 'Light', 'maintenance' => 'Maintenance', 'simple' => 'Simple'],
                    'data' => $selected_template,
                    'label_attr' => array(
                        'for' => 'maintenance_template_name',
                        // 'help' => 'maintenance, simple, light'
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
            ->add('maintenance_allowed_ips', 'text', array(
                    'label' => $translator->trans(
                        "Authorized IP address(es)",
                        [],
                        Maintenance::MESSAGE_DOMAIN
                    ),
                    'data' => $allowed_ips,
                    'label_attr' => array(
                        'for' => 'allowed_ips',
                        'help' => $translator->trans(
                            "Can be a comma separated list. Ex: 192.168.2.5, 215.2.5.9",
                            [],
                            Maintenance::MESSAGE_DOMAIN
                        )
                    ),
                    'required' => false,
                    // 'placeholder' => '192.168.1.253'
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
