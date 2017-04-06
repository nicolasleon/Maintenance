<?php

namespace Maintenance\Controller;
use Thelia\Controller\Front\BaseFrontController;
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
        $tplName = ConfigQuery::read("com.omnitic.maintenance_template_name");

        if (empty($tplName)) {
            $tplName = "maintenance";
        }

        return $this->render("maintenance/$tplName");
    }
}
