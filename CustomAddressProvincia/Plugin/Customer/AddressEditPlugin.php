<?php

namespace Imagineer\CustomAddressProvincia\Plugin\Customer;

use Magento\Framework\View\LayoutInterface;

class AddressEditPlugin{

    /**
     * @var LayoutInterface
     */
    private $layout;

    /**
     * @param LayoutInterface $layout
     */
    public function _construct(LayoutInterface $layout){
        $this->layout = $layout;
    }


    /**
     * @param \Magento\Customer\Block\Address\Edit $edit
     * @param string $result
     * @return string
     */
    public function afterGetNameBlockHtml(
        \Magento\Customer\Block\Address\Edit $edit,
        $result
    ) {
        $customBlock =$this->createBlock(
            'Imagineer\CustomAddressProvincia\Block\Customer\Address\Form\Edit\Custom',
            'imagineer_custom_address_provincia'
        );
        return $result . $customBlock->toHtml();
        
    }
}