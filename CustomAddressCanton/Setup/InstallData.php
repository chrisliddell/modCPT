<?php

namespace Imagineer\CustomAddressCanton\Setup;

use Magento\Customer\Api\AddressMetadataInterface;
use Magento\Eav\Setup\EavSetup;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Eav\Model\Config;

class InstallData implements InstallDataInterface{

    const CUSTOM_ATTRIBUTE_CODE = 'canton';
    /**
     *  @var EavSetup
     */
    private $eavSetup;
    /**
     *  @var Config
     */
    private $eavConfig;

    public function __construct(EavSetup $eavSetup, Config $config){
        $this->eavSetup = $eavSetup;
        $this->eavConfig = $config;
    }

    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context){
        $setup->startSetup();

        $this->eavSetup->addAttribute(
            AddressMetadataInterface::ENTITY_TYPE_ADDRESS,
            self::CUSTOM_ATTRIBUTE_CODE,
            [
                'label' => 'Cantón',
                'input' => 'text',
                'visible' => true,
                'required' => true,
                'position' => 151,
                'sort_order' => 151,
                'system' => false
            ]
        );

        $customAttribute = $this->eavConfig->getAttribute(
            AddressMetadataInterface::ENTITY_TYPE_ADDRESS,
            self::CUSTOM_ATTRIBUTE_CODE
        );

        $customAttribute->setData(
            'used_in_forms',
            ['adminhtml_customer_address', 'customer_address_edit', 'customer_register_address']
        );

        $customAttribute->save();

        $setup->endSetup();
    }

}