# Sample products for China Shop Pro

INSERT INTO `categories` (`name`, `slug`, `description`, `sort_order`) VALUES
('Electronics', 'electronics', 'Latest gadgets and electronic devices', 1),
('Fashion', 'fashion', 'Trendy clothing and accessories', 2),
('Home & Living', 'home-living', 'Home decoration and furniture', 3),
('Beauty & Health', 'beauty-health', 'Skincare, makeup and health products', 4),
('Sports & Outdoor', 'sports-outdoor', 'Sports equipment and outdoor gear', 5);

# Sample products
INSERT INTO `products` (`category_id`, `name`, `slug`, `description`, `short_description`, `price`, `compare_price`, `sku`, `stock_quantity`, `tiktok_url`, `featured`, `is_active`) VALUES
(1, 'Wireless Bluetooth Earbuds Pro', 'wireless-bluetooth-earbuds-pro', 'High-quality wireless earbuds with noise cancellation and long battery life. Perfect for music lovers and professionals.', 'Premium wireless earbuds with noise cancellation', 89.99, 129.99, 'WBE001', 25, 'https://www.tiktok.com/@sample/video/1', 1, 1),
(1, 'Smart Phone Stand with Wireless Charging', 'smart-phone-stand-wireless-charging', 'Adjustable phone stand with built-in wireless charging pad. Compatible with all Qi-enabled devices.', '2-in-1 phone stand and wireless charger', 45.99, 65.99, 'SPS002', 15, 'https://www.tiktok.com/@sample/video/2', 1, 1),
(2, 'Korean Style Oversized Hoodie', 'korean-style-oversized-hoodie', 'Comfortable oversized hoodie in Korean fashion style. Made with premium cotton blend for ultimate comfort.', 'Trendy oversized hoodie in Korean style', 34.99, 49.99, 'KSH003', 30, 'https://www.tiktok.com/@sample/video/3', 1, 1),
(2, 'Japanese Minimalist Backpack', 'japanese-minimalist-backpack', 'Sleek and functional backpack with multiple compartments. Perfect for work, school, or travel.', 'Minimalist backpack with laptop compartment', 67.99, 89.99, 'JMB004', 20, 'https://www.tiktok.com/@sample/video/4', 1, 1),
(3, 'LED Strip Lights RGB 16ft', 'led-strip-lights-rgb-16ft', 'Color-changing LED strip lights with remote control. Perfect for bedroom, living room, or party decoration.', 'RGB LED strips with remote control', 24.99, 39.99, 'LED005', 50, 'https://www.tiktok.com/@sample/video/5', 1, 1),
(3, 'Bamboo Desk Organizer Set', 'bamboo-desk-organizer-set', 'Eco-friendly bamboo desk organizer with multiple compartments for pens, papers, and accessories.', 'Sustainable bamboo desk organization', 28.99, 39.99, 'BDO006', 35, '', 0, 1),
(4, 'Korean Skincare Routine Kit', 'korean-skincare-routine-kit', 'Complete 7-step Korean skincare routine with cleanser, toner, serum, and moisturizer. Suitable for all skin types.', '7-step Korean skincare complete set', 156.99, 199.99, 'KSK007', 12, 'https://www.tiktok.com/@sample/video/7', 1, 1),
(4, 'Jade Facial Roller and Gua Sha Set', 'jade-facial-roller-gua-sha-set', 'Authentic jade facial roller and gua sha tools for natural facial massage and skincare routine.', 'Natural jade facial massage tools', 19.99, 29.99, 'JFR008', 40, 'https://www.tiktok.com/@sample/video/8', 1, 1),
(5, 'Resistance Bands Exercise Set', 'resistance-bands-exercise-set', 'Complete resistance bands set with 5 different resistance levels, door anchor, and workout guide.', '5-level resistance bands for home workout', 31.99, 45.99, 'RBE009', 25, 'https://www.tiktok.com/@sample/video/9', 1, 1),
(5, 'Yoga Mat Premium Non-Slip', 'yoga-mat-premium-non-slip', 'Extra thick yoga mat with non-slip surface and carrying strap. Perfect for yoga, pilates, and meditation.', 'Premium non-slip yoga mat', 42.99, 59.99, 'YMP010', 18, '', 0, 1);

# Sample product images (placeholder paths)
INSERT INTO `product_images` (`product_id`, `image_path`, `alt_text`, `is_primary`) VALUES
(1, 'assets/images/products/earbuds-1.jpg', 'Wireless Bluetooth Earbuds', 1),
(2, 'assets/images/products/phone-stand-1.jpg', 'Phone Stand with Wireless Charging', 1),
(3, 'assets/images/products/hoodie-1.jpg', 'Korean Style Oversized Hoodie', 1),
(4, 'assets/images/products/backpack-1.jpg', 'Japanese Minimalist Backpack', 1),
(5, 'assets/images/products/led-strips-1.jpg', 'RGB LED Strip Lights', 1),
(6, 'assets/images/products/desk-organizer-1.jpg', 'Bamboo Desk Organizer', 1),
(7, 'assets/images/products/skincare-kit-1.jpg', 'Korean Skincare Kit', 1),
(8, 'assets/images/products/jade-roller-1.jpg', 'Jade Facial Roller Set', 1),
(9, 'assets/images/products/resistance-bands-1.jpg', 'Resistance Bands Set', 1),
(10, 'assets/images/products/yoga-mat-1.jpg', 'Premium Yoga Mat', 1);