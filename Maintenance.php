<?php
/*************************************************************************************/
/*      Maintenance mode plugin for Thelia 2                                       */
/*                                                                                   */
/*      Copyright (c) Omnitic                                                        */
/*      email : nicolas@omnitic.com                                                  */
/*      web : http://www.omnitic.com                                                 */
/*                                                                                   */
/*************************************************************************************/

namespace Maintenance;

use Propel\Runtime\Connection\ConnectionInterface;
use Thelia\Model\ConfigQuery;
use Thelia\Module\BaseModule;

class Maintenance extends BaseModule
{
    const MESSAGE_DOMAIN = "maintenance";

    private $settings = [
        'com.omnitic.maintenance_mode' => 0,
        'com.omnitic.maintenance_template_name' => 'maintenance',
        'com.omnitic.maintenance_message' => 'Nous mettons à jour notre boutique. Revenez nous voir dans quelques minutes.',
        'com.omnitic.maintenance_allowed_ips' => '',
    ];

    /*
    * Install the default module settings
    *
    */
    public function postActivation(ConnectionInterface $con = null)
    {
        foreach ($this->settings as $setting_name => $value) {
            $setting = ConfigQuery::read($setting_name);

            if (empty($setting)) {
                ConfigQuery::write($setting_name, $value, null, 1);
            }
        }

    }

    /*
     * Delete module data on module destroy
     *
     *
     */
    public function destroy(ConnectionInterface $con = null, $deleteModuleData = false)
    {
        foreach ($this->settings as $setting_name => $value) {
            $setting = ConfigQuery::create()->findOneByName($setting_name);
            if ($setting !== null) {
                $setting->delete();
            }
        }

    }

    public function getCode()
    {
        return 'Maintenance';
    }

}
