<?php

namespace Magento\Catalog\Observer;

use Magento\Framework\Event\Observer as EventObserver;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\App\RequestInterface;

class SetGiftProductPriceObserver implements ObserverInterface
{
    static $isCollected = false;
    protected $_productRepository;
    protected $_cart;

    /**
     * AddPromoProductObserver constructor.
     * @param \Magento\Catalog\Model\ProductRepository $productRepository
     * @param \Magento\Checkout\Model\Cart $cart
     * @param \Magento\Checkout\Model\Session $checkoutSession
     */
    public function __construct(
        \Magento\Catalog\Model\ProductRepository $productRepository,
        \Magento\Checkout\Model\Cart $cart,
        \Magento\Checkout\Model\Session $checkoutSession
    )
    {
        $this->_productRepository = $productRepository;
        $this->_cart = $cart;
        $this->checkoutSession = $checkoutSession;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $giftProductId = 1438;

        /** @var \Magento\Quote\Model\Quote $quote */
        $quote = $observer->getEvent()->getQuote();

        foreach ($quote->getAllItems() as $quoteItem) {
            if ($quoteItem->getProductId() == $giftProductId) {
                $quoteItem->setCustomPrice(0);
                $quoteItem->setOriginalCustomPrice(0);
                $quoteItem->getProduct()->setIsSuperMode(true);
                $quoteItem->setQty(0);
                $quoteItem->save();
            }
        }

        return $this;
    }

}
