=== product-testimonial-plugin ===
License URI: http://www.gnu.org/licenses/gpl-2.0.html

 Installation Instructions
1 Download the Plugin:
  
  Clone the repository or download the ZIP file of the plugin:
  git clone https://github.com/shuklaraghav99/product-testimonial-plugin.git

2 Upload the Plugin to WordPress:

  Go to the Plugins section in your WordPress admin dashboard.
  
  Click Add New and then Upload Plugin.

  Upload the ZIP file if you've downloaded it, or upload the plugin folder after cloning it into your wp-content/plugins directory.

3 Activate the Plugin:

  After uploading the plugin, go to Plugins > Installed Plugins and activate the "Product Testimonial Plugin".

3 How to Test the Code

  1) Add Testimonials:
  
  Go to Product Testimonial in the WordPress Admin menu.
  
  Click Add New Testimonial and enter the necessary details (rating, product selection, and testimonial content).
  
  2) Viewing Testimonials on the Product Page:
  
  Go to a product page on the front-end.
  
  If you've added testimonials for that product, they will appear in the Description tab.
  
  3) Free Gift Suggestion:
  
  Add products to your cart totaling more than 500 (or adjust the threshold in the code).
  
  Go to the cart page, and a message will appear suggesting a free gift.

4 Test the REST API Endpoint:

  Make a GET request to the following endpoint to retrieve the order details:
  GET /wp-json/wbcom/v1/order-details?order_id=<ORDER_ID>
  You need to be logged in to access this endpoint.

5 Test Testimonials REST API Endpoint:

  Use the following endpoint to get testimonials for a product:
  GET /wp-json/wpcom/v1/testimonials?product_id=<PRODUCT_ID>
  This will return a list of testimonials for the specified product.



Assumptions Made
  1) WooCommerce Plugin: Assumes WooCommerce is installed and active on the WordPress site, as the plugin relies on WooCommerce's features.
  
  2) Product Testimonial Post Type: The plugin creates a custom post type product_testimonial to store testimonials.


Bonus: Suggestions for Future Improvements
  1) Integration with WooCommerce Reviews:
  Combine the testimonial feature with WooCommerce's native review system. Allow users to submit testimonials as part of the review process.
  
  3) Testimonial Display Enhancements:
  Implement a more flexible and visually appealing testimonial display (e.g., grid layout, carousel, etc.) on the product pages.
  
  4) Frontend Testimonial Submission:
  Implement a frontend submission form for users to add testimonials directly from the product page without needing to access the admin panel.


License
  This plugin is licensed under the GPL v2 license. You can freely use, modify, and distribute the code, as long as you comply with the terms of the GPL license.

Contact Information
  For any further questions or support, please contact Raghav at raghav.career99@gmail.com or raise an issue in the GitHub repository.

Contributing
  If you'd like to contribute to the project, feel free to fork the repository, create a branch, and submit a pull request. Contributions, bug reports, and suggestions are always welcome!

Changelog
  Version 1.0:
  Initial release with product testimonial functionality and display on product pages.
