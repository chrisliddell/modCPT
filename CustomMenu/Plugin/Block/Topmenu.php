<?php 

namespace Imagineer\CustomMenu\Plugin\Block;

use Magento\Framework\Data\Tree\NodeFactory;

class Topmenu
{
    /**
     * @var NodeFactory
     */
    protected $nodeFactory;
    protected $_storeManager;

    public function __construct(
        NodeFactory $nodeFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    ) {
        $this->nodeFactory = $nodeFactory;
        $this->_storeManager=$storeManager;
    }

    public function beforeGetHtml(
        \Magento\Theme\Block\Html\Topmenu $subject,
        $outermostClass = '',
        $childrenWrapClass = '',
        $limit = 0
    ) {
        $node = $this->nodeFactory->create(
            [
                'data' => $this->getNodeAsArray(),
                'idField' => 'id',
                'tree' => $subject->getMenu()->getTree()
            ]
        );
        $subject->getMenu()->addChild($node);
    }

    protected function getNodeAsArray()
    {
        return [
            'name' => __('Conócenos'),
            'id' => 'conocenos',
            'url' => $this->_storeManager->getStore()->getBaseUrl() . 'conocenos',
            'has_active' => false,
            'is_active' => false // (expression to determine if menu item is selected or not)
        ];
    }

    public function afterGetHtml(\Magento\Theme\Block\Html\Topmenu $topmenu, $html)
    {
        $swappartyUrl = $topmenu->getUrl('sale');//here you can set link
        $magentoCurrentUrl = $topmenu->getUrl('*/*/*', ['_current' => true, '_use_rewrite' => true]);
        if (strpos($magentoCurrentUrl,'testCustomMenu/custommenu') !== false) {
            $html .= "<li class=\"level0 nav-5 active level-top  ui-menu-item\">";
        } else {
            $html .= "<li class=\"level0 nav-4 level-top  ui-menu-item\">";
        }
        $html .= "<a href=\"" . $swappartyUrl . "\" class=\"level-top ui-corner-all\"><span>" . __("SALE") . "</span></a>";
        $html .= "</li>";
        return $html;
    }
}
