<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

class VI_WPRODUCTBUILDER_F_FrontEnd_Step {
	protected $data;

	public function __construct() {
		$this->settings = new VI_WPRODUCTBUILDER_F_Data();
		/*Add Script*/
		add_action( 'wp_enqueue_scripts', array( $this, 'init_scripts' ) );
		/*Single template*/
		add_action( 'woocommerce_product_builder_single_product_content_before', array( $this, 'sort_by' ) );
		add_action( 'woocommerce_product_builder_single_top', array( $this, 'step_html' ) );
		add_action( 'woocommerce_product_builder_single_top', array( $this, 'step_title' ), 9 );
		add_action( 'woocommerce_product_builder_single_content', array(
			$this,
			'product_builder_content_single_page'
		), 11 );
		add_action( 'woocommerce_product_builder_single_bottom', array(
			$this,
			'woocommerce_product_builder_single_product_content_pagination'
		), 10, 2 );
		/*Form send email to friend of review page*/
		if ( $this->settings->enable_email() ) {
			add_action( 'wp_footer', array( $this, 'share_popup_form' ) );
		}

		/*Product html*/
		add_action( 'woocommerce_product_builder_single_product_content', array( $this, 'product_thumb' ), 10 );
		add_action( 'woocommerce_product_builder_single_product_content', array( $this, 'product_title' ), 20 );
		add_action( 'woocommerce_product_builder_single_product_content', array( $this, 'product_price' ), 30 );
		add_action( 'woocommerce_product_builder_single_product_content', array( $this, 'product_description' ), 35 );
		add_action( 'woocommerce_product_builder_single_product_content', array( $this, 'add_to_cart' ), 40 );
		add_action( 'woocommerce_product_builder_simple_add_to_cart', array( $this, 'simple_add_to_cart' ), 40 );
		add_action( 'woocommerce_product_builder_variable_add_to_cart', array( $this, 'variable_add_to_cart' ), 40 );
		add_action( 'woocommerce_product_builder_single_variation', array(
			$this,
			'woocommerce_single_variation'
		), 10 );
		add_action( 'woocommerce_product_builder_single_variation', array(
			$this,
			'woocommerce_product_builder_single_variation'
		), 20 );
		add_action( 'woocommerce_product_builder_quantity_field', array( $this, 'quantity_field' ), 10, 2 );

		/*Add Query var*/
		add_action( 'pre_get_posts', array( $this, 'add_vars' ) );
	}

	/*
	 *
	 */
	public function quantity_field( $product, $post_id ) {
		$enable_quantity = $this->get_data( $post_id, 'enable_quantity' );
		if ( $enable_quantity ) {
			woocommerce_quantity_input(
				array(
					'min_value'   => apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product ),
					'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product ),
					'input_value' => isset( $_POST['quantity'] ) ? 1 : $product->get_min_purchase_quantity(),
				)
			);
		}
	}

	public function share_popup_form() {
		global $wp_query;
		if ( isset( $wp_query->query_vars['woopb_preview'] ) ) {
			wc_get_template(
				'content-product-builder-preview-popup.php', array(), '', VI_WPRODUCTBUILDER_F_TEMPLATES
			);
		}
	}

	/**
	 *
	 */
	public function woocommerce_product_builder_single_variation( $post_id ) {
		wc_get_template( 'single/variation-add-to-cart-button.php', array( 'post_id' => $post_id ), '', VI_WPRODUCTBUILDER_F_TEMPLATES );

	}

	/**
	 *
	 */
	public function woocommerce_single_variation() {
		echo '<div class="woocommerce-product-builder-variation single_variation"></div>';
	}

	public function step_title() {
		global $post;
		$post_id = $post->ID;
		/*Process Navigation button*/
		$step_id    = get_query_var( 'step' );
		$tabs       = $this->get_data( $post_id, 'tab_title' );
		$count_tabs = count( $tabs );
		$step_id    = $step_id ? $step_id : 1;
		$step_prev  = $step_next = 0;
		if ( $count_tabs > $step_id ) {
			$step_next = $step_id + 1;
			if ( $step_id > 1 ) {
				$step_prev = $step_id - 1;
			}
		} else {
			if ( $step_id > 1 ) {
				$step_prev = $step_id - 1;
			}
		}
		$review_url   = add_query_arg( array( 'woopb_preview' => 1 ), get_the_permalink() );
		$next_url     = add_query_arg( array( 'step' => $step_next ), get_the_permalink() );
		$previous_url = add_query_arg( array( 'step' => $step_prev ), get_the_permalink() );
		?>
		<div class="woopb-heading-navigation">
			<div class="woopb-heading">
				<?php $step_text = $this->get_data( $post_id, 'text_prefix' );
				if ( $step_text ) {
					echo '<span class="woopb-heading-step-prefix">' . esc_html( str_replace( '{step_number}', $step_id, $step_text ) ) . '</span>';
				}
				echo '<span class="woopb-heading-step-title">' . esc_html( $tabs[ $step_id - 1 ] ) . '</span>' ?>
			</div>

			<div class="woopb-navigation">
				<?php if ( $step_prev ) { ?>
					<div class="woopb-navigation-previous">
						<a href="<?php echo esc_url( $previous_url ) ?>" class="woopb-link"><?php echo esc_html__( 'Previous', 'woo-product-builder' ) ?></a>
					</div>
				<?php } ?>
				<?php if ( $step_next ) { ?>
					<div class="woopb-navigation-next">
						<a href="<?php echo esc_url( $next_url ) ?>" class="woopb-link"><?php echo esc_html__( 'Next', 'woo-product-builder' ) ?></a>
					</div>
				<?php }

				/*Check all steps that producted are added*/
				if ( ! $step_next && $this->get_data( $post_id, 'enable_preview' ) ) { ?>
					<div class="woopb-navigation-preview">
						<a href="<?php echo esc_url( $review_url ) ?>" class="woopb-link"><?php echo esc_html__( 'Preview', 'woo-product-builder' ) ?></a>
					</div>

					<?php
				}
				if ( $this->settings->has_step_added( $post_id ) ) {
					?>
					<form method="POST" action="<?php echo wc_get_cart_url() ?>" class="woopb-form-cart-now">
						<?php wp_nonce_field( '_woopb_add_to_woocommerce', '_nonce' ) ?>
						<input type="hidden" name="woopb_id" value="<?php echo esc_attr( get_the_ID() ) ?>" />
						<button class="woopb-button woopb-button-primary"><?php esc_html_e( 'Add to cart', 'woo-product-builder' ) ?></button>
					</form>
				<?php } ?>
			</div>
		</div>
	<?php }

	/**
	 * Sort by
	 */
	public function sort_by() {
		/*Process sort by*/
		$current = get_query_var( 'sort_by' );
		?>
		<div class="woopb-sort-by">
			<div class="woopb-sort-by-inner">

				<?php $sort_by_events = array(
					''           => esc_html__( 'Default', 'woo-product-builder' ),
					'price_low'  => esc_html__( 'Price low to high', 'woo-product-builder' ),
					'price_high' => esc_html__( 'Price high to low', 'woo-product-builder' ),
					'title_az'   => esc_html__( 'Title A-Z', 'woo-product-builder' ),
					'title_za'   => esc_html__( 'Title Z-A', 'woo-product-builder' ),
				); ?>
				<select class="woopb-sort-by-button woopb-button">
					<?php
					foreach ( $sort_by_events as $k => $sort_by_event ) { ?>
						<option <?php selected( $current, $k ) ?> value="<?php echo add_query_arg( array( 'sort_by' => $k ) ) ?>"><?php echo $sort_by_event ?></option>
					<?php } ?>
				</select>
			</div>
		</div>
	<?php }

	/**
	 * Product Description
	 */
	public function product_description() {
		wc_get_template( 'single/product-short-description.php', '', '', VI_WPRODUCTBUILDER_F_TEMPLATES );
	}

	/**
	 * Add Query Var
	 *
	 * @param $wp_query
	 */
	function add_vars( &$wp_query ) {
		$step_id                               = filter_input( INPUT_GET, 'step', FILTER_SANITIZE_NUMBER_INT );
		$wp_query->query_vars['step']          = $step_id ? $step_id : 1;
		$page                                  = filter_input( INPUT_GET, 'ppaged', FILTER_SANITIZE_NUMBER_INT );
		$wp_query->query_vars['ppaged']        = $page ? $page : 1;
		$wp_query->query_vars['max_page']      = $step_id ? $step_id : 1;
		$wp_query->query_vars['rating_filter'] = filter_input( INPUT_GET, 'rating_filter', FILTER_SANITIZE_STRING );
		$wp_query->query_vars['sort_by']       = filter_input( INPUT_GET, 'sort_by', FILTER_SANITIZE_STRING );
	}

	/**
	 * Show step
	 */
	public function step_html() {
		global $post;
		$post_id = $post->ID;
		/*Get current step*/
		$step_titles = $this->get_data( $post_id, 'tab_title', array() );
		$step_id     = get_query_var( 'step' );
		$step_id     = $step_id ? $step_id : 1;
		?>
		
   
     <link rel="stylesheet" href="https://hanoicomputercdn.com/template/may2020/script/style_build_pc_v2.css?v=1123567689">

<div class="build-pc">
	<div class="build-pc_content">
          
          <div class="km-pc-laprap">
           
          </div>
          
          <div class="clear"></div>
           <ul class="list-btn-action " style="margin-top:0; float:left; border:none;">
                
            
            	<li style="width:auto;"><span onclick="openPopupRebuild()" style="padding:0 20px;">Làm mới <i class="far fa-sync"></i></span></li>
            
          </ul>
          
          <div class="clear"></div>
          <div class="separator"></div>
          
          <p style="float:right; font-size:20px; margin-top:10px;">Chi phí dự tính: <span class="js-config-summary" style="color: #d00; font-weight: bold"><span class="total-price-config">0</span> đ <p> </p></span> </p><div class="clear"></div>
			<div class="js-buildpc-promotion-content"></div>
          <div class="clear"></div>
          <div class="list-drive" id="js-buildpc-layout"><div class="item-drive">
                            <span class="d-name">1. Bộ vi xử lý</span>
                            <div class="drive-checked">
                                <span class="show-popup_select span-last open-selection" id="js-category-info-31" data-info="{&quot;id&quot;:31,&quot;name&quot;:&quot;Bộ vi xử lý&quot;}"><i class="fa fa-plus"></i> Chọn Bộ vi xử lý</span>
                                <div id="js-selected-item-31"></div>
                            </div>
                        </div><div class="item-drive">
                            <span class="d-name">2. Bo mạch chủ</span>
                            <div class="drive-checked">
                                <span class="show-popup_select span-last open-selection" id="js-category-info-30" data-info="{&quot;id&quot;:30,&quot;name&quot;:&quot;Bo mạch chủ&quot;}"><i class="fa fa-plus"></i> Chọn Bo mạch chủ</span>
                                <div id="js-selected-item-30"></div>
                            </div>
                        </div><div class="item-drive">
                            <span class="d-name">3. RAM</span>
                            <div class="drive-checked">
                                <span class="show-popup_select span-last open-selection" id="js-category-info-32" data-info="{&quot;id&quot;:32,&quot;name&quot;:&quot;RAM&quot;}"><i class="fa fa-plus"></i> Chọn RAM</span>
                                <div id="js-selected-item-32"></div>
                            </div>
                        </div><div class="item-drive">
                            <span class="d-name">4. HDD</span>
                            <div class="drive-checked">
                                <span class="show-popup_select span-last open-selection" id="js-category-info-33" data-info="{&quot;id&quot;:33,&quot;name&quot;:&quot;HDD&quot;}"><i class="fa fa-plus"></i> Chọn HDD</span>
                                <div id="js-selected-item-33"></div>
                            </div>
                        </div><div class="item-drive">
                            <span class="d-name">5. SSD</span>
                            <div class="drive-checked">
                                <span class="show-popup_select span-last open-selection" id="js-category-info-164" data-info="{&quot;id&quot;:164,&quot;name&quot;:&quot;SSD&quot;}"><i class="fa fa-plus"></i> Chọn SSD</span>
                                <div id="js-selected-item-164"></div>
                            </div>
                        </div><div class="item-drive">
                            <span class="d-name">6. VGA</span>
                            <div class="drive-checked">
                                <span class="show-popup_select span-last open-selection" id="js-category-info-34" data-info="{&quot;id&quot;:34,&quot;name&quot;:&quot;VGA&quot;}"><i class="fa fa-plus"></i> Chọn VGA</span>
                                <div id="js-selected-item-34"></div>
                            </div>
                        </div><div class="item-drive">
                            <span class="d-name">7. Nguồn</span>
                            <div class="drive-checked">
                                <span class="show-popup_select span-last open-selection" id="js-category-info-36" data-info="{&quot;id&quot;:36,&quot;name&quot;:&quot;Nguồn&quot;}"><i class="fa fa-plus"></i> Chọn Nguồn</span>
                                <div id="js-selected-item-36"></div>
                            </div>
                        </div><div class="item-drive">
                            <span class="d-name">8. Vỏ Case</span>
                            <div class="drive-checked">
                                <span class="show-popup_select span-last open-selection" id="js-category-info-35" data-info="{&quot;id&quot;:35,&quot;name&quot;:&quot;Vỏ Case&quot;}"><i class="fa fa-plus"></i> Chọn Vỏ Case</span>
                                <div id="js-selected-item-35"></div>
                            </div>
                        </div><div class="item-drive">
                            <span class="d-name">9. Màn hình</span>
                            <div class="drive-checked">
                                <span class="show-popup_select span-last open-selection" id="js-category-info-39" data-info="{&quot;id&quot;:39,&quot;name&quot;:&quot;Màn hình&quot;}"><i class="fa fa-plus"></i> Chọn Màn hình</span>
                                <div id="js-selected-item-39"></div>
                            </div>
                        </div><div class="item-drive">
                            <span class="d-name">10. Bộ bàn phím, chuột</span>
                            <div class="drive-checked">
                                <span class="show-popup_select span-last open-selection" id="js-category-info-169" data-info="{&quot;id&quot;:169,&quot;name&quot;:&quot;Bộ bàn phím, chuột&quot;}"><i class="fa fa-plus"></i> Chọn Bộ bàn phím, chuột</span>
                                <div id="js-selected-item-169"></div>
                            </div>
                        </div><div class="item-drive">
                            <span class="d-name">11. Bàn phím</span>
                            <div class="drive-checked">
                                <span class="show-popup_select span-last open-selection" id="js-category-info-37" data-info="{&quot;id&quot;:37,&quot;name&quot;:&quot;Bàn phím&quot;}"><i class="fa fa-plus"></i> Chọn Bàn phím</span>
                                <div id="js-selected-item-37"></div>
                            </div>
                        </div><div class="item-drive">
                            <span class="d-name">12. Chuột</span>
                            <div class="drive-checked">
                                <span class="show-popup_select span-last open-selection" id="js-category-info-38" data-info="{&quot;id&quot;:38,&quot;name&quot;:&quot;Chuột&quot;}"><i class="fa fa-plus"></i> Chọn Chuột</span>
                                <div id="js-selected-item-38"></div>
                            </div>
                        </div><div class="item-drive">
                            <span class="d-name">13. Tai nghe</span>
                            <div class="drive-checked">
                                <span class="show-popup_select span-last open-selection" id="js-category-info-246" data-info="{&quot;id&quot;:246,&quot;name&quot;:&quot;Tai nghe&quot;}"><i class="fa fa-plus"></i> Chọn Tai nghe</span>
                                <div id="js-selected-item-246"></div>
                            </div>
                        </div><div class="item-drive">
                            <span class="d-name">14. Loa</span>
                            <div class="drive-checked">
                                <span class="show-popup_select span-last open-selection" id="js-category-info-248" data-info="{&quot;id&quot;:248,&quot;name&quot;:&quot;Loa&quot;}"><i class="fa fa-plus"></i> Chọn Loa</span>
                                <div id="js-selected-item-248"></div>
                            </div>
                        </div><div class="item-drive">
                            <span class="d-name">15. Ghế Gaming</span>
                            <div class="drive-checked">
                                <span class="show-popup_select span-last open-selection" id="js-category-info-316" data-info="{&quot;id&quot;:316,&quot;name&quot;:&quot;Ghế Gaming&quot;}"><i class="fa fa-plus"></i> Chọn Ghế Gaming</span>
                                <div id="js-selected-item-316"></div>
                            </div>
                        </div><div class="item-drive">
                            <span class="d-name">16. Quạt Làm Mát</span>
                            <div class="drive-checked">
                                <span class="show-popup_select span-last open-selection" id="js-category-info-68" data-info="{&quot;id&quot;:68,&quot;name&quot;:&quot;Quạt Làm Mát&quot;}"><i class="fa fa-plus"></i> Chọn Quạt Làm Mát</span>
                                <div id="js-selected-item-68"></div>
                            </div>
                        </div><div class="item-drive">
                            <span class="d-name">17. Tản nhiệt nước All in One</span>
                            <div class="drive-checked">
                                <span class="show-popup_select span-last open-selection" id="js-category-info-332" data-info="{&quot;id&quot;:332,&quot;name&quot;:&quot;Tản nhiệt nước All in One&quot;}"><i class="fa fa-plus"></i> Chọn Tản nhiệt nước All in One</span>
                                <div id="js-selected-item-332"></div>
                            </div>
                        </div><div class="item-drive">
                            <span class="d-name">18. Tản nhiệt nước Custom</span>
                            <div class="drive-checked">
                                <span class="show-popup_select span-last open-selection" id="js-category-info-334" data-info="{&quot;id&quot;:334,&quot;name&quot;:&quot;Tản nhiệt nước Custom&quot;}"><i class="fa fa-plus"></i> Chọn Tản nhiệt nước Custom</span>
                                <div id="js-selected-item-334"></div>
                            </div>
                        </div><div class="item-drive">
                            <span class="d-name">19. Tản Nhiệt khí</span>
                            <div class="drive-checked">
                                <span class="show-popup_select span-last open-selection" id="js-category-info-64" data-info="{&quot;id&quot;:64,&quot;name&quot;:&quot;Tản Nhiệt khí&quot;}"><i class="fa fa-plus"></i> Chọn Tản Nhiệt khí</span>
                                <div id="js-selected-item-64"></div>
                            </div>
                        </div><div class="item-drive">
                            <span class="d-name">20. Windows bản quyền</span>
                            <div class="drive-checked">
                                <span class="show-popup_select span-last open-selection" id="js-category-info-53" data-info="{&quot;id&quot;:53,&quot;name&quot;:&quot;Windows bản quyền&quot;}"><i class="fa fa-plus"></i> Chọn Windows bản quyền</span>
                                <div id="js-selected-item-53"></div>
                            </div>
                        </div><div class="item-drive">
                            <span class="d-name">21. Phần mềm Antivirus</span>
                            <div class="drive-checked">
                                <span class="show-popup_select span-last open-selection" id="js-category-info-52" data-info="{&quot;id&quot;:52,&quot;name&quot;:&quot;Phần mềm Antivirus&quot;}"><i class="fa fa-plus"></i> Chọn Phần mềm Antivirus</span>
                                <div id="js-selected-item-52"></div>
                            </div>
                        </div></div>
          <div class="clear"></div>
          <p style="float:right; font-size:20px; margin-top:10px;">Chi phí dự tính: <span class="js-config-summary" style="color: #d00; font-weight: bold"><span class="total-price-config">0</span> đ <p> </p></span></p><div class="clear"></div>
          <div class="js-buildpc-promotion-content"></div>
          <div class="clear"></div>
          <ul class="list-btn-action" id="js-buildpc-action">
            <li><span data-action="save">lưu cấu hình <i class="far fa-save"></i></span></li>
            <li><span data-action="download-excel">tải file excel cấu hình <i class="far fa-file-excel"></i></span></li>
            <li><span data-action="create-image">tải ảnh cấu hình <i class="far fa-image"></i></span></li>
            <li><span data-action="share">chia sẻ cấu hình <i class="far fa-image"></i></span></li>
            <li><span data-action="view">Xem &amp; In <i class="far fa-image"></i></span></li>
            <!--<li><a  href="http://www.facebook.com/sharer.php?u=https://www.hanoicomputer.vn/buildpc" target="blank" style="color:#fff;"><span>chia sẻ cấu hình <i class="far fa-image"></i></span></a></li>-->
            <li><span data-action="add-cart">Thêm vào giỏ hàng <i class="fas fa-shopping-cart"></i></span></li>
          </ul>

	</div>
</div>



	<?php }

	/*
	 * Pagination
	 */
	public function woocommerce_product_builder_single_product_content_pagination( $products, $max_page ) {

		$step         = get_query_var( 'step' );
		$current_page = get_query_var( 'ppaged' );
		$current_page = $current_page ? $current_page : 1;
		if ( $max_page == 1 ) {
			return;
		}

		?>
		<div class="woopb-products-pagination">
			<?php for ( $i = 1; $i <= $max_page; $i ++ ) {
				$arg = array(
					'ppaged' => $i,
					'step'   => $step
				);
				?>
				<div class="woopb-page <?php echo $current_page == $i ? 'woopb-active' : '' ?>">
					<a href="<?php echo add_query_arg( $arg ) ?>"><?php echo esc_html( $i ) ?></a>
				</div>
			<?php } ?>
		</div>
	<?php }

	/**
	 * Product variable
	 */
	public function variable_add_to_cart( $post_id ) {
		global $product;

		// Enqueue variation scripts.
		wp_enqueue_script( 'wc-add-to-cart-variation' );

		// Get Available variations?
		$get_variations = count( $product->get_children() ) <= apply_filters( 'woocommerce_ajax_variation_threshold', 30, $product );

		// Load the template.
		wc_get_template(
			'single/add-to-cart-variable.php', array(
			'available_variations' => $get_variations ? $product->get_available_variations() : false,
			'attributes'           => $product->get_variation_attributes(),
			'selected_attributes'  => $product->get_default_attributes(),
			'post_id'              => $post_id
		), '', VI_WPRODUCTBUILDER_F_TEMPLATES
		);
	}

	public function simple_add_to_cart( $post_id ) {
		wc_get_template( 'single/add-to-cart-simple.php', array( 'post_id' => $post_id ), '', VI_WPRODUCTBUILDER_F_TEMPLATES );
	}

	public function add_to_cart( $post_id ) {
		$step_id       = get_query_var( 'step' ) ? get_query_var( 'step' ) : 1;
		$product_added = $this->settings->get_products_added( $post_id, $step_id );
		if ( count( $product_added ) < 1 ) {
			$allow_add_to_cart = 1;
		} else {
			$allow_add_to_cart = 0;
		}
		if ( $allow_add_to_cart ) {
			global $product;
			do_action( 'woocommerce_product_builder_' . $product->get_type() . '_add_to_cart', $post_id );
		}
		/*Create close div of right content*/
		echo '</div>';
	}

	/**
	 * Init Script
	 */
	public function init_scripts() {
		if ( $this->settings->get_button_icon() ) {
			wp_enqueue_style( 'woocommerce-product-builder-icon', VI_WPRODUCTBUILDER_F_CSS . 'woo-product-builder-icon.css', array(), VI_WPRODUCTBUILDER_F_VERSION );
		}
		wp_enqueue_style( 'woo-product-builder', VI_WPRODUCTBUILDER_F_CSS . 'woo-product-builder.css', array(), VI_WPRODUCTBUILDER_F_VERSION );

		if ( is_rtl() ) {
			wp_enqueue_style( 'woo-product-builder-rtl', VI_WPRODUCTBUILDER_CSS . 'wooc-product-builder-rtl.css', array(), VI_WPRODUCTBUILDER_F_VERSION );
		}
		/*Add script*/
		wp_enqueue_script( 'woo-product-builder', VI_WPRODUCTBUILDER_F_JS . 'woo-product-builder.js', array( 'jquery' ), VI_WPRODUCTBUILDER_F_VERSION );
		$button_text_color      = $this->settings->get_button_text_color();
		$button_bg_color        = $this->settings->get_button_bg_color();
		$button_main_text_color = $this->settings->get_button_main_text_color();
		$button_main_bg_color   = $this->settings->get_button_main_bg_color();
		$custom_css             = "
		.vi-wpb-wrapper .woopb-products-pagination .woopb-page.woopb-active,
		.vi-wpb-wrapper .woopb-products-pagination .woopb-page:hover,
		.vi-wpb-wrapper .woocommerce-product-builder-wrapper .woopb-product .woopb-product-right .cart button:hover,
		.woopb-button.woopb-button-primary,
		.woopb-button:hover,
		.woocommerce-product-builder-widget.widget_price_filter .ui-slider:hover .ui-slider-range, 
		.woocommerce-product-builder-widget.widget_price_filter .ui-slider:hover .ui-slider-handle,
		.vi-wpb-wrapper .entry-content .woopb-steps .woopb-step-heading.woopb-step-heading-active,
		.vi-wpb-wrapper .entry-content .woopb-steps .woopb-step-heading.woopb-step-heading-active a
		{	color:{$button_main_text_color};
			background-color:{$button_main_bg_color};
		}
		.vi-wpb-wrapper .woopb-products-pagination .woopb-page,
		.vi-wpb-wrapper .woocommerce-product-builder-wrapper .woopb-product .woopb-product-right .cart button,
		.woopb-button,
		.woocommerce-product-builder-widget.widget_price_filter .ui-slider .ui-slider-range, 
		.woocommerce-product-builder-widget.widget_price_filter .ui-slider .ui-slider-handle
		{
		color:{$button_text_color};
		background-color:{$button_bg_color};
		}
		.vi-wpb-wrapper .woocommerce-product-builder-wrapper .woopb-product .woopb-product-right .cart button:before,, .woocommerce-product-builder-widget .woocommerce-widget-layered-nav-list li > a:hover::before, .woocommerce-product-builder-widget .woocommerce-widget-layered-nav-list li.chosen > a:before{
			color:$button_bg_color;
		}
		.vi-wpb-wrapper .woopb-navigation a,.vi-wpb-wrapper .woocommerce-product-builder-wrapper .woopb-product .woopb-product-right .cart button:hover:before,.vi-wpb-wrapper .woopb-step-heading-active a,.vi-wpb-wrapper a:hover{
			color:$button_main_bg_color;
		}
		.vi-wpb-wrapper .entry-content .woopb-steps .woopb-step-heading.woopb-step-heading-active:before{
			background-color:$button_main_bg_color;
		}
		";
		$custom_css             .= $this->settings->get_custom_css();
		wp_add_inline_style( 'woo-product-builder', $custom_css );
		// Localize the script with new data
		$translation_array = array(
			'ajax_url' => admin_url( 'admin-ajax.php' )
		);
		wp_localize_script( 'woo-product-builder', '_woo_product_builder_params', $translation_array );
	}

	/**
	 * Product Title
	 */
	public function product_price() {
		wc_get_template( 'single/product-price.php', '', '', VI_WPRODUCTBUILDER_F_TEMPLATES );
	}

	/**
	 * Product Title
	 */
	public function product_thumb() {
		wc_get_template( 'single/product-image.php', '', '', VI_WPRODUCTBUILDER_F_TEMPLATES );
	}

	/**
	 * Product Title
	 */
	public function product_title() {
		/*Create div before title*/
		echo '<div class="woopb-product-right">';
		wc_get_template( 'single/product-title.php', '', '', VI_WPRODUCTBUILDER_F_TEMPLATES ); ?>
	<?php }

	/**
	 * Get Product Ids
	 */
	public function product_builder_content_single_page() {

		global $post, $wp_query;
		$post_id  = $post->ID;
		$data     = $this->settings->get_product_filters( $post_id );
		$max_page = 1;
		$products = array();

		if ( isset( $wp_query->query_vars['woopb_preview'] ) ) {
			$products = $this->settings->get_products_added( $post_id );
			$settings = $this->settings;
			if ( is_array( $products ) && count( $products ) ) {
				wc_get_template(
					'content-product-builder-preview.php', array(
					'products' => $products,
					'settings' => $settings
				), '', VI_WPRODUCTBUILDER_F_TEMPLATES
				);
			} else {
				if ( $data ) {
					$products = $data->posts;
					$max_page = $data->max_num_pages;
				}
				wc_get_template(
					'content-product-builder-single.php', array(
					'products' => $products,
					'max_page' => $max_page
				), '', VI_WPRODUCTBUILDER_F_TEMPLATES
				);
			}
		} else {
			if ( $data ) {
				$products = $data->posts;
				$max_page = $data->max_num_pages;
			}
			wc_get_template(
				'content-product-builder-single.php', array(
				'products' => $products,
				'max_page' => $max_page
			), '', VI_WPRODUCTBUILDER_F_TEMPLATES
			);
		}

	}

	/**
	 * Get Post Meta
	 *
	 * @param $field
	 *
	 * @return bool
	 */
	private function get_data( $post_id, $field, $default = '' ) {

		if ( isset( $this->data[ $post_id ] ) && $this->data[ $post_id ] ) {
			$params = $this->data[ $post_id ];
		} else {
			$this->data[ $post_id ] = get_post_meta( $post_id, 'woopb-param', true );
			$params                 = $this->data[ $post_id ];
		}

		if ( isset( $params[ $field ] ) && $field ) {
			return $params[ $field ];
		} else {
			return $default;
		}
	}
}