<?php


namespace Imagineer\CustomAddressProvincia\Block\Customer\Widget;

use Magento\Customer\Api\AddressMetadataInterface;
use Magento\Customer\Api\Data\AddressInterface;
use Magento\Framework\View\Element\Template;

class Custom extends Template{
    /**
     * @var AddressMetadataInterface
     */
    private $addressMetadata;

    public function __construct(
        Template\Context $context,
        AddressMetadataInterface $addressMetadataInterface,
        array $data = []
    ){
        parent::__construct($context, $data);
        $this->addresMetadataInterface = $addressMetadataInterface;
    }

    protected  function _construct(){
        parent::_construct();
        $this->setTemplate('widget/custom.phtml');
    }

    private function getAttribute(){
        try{
            $attribute = $this->addressMetadata->getAttributeMetadata('provincia');
        } catch(NoSuchEntityException $exception){
            return null;
        }
        return $attribute[0];
    }

    public function isRequired(){
        return $this->getAttribute()
        ? $this->getAttribute()->isRequired()
        : false;
    }

    public function getFieldId(){
        return 'provincia';
    }

    public function getFieldLabel(){
        return $this->getAttribute()
        ? $this->getAttribute()->getFrontendLabel()
        :__('Provincia');
    }

    public function getFieldName(){
        return 'provincia';
    }

    /**
     * @return string\null
     */
    public function getValue(){
        /**@var AddressInterface $address */
        $address = $this->getAddress();
        if($address instanceof AddressInterface){
            return $address->getCustomAttribute('provincia')
            ? $Address->getCustomAttribute('provincia')->getValue()
            : null;
        }
        return null;
    }
}