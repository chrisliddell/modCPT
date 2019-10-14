<?php


namespace Imagineer\CustomAddress\Block\Customer\Widget;

use Magento\Framework\View\Element\Template;

class Custom extends Template{
    /**
     * @var AddressMetadataInterface
     */
    private $addressMetadata;

    protected  function __construct(
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
            $attribute = $this->addressMetadata->getAttributeMetadata('custom');
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
        return 'custom';
    }

    public function getFieldLabel(){
        return $this->getAttribute()
        ? $this->getAttribute()->getFrontendLabel()
        :__('Custom');
    }

    public function getFieldName(){
        return 'custom';
    }

    /**
     * @return strin\null
     */
    public function getValue(){
        /**@var AddressInterface $address */
        $address = $this->getAddress();
        if($address instanceof AddressInterface()){
            return $address->getCustomAttribute('custom')
            ? $Address->getCustomAttribute('custom')->getValue()
            : null;
        }
        return null;
    }
}