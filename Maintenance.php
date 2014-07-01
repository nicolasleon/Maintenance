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


    private static $settings = [
        'com.omnitic.maintenance_mode' => 1,
        'com.omnitic.maintenance_template_name' => 'maintenance',
        'com.omnitic.maintenance_message' => 'Nous mettons à jour notre boutique. Revenez nous voir dans quelques minutes.',
        'com.omnitic.maintenance_class_name' => 'maintenance-reminder',
        'com.omnitic.maintenance_wrapper_tag' => 'div',
    ];


    /*
    * Install the default module settings
    *
    */
    public function postActivation(ConnectionInterface $con = null)
    {

        foreach(self::$settings as $setting_name => $value) {
            if(ConfigQuery::read($setting_name) == '') {
                ConfigQuery::write($setting_name, $value, null, 1);
            }
        }

    }


    /*
     * Delete module data on module destroy
     *
     *
     */
    public function destroy(ConnectionInterface $con = null, $deleteModuleData = false) {
        foreach(self::$settings as $setting_name => $value) {
            $setting = ConfigQuery::create()->filterByName($setting_name)->findOne();
            if($setting ) {
                $setting->delete();
            }
        }

    }

    public function getCode()
    {
        return 'Maintenance';
    }

}
