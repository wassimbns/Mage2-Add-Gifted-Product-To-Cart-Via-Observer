<?php

namespace Magneto\Catalog\Observer;

use Magento\Framework\Event\Observer as EventObserver;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\App\RequestInterface;

class AddPromoProductObserver implements ObserverInterface
{
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
        $sku = '6100102';  // sku of the gifted product
        $productId = 1438;  // Id of the gifted product
        $product = $observer->getEvent()->getProduct();
        /** @var \Magento\Quote\Model\Quote\Item $quoteItem */
        $quoteItem = $observer->getEvent()->getQuoteItem();
        $_promoProduct = $this->_productRepository->get($sku);

        if ($product->getId() == $productId) {
            $quoteItem->setIsGifted(1);
            $quoteItem->setBasePrice(0);
            $quoteItem->setPrice(0);
            $quoteItem->setCustomPrice(0);
            $quoteItem->setOriginalCustomPrice(0);
            $quoteItem->getProduct()->setIsSuperMode(true);
            $quoteItem->setQty(0);
            $quoteItem->save();
        }

        if ($this->checkoutSession->getQuote()->hasProductId($productId) == false) {

            if ($product->getId() != $productId) {
                $params = array(
                    'product' => $productId,
                    'qty' => 1,
                );
                $_promoProduct->setBasePrice(0);
                $_promoProduct->setPrice(0);
                $_promoProduct->setCustomPrice(0);
                $this->_cart->addProduct($_promoProduct, $params);
            }
        }

        return $this;
    }
}
