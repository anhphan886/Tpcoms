<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VMWareController extends Controller
{
    //
    public function create()
    {

        $service = \VMware_VCloud_SDK_Service::getService();
        $array["username"] = "testapi@system";
        $array["password"] = "abcd123!@#";
        $orgName = 'wao';
        $host = "poc.tpcloud.vn";
        $httpConfig = array('proxy_host' => null, 'proxy_port' => null, 'proxy_user' => null, 'proxy_password' => null, 'ssl_verify_peer' => false, 'ssl_verify_host' => false, 'ssl_cafile'  => null);
        $result = $service->login($host, $array, $httpConfig, '32.0');
        $vdcName = 'WAO_VDC';
        $orgVdcNetName = 'WAO_ORG';
        $vAppName = 'vApp_system_test';
        $catName = 'abc';
        $vmName =  'myexample_vms';
        $moref = '';
        // creates an SDK Extension object
        $description = "description";
        $sdkExt = $service->createSDKExtensionObj();
        // create an SDK Vim Server object
        $vimRefs = $sdkExt->getVimServerRefs();
        if (0 == count($vimRefs)) {
            exit("No vim server with name  is found\n");
        }
        $vimRef = $vimRefs[0];
        $sdkVimServer = $service->createSDKObj($vimRef);
        // get reference of the vDC where to import
        $orgRefs = $service->getOrgRefs($orgName);
        if (0 == count($orgRefs)) {
            exit("No organization with name $orgName is found\n");
        }
        $orgRef = $orgRefs[0];
        $sdkOrg = $service->createSDKObj($orgRef);
        $vdcRefs = $sdkOrg->getVdcRefs($vdcName);
        if (0 == count($vdcRefs)) {
            exit("No vDC with name $vdcName is found\n");
        }
        $vdcRef = $vdcRefs[0];
        $vdcRef = \VMware_VCloud_SDK_Helper::createReferenceTypeObj($vdcRef->get_href());
        $catRefs = $sdkOrg->getCatalogRefs($catName);
        if (0 == count($catRefs)) {
            exit("No catalog with name $catName is found\n");
        }
        $catRef = $catRefs[0];
        $catRef = \VMware_VCloud_SDK_Helper::createReferenceTypeObj(
            $catRef->get_href()
        );
        $params = new \VMware_VCloud_API_Extension_ImportVmAsVAppTemplateParamsType();
        $params->set_name($vAppName);
        $params->setDescription($description);
        $params->setVmName($vmName);
        $params->setVmMoRef($moref);
        $params->setVdc($vdcRef);
        $params->setCatalog($catRef);
        echo "Importing a VM from vSphere to a vDC as a vApp template...\n";
        $sdkVimServer->importVmAsVAppTemplate($params);
        echo "Successfully imported a VM from vSphere to a vDC as a vApp template.\n";
        // ops
        // switch ('template')
        // {
        //     case 'vapp':
        //         $params = new \VMware_VCloud_API_Extension_ImportVmAsVAppParamsType();
        //         $params->set_name($vAppName);
        //         $params->setDescription($description);
        //         $params->setVmName($vmName);
        //         $params->setVmMoRef($moref);
        //         $params->setVdc($vdcRef);
        //         echo "Importing a VM from vSphere to a vDC as a vApp...\n";
        //         $sdkVimServer->importVmAsVApp($params);
        //         echo "Successfully imported a VM from vSphere to a vDC as a vApp.\n";
        //         break;
        //     case 'template':
        //         // get catalog reference
        //         $catRefs = $sdkOrg->getCatalogRefs($catName);
        //         if (0 == count($catRefs))
        //         {
        //             exit("No catalog with name $catName is found\n");
        //         }
        //         $catRef = $catRefs[0];
        //         $catRef = \VMware_VCloud_SDK_Helper::createReferenceTypeObj(
        //                                                           $catRef->get_href());
        //         $params = new \VMware_VCloud_API_Extension_ImportVmAsVAppTemplateParamsType();
        //         $params->set_name($vAppName);
        //         $params->setDescription($description);
        //         $params->setVmName($vmName);
        //         $params->setVmMoRef($moref);
        //         $params->setVdc($vdcRef);
        //         $params->setCatalog($catRef);
        //         echo "Importing a VM from vSphere to a vDC as a vApp template...\n";
        //         $sdkVimServer->importVmAsVAppTemplate($params);
        //         echo "Successfully imported a VM from vSphere to a vDC as a vApp template.\n";
        //         break;
        // }
    }
    public function createOrg(Request $request)
    {
        try {
            $orgName = $request->input('org_name');
            $fullName = $request->input('full_name');
            $description = $request->input('description');

            $canPublishCatalogs = true;
            $ldapMode = 'NONE';



            $service = \VMware_VCloud_SDK_Service::getService();
            $auth["username"] = "testapi@system";
            $auth["password"] = "abcd123!@#";
            $host = "poc.tpcloud.vn";
            $httpConfig = array('proxy_host' => null, 'proxy_port' => null, 'proxy_user' => null, 'proxy_password' => null, 'ssl_verify_peer' => false, 'ssl_verify_host' => false, 'ssl_cafile'  => null);
            $result = $service->login($host, $auth, $httpConfig, '32.0');
            $orgRefs = $service->getOrgRefs();
            $sdkAdmin = $service->createSDKAdminObj();

            // create an AdminOrgType data object
            $gSettings = new \VMware_VCloud_API_OrgGeneralSettingsType();
            $gSettings->setCanPublishCatalogs($canPublishCatalogs);
            $lSettings = new \VMware_VCloud_API_OrgLdapSettingsType();
            $lSettings->setOrgLdapMode($ldapMode);
            $settings = new \VMware_VCloud_API_OrgSettingsType();
            $settings->setOrgGeneralSettings($gSettings);
            $settings->setOrgLdapSettings($lSettings);
            $adminOrgObj = new \VMware_VCloud_API_AdminOrgType();
            $adminOrgObj->set_name($orgName); // name is required
            $adminOrgObj->setFullName($fullName);  // FillName is required
            $adminOrgObj->setDescription($description); // Description is optioanl
            $adminOrgObj->setSettings($settings); // Settings is required
            $adminOrgObj->setIsEnabled(true);
            //echo $adminOrgObj->export() . "\n";
            // create an administrative organization in vCloud Director.
            $sdkAdmin->createOrganization($adminOrgObj);
            return response([
                'error' => 0
            ]);
        } catch (\Exception $e) {
            return response([
                'error' => 1
            ]);
        }
    }
}
