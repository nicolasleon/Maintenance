<?php

namespace Maintenance\Controller;
use Thelia\Controller\Front\BaseFrontController;
use Thelia\Core\Template\ParserInterface;
use Thelia\Core\Template\TemplateDefinition;
use Thelia\Model\ConfigQuery;

/**
 * Class MaintenanceController
 * @package Maintenance\Controller
 * @author Benjamin Perche <bperche@openstudio.fr>
 */
class MaintenanceController extends BaseFrontController
{
    public function displayMaintenance()
    {
        return $this->render(
            ConfigQuery::read("com.omnitic.maintenance_template_name")
        );
    }

    /**
     * @return ParserInterface instance parser
     */
    protected function getParser($template = null)
    {
        $parser = $this->container->get("thelia.parser");

        // Define the template that should be used
        $parser->setTemplateDefinition(
            new TemplateDefinition(
                'module_maintenance',
                TemplateDefinition::FRONT_OFFICE
            )
        );

        return $parser;
    }
} 