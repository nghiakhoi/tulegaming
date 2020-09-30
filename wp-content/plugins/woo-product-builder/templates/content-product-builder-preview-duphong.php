<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


$message_success = $settings->get_message_success();
$back_url        = get_the_permalink();

?>
<style type='text/css'>
.woocommerce-product-builder-table{
	background-color:gainsboro;
}
</style>
<div class="woocommerce-product-builder">
	<form method="POST" action="<?php echo wc_get_cart_url() ?>" class="woopb-form">
	<div id="html-content-holder" > 
	<?php wp_nonce_field( '_woopb_add_to_woocommerce', '_nonce' ) ?>
		<input type="hidden" name="woopb_id" value="<?php echo esc_attr( get_the_ID() ) ?>" />
		<h2><?php esc_html_e( 'Your chosen list', 'woo-product-builder' ); ?></h2>
		<?php
		if ( is_array( $products ) && count( $products ) ) { ?>
			<table class="woocommerce-product-builder-table">
				<thead>
				<tr>
					<th width="15%"></th>
					<th width="35%"><?php esc_html_e( 'Product', 'woo-product-builder' ) ?></th>
					<th width="15%"><?php esc_html_e( 'Price', 'woo-product-builder' ) ?></th>
					<th width="15%"><?php esc_html_e( 'Total', 'woo-product-builder' ) ?></th>
					<th width="5%"></th>

				</tr>
				</thead>
				<tbody>
				<?php
				$index = 1;
				$total = 0;
				foreach ( $products as $step_id => $items ) {
					foreach ( $items as $product_id => $quantity ) {
						$product       = wc_get_product( $product_id );
						$product_title = $product->get_title();
						$prd_des       = $product->get_short_description();
						if ( ! empty( get_the_post_thumbnail( $product_id ) ) ) {
							$prd_thumbnail = get_the_post_thumbnail( $product_id, 'thumbnail' );
						} else {
							$prd_thumbnail = wc_placeholder_img();
						}
						$product_price = $product->get_price();

						?>
						<tr>

							<td><?php echo $prd_thumbnail; ?></td>
							<td>
								<a target="_blank" href="<?php echo get_permalink( $product_id ); ?>" class="vi-chosen_title"><?php echo esc_html( $product_title ); ?></a> x <?php echo esc_html( $quantity ) ?>
							</td>
							<td><?php echo $product->get_price_html() ?></td>

							<td class="woopb-total">
								<?php echo wc_price( ( $product_price * $quantity ) ) ?>
							</td>
							<td>
								<?php
								$arg_remove = array(
									'stepp'      => $step_id,
									'product_id' => $product_id,
								);
								?>
								<a class="woopb-step-product-added-remove" href="<?php echo wp_nonce_url( add_query_arg( $arg_remove ), '_woopb_remove_product_step', '_nonce' ) ?>"></a>
							</td>
						</tr>
						<?php
						$total = $total + intval( $product_price );
					}
				} ?>
				</tbody>

			</table>
			
			<?php
		}

		?>
    </div> 
	<a href="<?php echo esc_url( $back_url ); ?>" class="woopb-button"><?php esc_attr_e( 'Back', 'woo-product-builder' ) ?></a>
			<button class="woopb-button woopb-button-primary"><?php esc_html_e( 'Add to cart', 'woo-product-builder' ) ?></button>
			<?php
			$settings = new VI_WPRODUCTBUILDER_F_Data();
			if ( $settings->enable_email() ) { ?>

				<a id="vi_wpb_sendtofriend" class="woopb-button"><?php esc_attr_e( 'Send email to your friend', 'woo-product-builder' ) ?></a>
			<?php } ?>
	</form>
	<script src= 
"https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"> 
    </script> 
       <script src= 
"https://files.codepedia.info/files/uploads/iScripts/html2canvas.js"> 
    </script> 
  
    <a class="woopb-button" id="btn-Convert-Html2Image" href="javascript:;"> 
        Xuất hình ảnh Build PC 
    </a> 
  
    <br/> 

    <script> 
        $(document).ready(function() { 
			
            // Global variable 
            var element = $("#html-content-holder");  
          
            // Global variable 
            var getCanvas;  
  
            
  
            $("#btn-Convert-Html2Image").on('click', function() { 
				html2canvas(element, { 
                    onrendered: function(canvas) {  
						saveAs(canvas.toDataURL(), 'BuildPC.png');
                    } 
                });
                
			}); 
			function saveAs(uri, filename) {
    var link = document.createElement('a');
    if (typeof link.download === 'string') {
      link.href = uri;
      link.download = filename;

      //Firefox requires the link to be in the body
      document.body.appendChild(link);

      //simulate click
      link.click();

      //remove the link when done
      document.body.removeChild(link);
    } else {
      window.open(uri);
    }
  }
        }); 
    </script> 

</div>
