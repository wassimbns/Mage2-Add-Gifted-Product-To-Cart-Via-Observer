# Mage2-Add-Gifted-Product-To-Cart-Via-Observer

This extention can always come in handy if you want to add a gift product to your customer cart.

It's very straight forward. It adds a specific product to the cart once your first product is added to the cart as implemented in the observer file "AddPromoProductObserver.php" .And it set's the price to zero and exclude it from the total price in the second observer file "SetGiftProductPriceObserver.php".

To keep track of your gifted products I added a custom boolean attribute in quote_item & sales_order_item named is_gifted that will be filled via the plugin file "CatalogToOrderItem.php" once the checkout process in completed.

So to get started with this extention, hit the Setup command : php bin/magento setup:upgrade 

Feel free to reach out for any issue...

