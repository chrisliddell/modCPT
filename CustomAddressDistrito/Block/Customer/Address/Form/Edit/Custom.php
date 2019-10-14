<?php

namespace Imagineer\CustomAddressDistrito\Block\Customer\Address\Form\Edit;

use Magento\Customer\Api\AddressRepositoryInterface;
use Magento\Customer\Api\Data\AddressInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\Template;
use Magento\Customer\Api\Data\AddressInterfaceFactory;
use Magento\Customer\Model\Session;

class Custom extends Template{

    /**
     * @var AddressInterface
     */
    private $address;
    
    /**
     * @var AddressInterfaceFactory
     */
    private $addressInterfaceFactory;

    /**
     * @var AddressRepositoryInterface
     */
    private $addressRepository;

    /**
     * @var Session
     */
    private $customerSession;

    public function __construct(
        Template\Context $context,
        AddressRepositoryInterface $addressRepository,
        AddressInterfaceFactory $addressInterfaceFactory,
        Session $session,
        array $data = []
    ){
        parent::_construct($context, $data);
        $this->addressRepository = $addressRepository;
        $this->addressInterfaceFactory = $addressInterfaceFactory;
        $this->customerSession = $session;
    }

    protected function _prepareLayout(){
        $addressId = $this->getRequest()->getParam('id');

        if($addressId){
            try{
                $this->address = $this->addressRepository->getById($addresId);
                if($this->address->getCustomerId() != $this->customerSession->getCustomerId()){
                    $this->address = null;
                }
            } catch (NoSuchEntityException $exception){
                $this->address = null;
            }
        }

        if(null === $this->address){
            $this->address = $this->addressFactory->create();
        }
    
        return parent::_prepareLayout();
    }

    protected function _toHtml(){
        $customWidgetBlock = $this->getLayout()->createBlock(
            'Imagineer\CustomAddressDistrito\Block\Customer\Widget\Custom'
        );
        $customWidgetBlock->setAddress($this->address);
        return $customWidgetBlock->toHtml();
    }


}