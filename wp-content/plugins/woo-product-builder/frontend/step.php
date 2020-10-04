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
		
   
     
<script>
jQuery( document ).ready(function() {
    alert( "ready!" );
});
</script>
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
	<div id="js-modal-popup"><div class="mask-popup active">
    <div class="close-pop-biuldpc" onclick="closePopup()" style="width: 100%;float: left;height: 100%;position: fixed;z-index: 1;"></div>
    <div class="popup-select" style="z-index: 99;">
        <div class="header">
            <h4>Chọn linh kiện</h4>
            <form action="">
                <input type="text" value="" id="buildpc-search-keyword" class="input-search" placeholder="Bạn cần tìm linh kiện gì?">
                <span class="btn-search"><i class="far fa-search" id="js-buildpc-search-btn"></i></span>
                <div class="icon-menu-filter-mobile"><i class="fal fa-filter"></i> Lọc</div>
            </form>

            <span class="close-popup" onclick="closePopup()"><i class="fal fa-times"></i></span>
        </div>
        <div class="popup-main">
            <div class="popup-main_filter w-30 float_l">
                <h4>Lọc sản phẩm theo</h4>
                <div class="list-filter">
                    <div class="gr-filter brand">
                        <!--
                      
                      
                      -->
                        <h5 class="title-filter">Hãng sản xuất <!--<span class="show-filter"><i class="fas fa-caret-right"></i></span>--></h5>
                        <ul>
                            
                            <li>
                                <input type="checkbox" onclick="objBuildPCVisual.showProductFilter('https://www.hanoicomputer.vn/ajax/get_json.php?action=pcbuilder&amp;action_type=get-product-category&amp;category_id=32&amp;pc_part_id=55008-30%2C54098-31&amp;brand=adata')">
                                <a href="javascript:void(0)" onclick="objBuildPCVisual.showProductFilter('https://www.hanoicomputer.vn/ajax/get_json.php?action=pcbuilder&amp;action_type=get-product-category&amp;category_id=32&amp;pc_part_id=55008-30%2C54098-31&amp;brand=adata')"><span class="value-filter">ADATA (26)</span></a>
                            </li>
                            
                        
                            <li>
                                <input type="checkbox" onclick="objBuildPCVisual.showProductFilter('https://www.hanoicomputer.vn/ajax/get_json.php?action=pcbuilder&amp;action_type=get-product-category&amp;category_id=32&amp;pc_part_id=55008-30%2C54098-31&amp;brand=antecmemory')">
                                <a href="javascript:void(0)" onclick="objBuildPCVisual.showProductFilter('https://www.hanoicomputer.vn/ajax/get_json.php?action=pcbuilder&amp;action_type=get-product-category&amp;category_id=32&amp;pc_part_id=55008-30%2C54098-31&amp;brand=antecmemory')"><span class="value-filter">ANTECMEMORY (15)</span></a>
                            </li>
                            
                        
                            <li>
                                <input type="checkbox" onclick="objBuildPCVisual.showProductFilter('https://www.hanoicomputer.vn/ajax/get_json.php?action=pcbuilder&amp;action_type=get-product-category&amp;category_id=32&amp;pc_part_id=55008-30%2C54098-31&amp;brand=avexir')">
                                <a href="javascript:void(0)" onclick="objBuildPCVisual.showProductFilter('https://www.hanoicomputer.vn/ajax/get_json.php?action=pcbuilder&amp;action_type=get-product-category&amp;category_id=32&amp;pc_part_id=55008-30%2C54098-31&amp;brand=avexir')"><span class="value-filter">AVEXIR (46)</span></a>
                            </li>
                            
                        
                            <li>
                                <input type="checkbox" onclick="objBuildPCVisual.showProductFilter('https://www.hanoicomputer.vn/ajax/get_json.php?action=pcbuilder&amp;action_type=get-product-category&amp;category_id=32&amp;pc_part_id=55008-30%2C54098-31&amp;brand=axpro')">
                                <a href="javascript:void(0)" onclick="objBuildPCVisual.showProductFilter('https://www.hanoicomputer.vn/ajax/get_json.php?action=pcbuilder&amp;action_type=get-product-category&amp;category_id=32&amp;pc_part_id=55008-30%2C54098-31&amp;brand=axpro')"><span class="value-filter">AXPRO (7)</span></a>
                            </li>
                            
                        
                            <li>
                                <input type="checkbox" onclick="objBuildPCVisual.showProductFilter('https://www.hanoicomputer.vn/ajax/get_json.php?action=pcbuilder&amp;action_type=get-product-category&amp;category_id=32&amp;pc_part_id=55008-30%2C54098-31&amp;brand=corsair')">
                                <a href="javascript:void(0)" onclick="objBuildPCVisual.showProductFilter('https://www.hanoicomputer.vn/ajax/get_json.php?action=pcbuilder&amp;action_type=get-product-category&amp;category_id=32&amp;pc_part_id=55008-30%2C54098-31&amp;brand=corsair')"><span class="value-filter">CORSAIR (23)</span></a>
                            </li>
                            
                        
                            <li>
                                <input type="checkbox" onclick="objBuildPCVisual.showProductFilter('https://www.hanoicomputer.vn/ajax/get_json.php?action=pcbuilder&amp;action_type=get-product-category&amp;category_id=32&amp;pc_part_id=55008-30%2C54098-31&amp;brand=gadmei')">
                                <a href="javascript:void(0)" onclick="objBuildPCVisual.showProductFilter('https://www.hanoicomputer.vn/ajax/get_json.php?action=pcbuilder&amp;action_type=get-product-category&amp;category_id=32&amp;pc_part_id=55008-30%2C54098-31&amp;brand=gadmei')"><span class="value-filter">GADMEI (1)</span></a>
                            </li>
                            
                        
                            <li>
                                <input type="checkbox" onclick="objBuildPCVisual.showProductFilter('https://www.hanoicomputer.vn/ajax/get_json.php?action=pcbuilder&amp;action_type=get-product-category&amp;category_id=32&amp;pc_part_id=55008-30%2C54098-31&amp;brand=gigabyte')">
                                <a href="javascript:void(0)" onclick="objBuildPCVisual.showProductFilter('https://www.hanoicomputer.vn/ajax/get_json.php?action=pcbuilder&amp;action_type=get-product-category&amp;category_id=32&amp;pc_part_id=55008-30%2C54098-31&amp;brand=gigabyte')"><span class="value-filter">GIGABYTE (3)</span></a>
                            </li>
                            </ul><ul>
                        
                            <li>
                                <input type="checkbox" onclick="objBuildPCVisual.showProductFilter('https://www.hanoicomputer.vn/ajax/get_json.php?action=pcbuilder&amp;action_type=get-product-category&amp;category_id=32&amp;pc_part_id=55008-30%2C54098-31&amp;brand=gskill')">
                                <a href="javascript:void(0)" onclick="objBuildPCVisual.showProductFilter('https://www.hanoicomputer.vn/ajax/get_json.php?action=pcbuilder&amp;action_type=get-product-category&amp;category_id=32&amp;pc_part_id=55008-30%2C54098-31&amp;brand=gskill')"><span class="value-filter">GSKILL (24)</span></a>
                            </li>
                            
                        
                            <li>
                                <input type="checkbox" onclick="objBuildPCVisual.showProductFilter('https://www.hanoicomputer.vn/ajax/get_json.php?action=pcbuilder&amp;action_type=get-product-category&amp;category_id=32&amp;pc_part_id=55008-30%2C54098-31&amp;brand=hp')">
                                <a href="javascript:void(0)" onclick="objBuildPCVisual.showProductFilter('https://www.hanoicomputer.vn/ajax/get_json.php?action=pcbuilder&amp;action_type=get-product-category&amp;category_id=32&amp;pc_part_id=55008-30%2C54098-31&amp;brand=hp')"><span class="value-filter">HP (5)</span></a>
                            </li>
                            
                        
                            <li>
                                <input type="checkbox" onclick="objBuildPCVisual.showProductFilter('https://www.hanoicomputer.vn/ajax/get_json.php?action=pcbuilder&amp;action_type=get-product-category&amp;category_id=32&amp;pc_part_id=55008-30%2C54098-31&amp;brand=kingmax')">
                                <a href="javascript:void(0)" onclick="objBuildPCVisual.showProductFilter('https://www.hanoicomputer.vn/ajax/get_json.php?action=pcbuilder&amp;action_type=get-product-category&amp;category_id=32&amp;pc_part_id=55008-30%2C54098-31&amp;brand=kingmax')"><span class="value-filter">KINGMAX (7)</span></a>
                            </li>
                            
                        
                            <li>
                                <input type="checkbox" onclick="objBuildPCVisual.showProductFilter('https://www.hanoicomputer.vn/ajax/get_json.php?action=pcbuilder&amp;action_type=get-product-category&amp;category_id=32&amp;pc_part_id=55008-30%2C54098-31&amp;brand=kingston')">
                                <a href="javascript:void(0)" onclick="objBuildPCVisual.showProductFilter('https://www.hanoicomputer.vn/ajax/get_json.php?action=pcbuilder&amp;action_type=get-product-category&amp;category_id=32&amp;pc_part_id=55008-30%2C54098-31&amp;brand=kingston')"><span class="value-filter">KINGSTON (30)</span></a>
                            </li>
                            
                        
                            <li>
                                <input type="checkbox" onclick="objBuildPCVisual.showProductFilter('https://www.hanoicomputer.vn/ajax/get_json.php?action=pcbuilder&amp;action_type=get-product-category&amp;category_id=32&amp;pc_part_id=55008-30%2C54098-31&amp;brand=micron')">
                                <a href="javascript:void(0)" onclick="objBuildPCVisual.showProductFilter('https://www.hanoicomputer.vn/ajax/get_json.php?action=pcbuilder&amp;action_type=get-product-category&amp;category_id=32&amp;pc_part_id=55008-30%2C54098-31&amp;brand=micron')"><span class="value-filter">MICRON (2)</span></a>
                            </li>
                            
                        
                            <li>
                                <input type="checkbox" onclick="objBuildPCVisual.showProductFilter('https://www.hanoicomputer.vn/ajax/get_json.php?action=pcbuilder&amp;action_type=get-product-category&amp;category_id=32&amp;pc_part_id=55008-30%2C54098-31&amp;brand=siliconpower')">
                                <a href="javascript:void(0)" onclick="objBuildPCVisual.showProductFilter('https://www.hanoicomputer.vn/ajax/get_json.php?action=pcbuilder&amp;action_type=get-product-category&amp;category_id=32&amp;pc_part_id=55008-30%2C54098-31&amp;brand=siliconpower')"><span class="value-filter">SILICONPOWER (6)</span></a>
                            </li>
                            
                        
                            <li>
                                <input type="checkbox" onclick="objBuildPCVisual.showProductFilter('https://www.hanoicomputer.vn/ajax/get_json.php?action=pcbuilder&amp;action_type=get-product-category&amp;category_id=32&amp;pc_part_id=55008-30%2C54098-31&amp;brand=team')">
                                <a href="javascript:void(0)" onclick="objBuildPCVisual.showProductFilter('https://www.hanoicomputer.vn/ajax/get_json.php?action=pcbuilder&amp;action_type=get-product-category&amp;category_id=32&amp;pc_part_id=55008-30%2C54098-31&amp;brand=team')"><span class="value-filter">TEAM (4)</span></a>
                            </li>
                            
                        
                    </ul>
                    </div>
                    <div class="gr-filter">
                        <h5 class="title-filter">Khoảng giá <!--<span class="show-filter"><i class="fas fa-caret-right"></i></span>--></h5>
                        <!-- -->
                        <ul>
                            
                            <li>
                                <input type="checkbox" onclick="objBuildPCVisual.showProductFilter('https://www.hanoicomputer.vn/ajax/get_json.php?action=pcbuilder&amp;action_type=get-product-category&amp;category_id=32&amp;pc_part_id=55008-30%2C54098-31&amp;p=duoi-2trieu')">
                                <a href="javascript:void(0)" onclick="objBuildPCVisual.showProductFilter('https://www.hanoicomputer.vn/ajax/get_json.php?action=pcbuilder&amp;action_type=get-product-category&amp;category_id=32&amp;pc_part_id=55008-30%2C54098-31&amp;p=duoi-2trieu')"><span class="value-filter">Dưới 2 triệu</span> </a> (121)
                            </li>
                            
                        
                            <li>
                                <input type="checkbox" onclick="objBuildPCVisual.showProductFilter('https://www.hanoicomputer.vn/ajax/get_json.php?action=pcbuilder&amp;action_type=get-product-category&amp;category_id=32&amp;pc_part_id=55008-30%2C54098-31&amp;p=2trieu-4trieu')">
                                <a href="javascript:void(0)" onclick="objBuildPCVisual.showProductFilter('https://www.hanoicomputer.vn/ajax/get_json.php?action=pcbuilder&amp;action_type=get-product-category&amp;category_id=32&amp;pc_part_id=55008-30%2C54098-31&amp;p=2trieu-4trieu')"><span class="value-filter">2 triệu - 4 triệu</span> </a> (55)
                            </li>
                            </ul><ul>
                        
                            <li>
                                <input type="checkbox" onclick="objBuildPCVisual.showProductFilter('https://www.hanoicomputer.vn/ajax/get_json.php?action=pcbuilder&amp;action_type=get-product-category&amp;category_id=32&amp;pc_part_id=55008-30%2C54098-31&amp;p=4trieu-8trieu')">
                                <a href="javascript:void(0)" onclick="objBuildPCVisual.showProductFilter('https://www.hanoicomputer.vn/ajax/get_json.php?action=pcbuilder&amp;action_type=get-product-category&amp;category_id=32&amp;pc_part_id=55008-30%2C54098-31&amp;p=4trieu-8trieu')"><span class="value-filter">4 triệu - 8 triệu</span> </a> (20)
                            </li>
                            
                        
                            <li>
                                <input type="checkbox" onclick="objBuildPCVisual.showProductFilter('https://www.hanoicomputer.vn/ajax/get_json.php?action=pcbuilder&amp;action_type=get-product-category&amp;category_id=32&amp;pc_part_id=55008-30%2C54098-31&amp;p=tren-8trieu')">
                                <a href="javascript:void(0)" onclick="objBuildPCVisual.showProductFilter('https://www.hanoicomputer.vn/ajax/get_json.php?action=pcbuilder&amp;action_type=get-product-category&amp;category_id=32&amp;pc_part_id=55008-30%2C54098-31&amp;p=tren-8trieu')"><span class="value-filter">Trên 8 triệu</span> </a> (3)
                            </li>
                            
                        
                    </ul>
                    </div>

                    
                    <div class="gr-filter">
                        <h5 class="title-filter">Loại RAM <!--<span class="show-filter"><i class="fas fa-caret-right"></i></span>--></h5>
                        <!-- -->
                        <ul>
                            
                            <li>
                                <input type="checkbox" onclick="objBuildPCVisual.showProductFilter('https://www.hanoicomputer.vn/ajax/get_json.php?action=pcbuilder&amp;action_type=get-product-category&amp;category_id=32&amp;pc_part_id=55008-30%2C54098-31&amp;loai-ram-desktop=ddr3-1')">
                                <a href="javascript:void(0)" onclick="objBuildPCVisual.showProductFilter('https://www.hanoicomputer.vn/ajax/get_json.php?action=pcbuilder&amp;action_type=get-product-category&amp;category_id=32&amp;pc_part_id=55008-30%2C54098-31&amp;loai-ram-desktop=ddr3-1')"><span class="value-filter">DDR3 (19)</span> </a>
                            </li>
                            </ul><ul>
                        
                            <li>
                                <input type="checkbox" onclick="objBuildPCVisual.showProductFilter('https://www.hanoicomputer.vn/ajax/get_json.php?action=pcbuilder&amp;action_type=get-product-category&amp;category_id=32&amp;pc_part_id=55008-30%2C54098-31&amp;loai-ram-desktop=ddr4-1')">
                                <a href="javascript:void(0)" onclick="objBuildPCVisual.showProductFilter('https://www.hanoicomputer.vn/ajax/get_json.php?action=pcbuilder&amp;action_type=get-product-category&amp;category_id=32&amp;pc_part_id=55008-30%2C54098-31&amp;loai-ram-desktop=ddr4-1')"><span class="value-filter">DDR4 (169)</span> </a>
                            </li>
                            
                        
                    </ul>
                    </div>
                    
                    <div class="gr-filter">
                        <h5 class="title-filter">Dung Lượng <!--<span class="show-filter"><i class="fas fa-caret-right"></i></span>--></h5>
                        <!-- -->
                        <ul>
                            
                            <li>
                                <input type="checkbox" onclick="objBuildPCVisual.showProductFilter('https://www.hanoicomputer.vn/ajax/get_json.php?action=pcbuilder&amp;action_type=get-product-category&amp;category_id=32&amp;pc_part_id=55008-30%2C54098-31&amp;dl-ram-desktop=2gb-1-1')">
                                <a href="javascript:void(0)" onclick="objBuildPCVisual.showProductFilter('https://www.hanoicomputer.vn/ajax/get_json.php?action=pcbuilder&amp;action_type=get-product-category&amp;category_id=32&amp;pc_part_id=55008-30%2C54098-31&amp;dl-ram-desktop=2gb-1-1')"><span class="value-filter">2GB (1)</span> </a>
                            </li>
                            
                        
                            <li>
                                <input type="checkbox" onclick="objBuildPCVisual.showProductFilter('https://www.hanoicomputer.vn/ajax/get_json.php?action=pcbuilder&amp;action_type=get-product-category&amp;category_id=32&amp;pc_part_id=55008-30%2C54098-31&amp;dl-ram-desktop=4gb-1-1-1-1')">
                                <a href="javascript:void(0)" onclick="objBuildPCVisual.showProductFilter('https://www.hanoicomputer.vn/ajax/get_json.php?action=pcbuilder&amp;action_type=get-product-category&amp;category_id=32&amp;pc_part_id=55008-30%2C54098-31&amp;dl-ram-desktop=4gb-1-1-1-1')"><span class="value-filter">4GB (22)</span> </a>
                            </li>
                            
                        
                            <li>
                                <input type="checkbox" onclick="objBuildPCVisual.showProductFilter('https://www.hanoicomputer.vn/ajax/get_json.php?action=pcbuilder&amp;action_type=get-product-category&amp;category_id=32&amp;pc_part_id=55008-30%2C54098-31&amp;dl-ram-desktop=8gb-1-x-8gb')">
                                <a href="javascript:void(0)" onclick="objBuildPCVisual.showProductFilter('https://www.hanoicomputer.vn/ajax/get_json.php?action=pcbuilder&amp;action_type=get-product-category&amp;category_id=32&amp;pc_part_id=55008-30%2C54098-31&amp;dl-ram-desktop=8gb-1-x-8gb')"><span class="value-filter">8GB (1 x 8GB) (69)</span> </a>
                            </li>
                            
                        
                            <li>
                                <input type="checkbox" onclick="objBuildPCVisual.showProductFilter('https://www.hanoicomputer.vn/ajax/get_json.php?action=pcbuilder&amp;action_type=get-product-category&amp;category_id=32&amp;pc_part_id=55008-30%2C54098-31&amp;dl-ram-desktop=8gb-2-x-4gb')">
                                <a href="javascript:void(0)" onclick="objBuildPCVisual.showProductFilter('https://www.hanoicomputer.vn/ajax/get_json.php?action=pcbuilder&amp;action_type=get-product-category&amp;category_id=32&amp;pc_part_id=55008-30%2C54098-31&amp;dl-ram-desktop=8gb-2-x-4gb')"><span class="value-filter">8GB (2 x 4GB) (1)</span> </a>
                            </li>
                            
                        
                            <li>
                                <input type="checkbox" onclick="objBuildPCVisual.showProductFilter('https://www.hanoicomputer.vn/ajax/get_json.php?action=pcbuilder&amp;action_type=get-product-category&amp;category_id=32&amp;pc_part_id=55008-30%2C54098-31&amp;dl-ram-desktop=16gb-1-x-16gb')">
                                <a href="javascript:void(0)" onclick="objBuildPCVisual.showProductFilter('https://www.hanoicomputer.vn/ajax/get_json.php?action=pcbuilder&amp;action_type=get-product-category&amp;category_id=32&amp;pc_part_id=55008-30%2C54098-31&amp;dl-ram-desktop=16gb-1-x-16gb')"><span class="value-filter">16GB (1 x 16GB) (33)</span> </a>
                            </li>
                            
                        
                            <li>
                                <input type="checkbox" onclick="objBuildPCVisual.showProductFilter('https://www.hanoicomputer.vn/ajax/get_json.php?action=pcbuilder&amp;action_type=get-product-category&amp;category_id=32&amp;pc_part_id=55008-30%2C54098-31&amp;dl-ram-desktop=16gb-2-x-8gb')">
                                <a href="javascript:void(0)" onclick="objBuildPCVisual.showProductFilter('https://www.hanoicomputer.vn/ajax/get_json.php?action=pcbuilder&amp;action_type=get-product-category&amp;category_id=32&amp;pc_part_id=55008-30%2C54098-31&amp;dl-ram-desktop=16gb-2-x-8gb')"><span class="value-filter">16GB (2 x 8GB) (40)</span> </a>
                            </li>
                            </ul><ul>
                        
                            <li>
                                <input type="checkbox" onclick="objBuildPCVisual.showProductFilter('https://www.hanoicomputer.vn/ajax/get_json.php?action=pcbuilder&amp;action_type=get-product-category&amp;category_id=32&amp;pc_part_id=55008-30%2C54098-31&amp;dl-ram-desktop=16gb-4-x-4gb')">
                                <a href="javascript:void(0)" onclick="objBuildPCVisual.showProductFilter('https://www.hanoicomputer.vn/ajax/get_json.php?action=pcbuilder&amp;action_type=get-product-category&amp;category_id=32&amp;pc_part_id=55008-30%2C54098-31&amp;dl-ram-desktop=16gb-4-x-4gb')"><span class="value-filter">16GB (4 x 4GB) (2)</span> </a>
                            </li>
                            
                        
                            <li>
                                <input type="checkbox" onclick="objBuildPCVisual.showProductFilter('https://www.hanoicomputer.vn/ajax/get_json.php?action=pcbuilder&amp;action_type=get-product-category&amp;category_id=32&amp;pc_part_id=55008-30%2C54098-31&amp;dl-ram-desktop=32gb-1-x-32gb')">
                                <a href="javascript:void(0)" onclick="objBuildPCVisual.showProductFilter('https://www.hanoicomputer.vn/ajax/get_json.php?action=pcbuilder&amp;action_type=get-product-category&amp;category_id=32&amp;pc_part_id=55008-30%2C54098-31&amp;dl-ram-desktop=32gb-1-x-32gb')"><span class="value-filter">32GB (1 x 32GB) (2)</span> </a>
                            </li>
                            
                        
                            <li>
                                <input type="checkbox" onclick="objBuildPCVisual.showProductFilter('https://www.hanoicomputer.vn/ajax/get_json.php?action=pcbuilder&amp;action_type=get-product-category&amp;category_id=32&amp;pc_part_id=55008-30%2C54098-31&amp;dl-ram-desktop=32gb-2-x-16gb')">
                                <a href="javascript:void(0)" onclick="objBuildPCVisual.showProductFilter('https://www.hanoicomputer.vn/ajax/get_json.php?action=pcbuilder&amp;action_type=get-product-category&amp;category_id=32&amp;pc_part_id=55008-30%2C54098-31&amp;dl-ram-desktop=32gb-2-x-16gb')"><span class="value-filter">32GB (2 x 16GB) (15)</span> </a>
                            </li>
                            
                        
                            <li>
                                <input type="checkbox" onclick="objBuildPCVisual.showProductFilter('https://www.hanoicomputer.vn/ajax/get_json.php?action=pcbuilder&amp;action_type=get-product-category&amp;category_id=32&amp;pc_part_id=55008-30%2C54098-31&amp;dl-ram-desktop=32gb-4-x-8gb')">
                                <a href="javascript:void(0)" onclick="objBuildPCVisual.showProductFilter('https://www.hanoicomputer.vn/ajax/get_json.php?action=pcbuilder&amp;action_type=get-product-category&amp;category_id=32&amp;pc_part_id=55008-30%2C54098-31&amp;dl-ram-desktop=32gb-4-x-8gb')"><span class="value-filter">32GB (4 x 8GB) (1)</span> </a>
                            </li>
                            
                        
                            <li>
                                <input type="checkbox" onclick="objBuildPCVisual.showProductFilter('https://www.hanoicomputer.vn/ajax/get_json.php?action=pcbuilder&amp;action_type=get-product-category&amp;category_id=32&amp;pc_part_id=55008-30%2C54098-31&amp;dl-ram-desktop=64gb-1-x-64gb')">
                                <a href="javascript:void(0)" onclick="objBuildPCVisual.showProductFilter('https://www.hanoicomputer.vn/ajax/get_json.php?action=pcbuilder&amp;action_type=get-product-category&amp;category_id=32&amp;pc_part_id=55008-30%2C54098-31&amp;dl-ram-desktop=64gb-1-x-64gb')"><span class="value-filter">64GB (1 x 64GB) (1)</span> </a>
                            </li>
                            
                        
                            <li>
                                <input type="checkbox" onclick="objBuildPCVisual.showProductFilter('https://www.hanoicomputer.vn/ajax/get_json.php?action=pcbuilder&amp;action_type=get-product-category&amp;category_id=32&amp;pc_part_id=55008-30%2C54098-31&amp;dl-ram-desktop=64gb-2-x-32gb')">
                                <a href="javascript:void(0)" onclick="objBuildPCVisual.showProductFilter('https://www.hanoicomputer.vn/ajax/get_json.php?action=pcbuilder&amp;action_type=get-product-category&amp;category_id=32&amp;pc_part_id=55008-30%2C54098-31&amp;dl-ram-desktop=64gb-2-x-32gb')"><span class="value-filter">64GB (2 x 32GB) (3)</span> </a>
                            </li>
                            
                        
                    </ul>
                    </div>
                    
                    <div class="gr-filter">
                        <h5 class="title-filter">BUS RAM <!--<span class="show-filter"><i class="fas fa-caret-right"></i></span>--></h5>
                        <!-- -->
                        <ul>
                            
                            <li>
                                <input type="checkbox" onclick="objBuildPCVisual.showProductFilter('https://www.hanoicomputer.vn/ajax/get_json.php?action=pcbuilder&amp;action_type=get-product-category&amp;category_id=32&amp;pc_part_id=55008-30%2C54098-31&amp;bus-ram-desktop=ddr3-1333-mhz')">
                                <a href="javascript:void(0)" onclick="objBuildPCVisual.showProductFilter('https://www.hanoicomputer.vn/ajax/get_json.php?action=pcbuilder&amp;action_type=get-product-category&amp;category_id=32&amp;pc_part_id=55008-30%2C54098-31&amp;bus-ram-desktop=ddr3-1333-mhz')"><span class="value-filter">DDR3 1333 MHz (1)</span> </a>
                            </li>
                            
                        
                            <li>
                                <input type="checkbox" onclick="objBuildPCVisual.showProductFilter('https://www.hanoicomputer.vn/ajax/get_json.php?action=pcbuilder&amp;action_type=get-product-category&amp;category_id=32&amp;pc_part_id=55008-30%2C54098-31&amp;bus-ram-desktop=ddr3-1600-mhz')">
                                <a href="javascript:void(0)" onclick="objBuildPCVisual.showProductFilter('https://www.hanoicomputer.vn/ajax/get_json.php?action=pcbuilder&amp;action_type=get-product-category&amp;category_id=32&amp;pc_part_id=55008-30%2C54098-31&amp;bus-ram-desktop=ddr3-1600-mhz')"><span class="value-filter">DDR3 1600 MHz (19)</span> </a>
                            </li>
                            
                        
                            <li>
                                <input type="checkbox" onclick="objBuildPCVisual.showProductFilter('https://www.hanoicomputer.vn/ajax/get_json.php?action=pcbuilder&amp;action_type=get-product-category&amp;category_id=32&amp;pc_part_id=55008-30%2C54098-31&amp;bus-ram-desktop=ddr4-2133-mhz')">
                                <a href="javascript:void(0)" onclick="objBuildPCVisual.showProductFilter('https://www.hanoicomputer.vn/ajax/get_json.php?action=pcbuilder&amp;action_type=get-product-category&amp;category_id=32&amp;pc_part_id=55008-30%2C54098-31&amp;bus-ram-desktop=ddr4-2133-mhz')"><span class="value-filter">DDR4 2133 MHz (5)</span> </a>
                            </li>
                            
                        
                            <li>
                                <input type="checkbox" onclick="objBuildPCVisual.showProductFilter('https://www.hanoicomputer.vn/ajax/get_json.php?action=pcbuilder&amp;action_type=get-product-category&amp;category_id=32&amp;pc_part_id=55008-30%2C54098-31&amp;bus-ram-desktop=ddr4-2400-mhz')">
                                <a href="javascript:void(0)" onclick="objBuildPCVisual.showProductFilter('https://www.hanoicomputer.vn/ajax/get_json.php?action=pcbuilder&amp;action_type=get-product-category&amp;category_id=32&amp;pc_part_id=55008-30%2C54098-31&amp;bus-ram-desktop=ddr4-2400-mhz')"><span class="value-filter">DDR4 2400 MHz (34)</span> </a>
                            </li>
                            
                        
                            <li>
                                <input type="checkbox" onclick="objBuildPCVisual.showProductFilter('https://www.hanoicomputer.vn/ajax/get_json.php?action=pcbuilder&amp;action_type=get-product-category&amp;category_id=32&amp;pc_part_id=55008-30%2C54098-31&amp;bus-ram-desktop=ddr4-2666-mhz')">
                                <a href="javascript:void(0)" onclick="objBuildPCVisual.showProductFilter('https://www.hanoicomputer.vn/ajax/get_json.php?action=pcbuilder&amp;action_type=get-product-category&amp;category_id=32&amp;pc_part_id=55008-30%2C54098-31&amp;bus-ram-desktop=ddr4-2666-mhz')"><span class="value-filter">DDR4 2666 MHz (53)</span> </a>
                            </li>
                            </ul><ul>
                        
                            <li>
                                <input type="checkbox" onclick="objBuildPCVisual.showProductFilter('https://www.hanoicomputer.vn/ajax/get_json.php?action=pcbuilder&amp;action_type=get-product-category&amp;category_id=32&amp;pc_part_id=55008-30%2C54098-31&amp;bus-ram-desktop=ddr4-2800-mhz')">
                                <a href="javascript:void(0)" onclick="objBuildPCVisual.showProductFilter('https://www.hanoicomputer.vn/ajax/get_json.php?action=pcbuilder&amp;action_type=get-product-category&amp;category_id=32&amp;pc_part_id=55008-30%2C54098-31&amp;bus-ram-desktop=ddr4-2800-mhz')"><span class="value-filter">DDR4 2800 MHz (1)</span> </a>
                            </li>
                            
                        
                            <li>
                                <input type="checkbox" onclick="objBuildPCVisual.showProductFilter('https://www.hanoicomputer.vn/ajax/get_json.php?action=pcbuilder&amp;action_type=get-product-category&amp;category_id=32&amp;pc_part_id=55008-30%2C54098-31&amp;bus-ram-desktop=ddr4-3000-mhz')">
                                <a href="javascript:void(0)" onclick="objBuildPCVisual.showProductFilter('https://www.hanoicomputer.vn/ajax/get_json.php?action=pcbuilder&amp;action_type=get-product-category&amp;category_id=32&amp;pc_part_id=55008-30%2C54098-31&amp;bus-ram-desktop=ddr4-3000-mhz')"><span class="value-filter">DDR4 3000 MHz (37)</span> </a>
                            </li>
                            
                        
                            <li>
                                <input type="checkbox" onclick="objBuildPCVisual.showProductFilter('https://www.hanoicomputer.vn/ajax/get_json.php?action=pcbuilder&amp;action_type=get-product-category&amp;category_id=32&amp;pc_part_id=55008-30%2C54098-31&amp;bus-ram-desktop=ddr4-3200-mhz')">
                                <a href="javascript:void(0)" onclick="objBuildPCVisual.showProductFilter('https://www.hanoicomputer.vn/ajax/get_json.php?action=pcbuilder&amp;action_type=get-product-category&amp;category_id=32&amp;pc_part_id=55008-30%2C54098-31&amp;bus-ram-desktop=ddr4-3200-mhz')"><span class="value-filter">DDR4 3200 MHz (26)</span> </a>
                            </li>
                            
                        
                            <li>
                                <input type="checkbox" onclick="objBuildPCVisual.showProductFilter('https://www.hanoicomputer.vn/ajax/get_json.php?action=pcbuilder&amp;action_type=get-product-category&amp;category_id=32&amp;pc_part_id=55008-30%2C54098-31&amp;bus-ram-desktop=ddr4-3600-mhz')">
                                <a href="javascript:void(0)" onclick="objBuildPCVisual.showProductFilter('https://www.hanoicomputer.vn/ajax/get_json.php?action=pcbuilder&amp;action_type=get-product-category&amp;category_id=32&amp;pc_part_id=55008-30%2C54098-31&amp;bus-ram-desktop=ddr4-3600-mhz')"><span class="value-filter">DDR4 3600 MHz (12)</span> </a>
                            </li>
                            
                        
                            <li>
                                <input type="checkbox" onclick="objBuildPCVisual.showProductFilter('https://www.hanoicomputer.vn/ajax/get_json.php?action=pcbuilder&amp;action_type=get-product-category&amp;category_id=32&amp;pc_part_id=55008-30%2C54098-31&amp;bus-ram-desktop=ddr4-4000-mhz')">
                                <a href="javascript:void(0)" onclick="objBuildPCVisual.showProductFilter('https://www.hanoicomputer.vn/ajax/get_json.php?action=pcbuilder&amp;action_type=get-product-category&amp;category_id=32&amp;pc_part_id=55008-30%2C54098-31&amp;bus-ram-desktop=ddr4-4000-mhz')"><span class="value-filter">DDR4 4000 MHz (2)</span> </a>
                            </li>
                            
                        
                    </ul>
                    </div>
                    
                    <div class="gr-filter">
                        <h5 class="title-filter">Tự Sửa Lỗi <!--<span class="show-filter"><i class="fas fa-caret-right"></i></span>--></h5>
                        <!-- -->
                        <ul>
                            
                            <li>
                                <input type="checkbox" onclick="objBuildPCVisual.showProductFilter('https://www.hanoicomputer.vn/ajax/get_json.php?action=pcbuilder&amp;action_type=get-product-category&amp;category_id=32&amp;pc_part_id=55008-30%2C54098-31&amp;ecc-ram-desktop=ram-ecc')">
                                <a href="javascript:void(0)" onclick="objBuildPCVisual.showProductFilter('https://www.hanoicomputer.vn/ajax/get_json.php?action=pcbuilder&amp;action_type=get-product-category&amp;category_id=32&amp;pc_part_id=55008-30%2C54098-31&amp;ecc-ram-desktop=ram-ecc')"><span class="value-filter">RAM ECC (17)</span> </a>
                            </li>
                            </ul><ul>
                        
                            <li>
                                <input type="checkbox" onclick="objBuildPCVisual.showProductFilter('https://www.hanoicomputer.vn/ajax/get_json.php?action=pcbuilder&amp;action_type=get-product-category&amp;category_id=32&amp;pc_part_id=55008-30%2C54098-31&amp;ecc-ram-desktop=ram-non-ecc')">
                                <a href="javascript:void(0)" onclick="objBuildPCVisual.showProductFilter('https://www.hanoicomputer.vn/ajax/get_json.php?action=pcbuilder&amp;action_type=get-product-category&amp;category_id=32&amp;pc_part_id=55008-30%2C54098-31&amp;ecc-ram-desktop=ram-non-ecc')"><span class="value-filter">RAM Non-ECC (174)</span> </a>
                            </li>
                            
                        
                    </ul>
                    </div>
                    
                    <div class="gr-filter">
                        <h5 class="title-filter">Đèn LED <!--<span class="show-filter"><i class="fas fa-caret-right"></i></span>--></h5>
                        <!-- -->
                        <ul>
                            
                            <li>
                                <input type="checkbox" onclick="objBuildPCVisual.showProductFilter('https://www.hanoicomputer.vn/ajax/get_json.php?action=pcbuilder&amp;action_type=get-product-category&amp;category_id=32&amp;pc_part_id=55008-30%2C54098-31&amp;led-ram-desktop=co-led')">
                                <a href="javascript:void(0)" onclick="objBuildPCVisual.showProductFilter('https://www.hanoicomputer.vn/ajax/get_json.php?action=pcbuilder&amp;action_type=get-product-category&amp;category_id=32&amp;pc_part_id=55008-30%2C54098-31&amp;led-ram-desktop=co-led')"><span class="value-filter">Có LED (105)</span> </a>
                            </li>
                            </ul><ul>
                        
                            <li>
                                <input type="checkbox" onclick="objBuildPCVisual.showProductFilter('https://www.hanoicomputer.vn/ajax/get_json.php?action=pcbuilder&amp;action_type=get-product-category&amp;category_id=32&amp;pc_part_id=55008-30%2C54098-31&amp;led-ram-desktop=khong-co-led')">
                                <a href="javascript:void(0)" onclick="objBuildPCVisual.showProductFilter('https://www.hanoicomputer.vn/ajax/get_json.php?action=pcbuilder&amp;action_type=get-product-category&amp;category_id=32&amp;pc_part_id=55008-30%2C54098-31&amp;led-ram-desktop=khong-co-led')"><span class="value-filter">Không Có LED (85)</span> </a>
                            </li>
                            
                        
                    </ul>
                    </div>
                    
                </div><!--list-filter-->
            </div><!--popup-main_filter-->
            <div class="popup-main_content w-70 float_r">
                <div class="sort-paging clear">
                    <div class="sort-block float_l">
                        <span>Sắp xếp: </span>
                        <select onchange="if(this.value != '') { objBuildPCVisual.showProductFilter(this.value) }">
                            <option value="">Tùy chọn</option>
                            
                            <option value="https://www.hanoicomputer.vn/ajax/get_json.php?action=pcbuilder&amp;action_type=get-product-category&amp;category_id=32&amp;pc_part_id=55008-30%2C54098-31&amp;sort=new">Mới nhất</option>
                            
                            <option value="https://www.hanoicomputer.vn/ajax/get_json.php?action=pcbuilder&amp;action_type=get-product-category&amp;category_id=32&amp;pc_part_id=55008-30%2C54098-31&amp;sort=price-asc">Giá tăng dần</option>
                            
                            <option value="https://www.hanoicomputer.vn/ajax/get_json.php?action=pcbuilder&amp;action_type=get-product-category&amp;category_id=32&amp;pc_part_id=55008-30%2C54098-31&amp;sort=price-desc">Giá giảm dần</option>
                            
                            <option value="https://www.hanoicomputer.vn/ajax/get_json.php?action=pcbuilder&amp;action_type=get-product-category&amp;category_id=32&amp;pc_part_id=55008-30%2C54098-31&amp;sort=view">Lượt xem</option>
                            
                            <option value="https://www.hanoicomputer.vn/ajax/get_json.php?action=pcbuilder&amp;action_type=get-product-category&amp;category_id=32&amp;pc_part_id=55008-30%2C54098-31&amp;sort=rating">Đánh giá</option>
                            
                            <option value="https://www.hanoicomputer.vn/ajax/get_json.php?action=pcbuilder&amp;action_type=get-product-category&amp;category_id=32&amp;pc_part_id=55008-30%2C54098-31&amp;sort=name">Tên A-&gt;Z</option>
                            
                        </select>
                    </div>

                    <div class="ttkh-block sort-block float_l" style="margin-left: 5px;">
                        <span>Kho hàng: </span>
                        <select id="other_filter" onchange="if(this.value != '') { objBuildPCVisual.showProductFilter(this.value) } else { objBuildPCVisual.showAllProductFilter(SEARCH_URL) } " class="list-sort">
                            <option value="" id="default-store" data-info="32" data-part-id="55008-30,54098-31">Tất cả</option>
                            
                            <option value="https://www.hanoicomputer.vn/ajax/get_json.php?action=pcbuilder&amp;action_type=get-product-category&amp;category_id=32&amp;pc_part_id=55008-30%2C54098-31&amp;storeId=ton101">01/ 131 Lê Thanh Nghị - Hai Bà Trưng - Hà Nội</option>
                            
                            <option value="https://www.hanoicomputer.vn/ajax/get_json.php?action=pcbuilder&amp;action_type=get-product-category&amp;category_id=32&amp;pc_part_id=55008-30%2C54098-31&amp;storeId=ton102">02/ 43 Thái Hà - Đống Đa - Hà Nội</option>
                            
                            <option value="https://www.hanoicomputer.vn/ajax/get_json.php?action=pcbuilder&amp;action_type=get-product-category&amp;category_id=32&amp;pc_part_id=55008-30%2C54098-31&amp;storeId=ton103">03/ A1-6 Lô 8A - Lê Hồng Phong - Hải Phòng</option>
                            
                            <option value="https://www.hanoicomputer.vn/ajax/get_json.php?action=pcbuilder&amp;action_type=get-product-category&amp;category_id=32&amp;pc_part_id=55008-30%2C54098-31&amp;storeId=ton104">04/ 57 Nguyễn Văn Huyên - Cầu Giấy - Hà Nội</option>
                            
                            <option value="https://www.hanoicomputer.vn/ajax/get_json.php?action=pcbuilder&amp;action_type=get-product-category&amp;category_id=32&amp;pc_part_id=55008-30%2C54098-31&amp;storeId=ton105">05/ 511 Quang Trung - Hà Đông - Hà Nội</option>
                            
                            <option value="https://www.hanoicomputer.vn/ajax/get_json.php?action=pcbuilder&amp;action_type=get-product-category&amp;category_id=32&amp;pc_part_id=55008-30%2C54098-31&amp;storeId=ton106">06/ 520 Cách Mạng Tháng 8 - Q3 - TP HCM</option>
                            
                            <option value="https://www.hanoicomputer.vn/ajax/get_json.php?action=pcbuilder&amp;action_type=get-product-category&amp;category_id=32&amp;pc_part_id=55008-30%2C54098-31&amp;storeId=ton107">07/ 398 Nguyễn Văn Cừ - Long Biên - Hà Nội</option>
                            
                        </select>
                    </div>
                    <div class="paging-block float_r paging-ajax">
                        <table cellpadding="0" cellspacing="0"><tbody><tr><td class="pagingIntact"><a>Xem</a></td><td class="pagingSpace"></td><td class="pagingViewed">1</td><td class="pagingSpace"></td><td class="pagingIntact"><a href="javascript:;" onclick="loadAjaxContent('', '/ajax/get_json.php?action=pcbuilder&amp;action_type=get-product-category&amp;category_id=32&amp;pc_part_id=55008-30%2C54098-31&amp;storeId=&amp;&amp;page=2')">2</a></td><td class="pagingSpace"></td><td class="pagingIntact"><a href="javascript:;" onclick="loadAjaxContent('', '/ajax/get_json.php?action=pcbuilder&amp;action_type=get-product-category&amp;category_id=32&amp;pc_part_id=55008-30%2C54098-31&amp;storeId=&amp;&amp;page=3')">3</a></td><td class="pagingSpace"></td><td class="pagingIntact"><a href="javascript:;" onclick="loadAjaxContent('', '/ajax/get_json.php?action=pcbuilder&amp;action_type=get-product-category&amp;category_id=32&amp;pc_part_id=55008-30%2C54098-31&amp;storeId=&amp;&amp;page=4')">4</a></td><td class="pagingSpace"></td><td class="pagingIntact"><a href="javascript:;" onclick="loadAjaxContent('', '/ajax/get_json.php?action=pcbuilder&amp;action_type=get-product-category&amp;category_id=32&amp;pc_part_id=55008-30%2C54098-31&amp;storeId=&amp;&amp;page=5')">5</a></td><td class="pagingSpace"></td><td class="pagingIntact"><a href="javascript:;" onclick="loadAjaxContent('', '/ajax/get_json.php?action=pcbuilder&amp;action_type=get-product-category&amp;category_id=32&amp;pc_part_id=55008-30%2C54098-31&amp;storeId=&amp;&amp;page=6')">6</a></td><td class="pagingSpace"></td><td class="pagingIntact"><a href="javascript:;" onclick="loadAjaxContent('', '/ajax/get_json.php?action=pcbuilder&amp;action_type=get-product-category&amp;category_id=32&amp;pc_part_id=55008-30%2C54098-31&amp;storeId=&amp;&amp;page=7')">7</a></td><td class="pagingSpace"></td><td class="pagingFarSide" align="center">...</td><td class="pagingIntact"><a href="javascript:;" onclick="loadAjaxContent('', '/ajax/get_json.php?action=pcbuilder&amp;action_type=get-product-category&amp;category_id=32&amp;pc_part_id=55008-30%2C54098-31&amp;storeId=&amp;&amp;page=2')">&gt;&gt;</a></td></tr></tbody></table>
                    </div>
                </div>

                <div class="list-product-select">

                    
                    <div class="p-item">
                        <a href="/ram-desktop-avexir-1soe-solid-avd4uz332001616g-1soe" class="p-img">
                            
                            <img src="https://hanoicomputercdn.com/media/product/120_55660_ram_desktop_avexir_1soe_solid_avd4uz332001616g_1soe.jpg" alt="Ram Desktop AVEXIR 1SOE - Solid (AVD4UZ332001616G-1SOE) 16GB/3200 (1x16GB) DDR4 3200MHz">
                            
                        </a>
                        <div class="info">
                            <a href="/ram-desktop-avexir-1soe-solid-avd4uz332001616g-1soe" class="p-name">Ram Desktop AVEXIR 1SOE - Solid (AVD4UZ332001616G-1SOE) 16GB/3200 (1x16GB) DDR4 3200MHz</a>

                            <table>
                                <tbody><tr>
                                    <td width="80">Mã SP:</td>
                                    <td>RAAV178</td>
                                </tr>
                                <tr>
                                    <td>Bảo hành:</td>
                                    <td>36 tháng</td>
                                </tr>
                                <tr>
                                    <td valign="top">Kho hàng:</td>
                                    <td>
                                        
                                        <span class="dongbotonkho">
                                        <span class="detail" style="background: #278c56; color: #fff; padding: 2px 10px; white-space: pre-line;"><i class="far fa-check"></i> Còn hàng</span>
                                      </span>
                                        
                                    </td>
                                </tr>
                            </tbody></table>
                            <span class="p-price">1.699.000 đ</span>
                        </div>

                        
                        <span class="btn-buy js-select-product" data-id="55660"></span>
                        
                    </div>
                    
                    <div class="p-item">
                        <a href="/ram-desktop-avexir-1cor-red-avd4uz326661916g-1cor" class="p-img">
                            
                            <img src="https://hanoicomputercdn.com/media/product/120_55645_ram_desktop_avexir_1cor_red_avd4uz326661916g_1cor.jpg" alt="Ram Desktop AVEXIR 1COR Red (AVD4UZ326661916G-1COR) 16GB (1x16GB) DDR4 2666Mhz">
                            
                        </a>
                        <div class="info">
                            <a href="/ram-desktop-avexir-1cor-red-avd4uz326661916g-1cor" class="p-name">Ram Desktop AVEXIR 1COR Red (AVD4UZ326661916G-1COR) 16GB (1x16GB) DDR4 2666Mhz</a>

                            <table>
                                <tbody><tr>
                                    <td width="80">Mã SP:</td>
                                    <td>RAAV177</td>
                                </tr>
                                <tr>
                                    <td>Bảo hành:</td>
                                    <td>36 Tháng</td>
                                </tr>
                                <tr>
                                    <td valign="top">Kho hàng:</td>
                                    <td>
                                        

                                        
                                        <span style="background: #eaeaea; color: #555; padding: 2px 10px; white-space: pre-line;"><i class="fas fa-phone fa-flip-horizontal"></i> Liên hệ</span><br>
                                        
                                        
                                    </td>
                                </tr>
                            </tbody></table>
                            <span class="p-price">1.549.000 đ</span>
                        </div>

                        
                        <span class="btn-buy js-select-product sp-het-hang" data-id="55645">
                          	<span class="canh-bao-het-hang">1. Sản phẩm chỉ tạm hết hàng<br>
															2. Quý khách có thể lựa chọn sang sản phẩm khác<br>
															3. Hoặc liên hệ với NV. Kinh Doanh để đặt hàng
                            </span>
                          	</span>

                        
                    </div>
                    
                    <div class="p-item">
                        <a href="/ram-desktop-avexir-1cob-blue-avd4uz326661916g-1cob" class="p-img">
                            
                            <img src="https://hanoicomputercdn.com/media/product/120_55644_ram_desktop_avexir_1cob_blue_avd4uz326661916g_1cob.jpg" alt="Ram Desktop AVEXIR 1COB Blue (AVD4UZ326661916G-1COB) 16GB (1x16GB) DDR4 2666Mhz">
                            
                        </a>
                        <div class="info">
                            <a href="/ram-desktop-avexir-1cob-blue-avd4uz326661916g-1cob" class="p-name">Ram Desktop AVEXIR 1COB Blue (AVD4UZ326661916G-1COB) 16GB (1x16GB) DDR4 2666Mhz</a>

                            <table>
                                <tbody><tr>
                                    <td width="80">Mã SP:</td>
                                    <td>RAAV176</td>
                                </tr>
                                <tr>
                                    <td>Bảo hành:</td>
                                    <td>36 Tháng</td>
                                </tr>
                                <tr>
                                    <td valign="top">Kho hàng:</td>
                                    <td>
                                        

                                        
                                        <span style="background: #eaeaea; color: #555; padding: 2px 10px; white-space: pre-line;"><i class="fas fa-phone fa-flip-horizontal"></i> Liên hệ</span><br>
                                        
                                        
                                    </td>
                                </tr>
                            </tbody></table>
                            <span class="p-price">1.549.000 đ</span>
                        </div>

                        
                        <span class="btn-buy js-select-product sp-het-hang" data-id="55644">
                          	<span class="canh-bao-het-hang">1. Sản phẩm chỉ tạm hết hàng<br>
															2. Quý khách có thể lựa chọn sang sản phẩm khác<br>
															3. Hoặc liên hệ với NV. Kinh Doanh để đặt hàng
                            </span>
                          	</span>

                        
                    </div>
                    
                    <div class="p-item">
                        <a href="/ram-desktop-corsair-dominator-platinum-white-rgb-cmt16gx4m2c3200c16w" class="p-img">
                            
                            <img src="https://hanoicomputercdn.com/media/product/120_55500_ram_desktop_corsair_dominator_platinum_white_rgb_cmt16gx4m2c3200c16w.png" alt="Ram Desktop Corsair Dominator Platinum White RGB (CMT16GX4M2C3200C16W) 16GB (2x8G) DDR4 3200MHz">
                            
                        </a>
                        <div class="info">
                            <a href="/ram-desktop-corsair-dominator-platinum-white-rgb-cmt16gx4m2c3200c16w" class="p-name">Ram Desktop Corsair Dominator Platinum White RGB (CMT16GX4M2C3200C16W) 16GB (2x8G) DDR4 3200MHz</a>

                            <table>
                                <tbody><tr>
                                    <td width="80">Mã SP:</td>
                                    <td>RACO332</td>
                                </tr>
                                <tr>
                                    <td>Bảo hành:</td>
                                    <td>36 Tháng</td>
                                </tr>
                                <tr>
                                    <td valign="top">Kho hàng:</td>
                                    <td>
                                        
                                        <span class="dongbotonkho">
                                        <span class="detail" style="background: #278c56; color: #fff; padding: 2px 10px; white-space: pre-line;"><i class="far fa-check"></i> Còn hàng</span>
                                      </span>
                                        
                                    </td>
                                </tr>
                            </tbody></table>
                            <span class="p-price">3.399.000 đ</span>
                        </div>

                        
                        <span class="btn-buy js-select-product" data-id="55500"></span>
                        
                    </div>
                    
                    <div class="p-item">
                        <a href="/ram-desktop-kingston-hyperx-fury-rgb-hx432c16fb3ak2-32" class="p-img">
                            
                            <img src="https://hanoicomputercdn.com/media/product/120_55179_ram_desktop_kingston_hyperx_fury_rgb_hx432c16fb3ak2_32_4.jpg" alt="Ram Desktop&nbsp;Kingston&nbsp;HyperX Fury RGB (HX432C16FB3AK2/32 ) 32GB (2x16GB) DDR4 3200Mhz">
                            
                        </a>
                        <div class="info">
                            <a href="/ram-desktop-kingston-hyperx-fury-rgb-hx432c16fb3ak2-32" class="p-name">Ram Desktop&nbsp;Kingston&nbsp;HyperX Fury RGB (HX432C16FB3AK2/32 ) 32GB (2x16GB) DDR4 3200Mhz</a>

                            <table>
                                <tbody><tr>
                                    <td width="80">Mã SP:</td>
                                    <td>RAKT265</td>
                                </tr>
                                <tr>
                                    <td>Bảo hành:</td>
                                    <td>36 Tháng&nbsp;</td>
                                </tr>
                                <tr>
                                    <td valign="top">Kho hàng:</td>
                                    <td>
                                        
                                        <span class="dongbotonkho">
                                        <span class="detail" style="background: #278c56; color: #fff; padding: 2px 10px; white-space: pre-line;"><i class="far fa-check"></i> Còn hàng</span>
                                      </span>
                                        
                                    </td>
                                </tr>
                            </tbody></table>
                            <span class="p-price">3.899.000 đ</span>
                        </div>

                        
                        <span class="btn-buy js-select-product" data-id="55179"></span>
                        
                    </div>
                    
                    <div class="p-item">
                        <a href="/ram-desktop-kingston-hyperx-fury-rbg-hx432c16fb3ak2-16" class="p-img">
                            
                            <img src="https://hanoicomputercdn.com/media/product/120_55178_ram_desktop_kingston_hyperx_fury_rbg_hx432c16fb3ak2_16_2.jpg" alt="Ram Desktop&nbsp;Kingston&nbsp;HyperX Fury RBG (HX432C16FB3AK2/16 ) 16GB (2x8GB) DDR4 3200Mhz">
                            
                        </a>
                        <div class="info">
                            <a href="/ram-desktop-kingston-hyperx-fury-rbg-hx432c16fb3ak2-16" class="p-name">Ram Desktop&nbsp;Kingston&nbsp;HyperX Fury RBG (HX432C16FB3AK2/16 ) 16GB (2x8GB) DDR4 3200Mhz</a>

                            <table>
                                <tbody><tr>
                                    <td width="80">Mã SP:</td>
                                    <td>RAKT264</td>
                                </tr>
                                <tr>
                                    <td>Bảo hành:</td>
                                    <td>36 Tháng&nbsp;</td>
                                </tr>
                                <tr>
                                    <td valign="top">Kho hàng:</td>
                                    <td>
                                        
                                        <span class="dongbotonkho">
                                        <span class="detail" style="background: #278c56; color: #fff; padding: 2px 10px; white-space: pre-line;"><i class="far fa-check"></i> Còn hàng</span>
                                      </span>
                                        
                                    </td>
                                </tr>
                            </tbody></table>
                            <span class="p-price">2.149.000 đ</span>
                        </div>

                        
                        <span class="btn-buy js-select-product" data-id="55178"></span>
                        
                    </div>
                    
                    <div class="p-item">
                        <a href="/ram-desktop-corsair-dominator-platinum-white-rgb-cmt32gx4m2c3200c16w-32gb" class="p-img">
                            
                            <img src="https://hanoicomputercdn.com/media/product/120_55040_ram_desktop_corsair_dominator_platinum_white_rgb__cmt32gx4m2c3200c16w__32gb__2x16g__ddr4_3200mhz__2_.jpg" alt="Ram Desktop Corsair Dominator Platinum White RGB (CMT32GX4M2C3200C16W) 32GB (2x16G) DDR4 3200MHz">
                            
                        </a>
                        <div class="info">
                            <a href="/ram-desktop-corsair-dominator-platinum-white-rgb-cmt32gx4m2c3200c16w-32gb" class="p-name">Ram Desktop Corsair Dominator Platinum White RGB (CMT32GX4M2C3200C16W) 32GB (2x16G) DDR4 3200MHz</a>

                            <table>
                                <tbody><tr>
                                    <td width="80">Mã SP:</td>
                                    <td>RACO331</td>
                                </tr>
                                <tr>
                                    <td>Bảo hành:</td>
                                    <td>36 Tháng</td>
                                </tr>
                                <tr>
                                    <td valign="top">Kho hàng:</td>
                                    <td>
                                        
                                        <span class="dongbotonkho">
                                        <span class="detail" style="background: #278c56; color: #fff; padding: 2px 10px; white-space: pre-line;"><i class="far fa-check"></i> Còn hàng</span>
                                      </span>
                                        
                                    </td>
                                </tr>
                            </tbody></table>
                            <span class="p-price">5.199.000 đ</span>
                        </div>

                        
                        <span class="btn-buy js-select-product" data-id="55040"></span>
                        
                    </div>
                    
                    <div class="p-item">
                        <a href="/ram-desktop-corsair-dominator-platinum-rgb-cmt32gx4m2c3200c16-32gb" class="p-img">
                            
                            <img src="https://hanoicomputercdn.com/media/product/120_55039_ram_desktop_corsair_dominator_platinum_rgb__cmt32gx4m2c3200c16__32gb__2x16g__ddr4_3200mhz.jpg" alt="Ram Desktop Corsair Dominator Platinum RGB (CMT32GX4M2C3200C16) 32GB (2x16G) DDR4 3200MHz">
                            
                        </a>
                        <div class="info">
                            <a href="/ram-desktop-corsair-dominator-platinum-rgb-cmt32gx4m2c3200c16-32gb" class="p-name">Ram Desktop Corsair Dominator Platinum RGB (CMT32GX4M2C3200C16) 32GB (2x16G) DDR4 3200MHz</a>

                            <table>
                                <tbody><tr>
                                    <td width="80">Mã SP:</td>
                                    <td>RACO330</td>
                                </tr>
                                <tr>
                                    <td>Bảo hành:</td>
                                    <td>36 Tháng</td>
                                </tr>
                                <tr>
                                    <td valign="top">Kho hàng:</td>
                                    <td>
                                        

                                        
                                        <span style="background: #eaeaea; color: #555; padding: 2px 10px; white-space: pre-line;"><i class="fas fa-phone fa-flip-horizontal"></i> Liên hệ</span><br>
                                        
                                        
                                    </td>
                                </tr>
                            </tbody></table>
                            <span class="p-price">5.199.000 đ</span>
                        </div>

                        
                        <span class="btn-buy js-select-product sp-het-hang" data-id="55039">
                          	<span class="canh-bao-het-hang">1. Sản phẩm chỉ tạm hết hàng<br>
															2. Quý khách có thể lựa chọn sang sản phẩm khác<br>
															3. Hoặc liên hệ với NV. Kinh Doanh để đặt hàng
                            </span>
                          	</span>

                        
                    </div>
                    
                    <div class="p-item">
                        <a href="/ram-desktop-kingmax-zeus-dragon-km-ld4-3200-16ghs-16gb" class="p-img">
                            
                            <img src="https://hanoicomputercdn.com/media/product/120_55037_ram_desktop_kingmax_zeus_dragon__km_ld4_3200_16ghs__16gb__1x16gb__ddr4_3200mhz__3_.jpg" alt="Ram Desktop Kingmax Zeus Dragon (KM-LD4-3200-16GHS) 16GB (1x16GB) DDR4 3200Mhz">
                            
                        </a>
                        <div class="info">
                            <a href="/ram-desktop-kingmax-zeus-dragon-km-ld4-3200-16ghs-16gb" class="p-name">Ram Desktop Kingmax Zeus Dragon (KM-LD4-3200-16GHS) 16GB (1x16GB) DDR4 3200Mhz</a>

                            <table>
                                <tbody><tr>
                                    <td width="80">Mã SP:</td>
                                    <td>RAKM223</td>
                                </tr>
                                <tr>
                                    <td>Bảo hành:</td>
                                    <td>36 Tháng</td>
                                </tr>
                                <tr>
                                    <td valign="top">Kho hàng:</td>
                                    <td>
                                        
                                        <span class="dongbotonkho">
                                        <span class="detail" style="background: #278c56; color: #fff; padding: 2px 10px; white-space: pre-line;"><i class="far fa-check"></i> Còn hàng</span>
                                      </span>
                                        
                                    </td>
                                </tr>
                            </tbody></table>
                            <span class="p-price">1.699.000 đ</span>
                        </div>

                        
                        <span class="btn-buy js-select-product" data-id="55037"></span>
                        
                    </div>
                    
                    <div class="p-item">
                        <a href="/ram-desktop-corsair-vengeance-rgb-cmw64gx4m2e3200c16-64gb" class="p-img">
                            
                            <img src="https://hanoicomputercdn.com/media/product/120_55011_ram_desktop_corsair_vengeance_rgb__cmw64gx4m2e3200c16__64gb__2x32gb__ddr4_3200mhz__3_.jpg" alt="Ram Desktop Corsair Vengeance RGB (CMW64GX4M2E3200C16) 64GB (2x32GB) DDR4 3200MHz">
                            
                        </a>
                        <div class="info">
                            <a href="/ram-desktop-corsair-vengeance-rgb-cmw64gx4m2e3200c16-64gb" class="p-name">Ram Desktop Corsair Vengeance RGB (CMW64GX4M2E3200C16) 64GB (2x32GB) DDR4 3200MHz</a>

                            <table>
                                <tbody><tr>
                                    <td width="80">Mã SP:</td>
                                    <td>RACO328</td>
                                </tr>
                                <tr>
                                    <td>Bảo hành:</td>
                                    <td>36 Tháng</td>
                                </tr>
                                <tr>
                                    <td valign="top">Kho hàng:</td>
                                    <td>
                                        
                                        <span class="dongbotonkho">
                                        <span class="detail" style="background: #278c56; color: #fff; padding: 2px 10px; white-space: pre-line;"><i class="far fa-check"></i> Còn hàng</span>
                                      </span>
                                        
                                    </td>
                                </tr>
                            </tbody></table>
                            <span class="p-price">7.399.000 đ</span>
                        </div>

                        
                        <span class="btn-buy js-select-product" data-id="55011"></span>
                        
                    </div>
                    
                    <div class="p-item">
                        <a href="/ram-desktop-corsair-vengeance-rgb-cmw16gx4m2e3200c16" class="p-img">
                            
                            <img src="https://hanoicomputercdn.com/media/product/120_55010_ram_desktop_corsair_vengeance_rgb__cmw16gx4m2e3200c16__16gb__2x8gb__ddr4_3200mhz__3_.jpg" alt="Ram Desktop Corsair Vengeance RGB (CMW16GX4M2E3200C16) 16GB (2x8GB) DDR4 3200MHz">
                            
                        </a>
                        <div class="info">
                            <a href="/ram-desktop-corsair-vengeance-rgb-cmw16gx4m2e3200c16" class="p-name">Ram Desktop Corsair Vengeance RGB (CMW16GX4M2E3200C16) 16GB (2x8GB) DDR4 3200MHz</a>

                            <table>
                                <tbody><tr>
                                    <td width="80">Mã SP:</td>
                                    <td>RACO327</td>
                                </tr>
                                <tr>
                                    <td>Bảo hành:</td>
                                    <td>36 Tháng</td>
                                </tr>
                                <tr>
                                    <td valign="top">Kho hàng:</td>
                                    <td>
                                        

                                        
                                        <span style="background: #eaeaea; color: #555; padding: 2px 10px; white-space: pre-line;"><i class="fas fa-phone fa-flip-horizontal"></i> Liên hệ</span><br>
                                        
                                        
                                    </td>
                                </tr>
                            </tbody></table>
                            <span class="p-price">2.359.000 đ</span>
                        </div>

                        
                        <span class="btn-buy js-select-product sp-het-hang" data-id="55010">
                          	<span class="canh-bao-het-hang">1. Sản phẩm chỉ tạm hết hàng<br>
															2. Quý khách có thể lựa chọn sang sản phẩm khác<br>
															3. Hoặc liên hệ với NV. Kinh Doanh để đặt hàng
                            </span>
                          	</span>

                        
                    </div>
                    
                    <div class="p-item">
                        <a href="/ram-desktop-corsair-vengeance-rgb-cmw16gx4m1d3000c16" class="p-img">
                            
                            <img src="https://hanoicomputercdn.com/media/product/120_55009_ram_desktop_corsair_vengeance_rgb__cmw16gx4m1d3000c16__16gb__1x16gb__ddr4_3000mhz_1.jpg" alt="Ram Desktop Corsair Vengeance RGB (CMW16GX4M1D3000C16) 16GB (1x16GB) DDR4 3000MHz">
                            
                        </a>
                        <div class="info">
                            <a href="/ram-desktop-corsair-vengeance-rgb-cmw16gx4m1d3000c16" class="p-name">Ram Desktop Corsair Vengeance RGB (CMW16GX4M1D3000C16) 16GB (1x16GB) DDR4 3000MHz</a>

                            <table>
                                <tbody><tr>
                                    <td width="80">Mã SP:</td>
                                    <td>RACO326</td>
                                </tr>
                                <tr>
                                    <td>Bảo hành:</td>
                                    <td>36 Tháng</td>
                                </tr>
                                <tr>
                                    <td valign="top">Kho hàng:</td>
                                    <td>
                                        

                                        
                                        <span style="background: #eaeaea; color: #555; padding: 2px 10px; white-space: pre-line;"><i class="fas fa-phone fa-flip-horizontal"></i> Liên hệ</span><br>
                                        
                                        
                                    </td>
                                </tr>
                            </tbody></table>
                            <span class="p-price">1.999.000 đ</span>
                        </div>

                        
                        <span class="btn-buy js-select-product sp-het-hang" data-id="55009">
                          	<span class="canh-bao-het-hang">1. Sản phẩm chỉ tạm hết hàng<br>
															2. Quý khách có thể lựa chọn sang sản phẩm khác<br>
															3. Hoặc liên hệ với NV. Kinh Doanh để đặt hàng
                            </span>
                          	</span>

                        
                    </div>
                    
                    <div class="p-item">
                        <a href="/ram-desktop-gigabyte-aorus-rgb-gp-ar36c18s8k2hu416r" class="p-img">
                            
                            <img src="https://hanoicomputercdn.com/media/product/120_54800_ram_desktop_gigabyte_aorus_rgb__gp_ar36c18s8k2hu416r__16gb__2x8gb__ddr4_3600mhz_1.jpg" alt="Ram Desktop Gigabyte AORUS RGB (GP_AR36C18S8K2HU416R) 16GB (2x8GB) DDR4 3600Mhz">
                            
                        </a>
                        <div class="info">
                            <a href="/ram-desktop-gigabyte-aorus-rgb-gp-ar36c18s8k2hu416r" class="p-name">Ram Desktop Gigabyte AORUS RGB (GP_AR36C18S8K2HU416R) 16GB (2x8GB) DDR4 3600Mhz</a>

                            <table>
                                <tbody><tr>
                                    <td width="80">Mã SP:</td>
                                    <td>RAGI004</td>
                                </tr>
                                <tr>
                                    <td>Bảo hành:</td>
                                    <td>36 Tháng</td>
                                </tr>
                                <tr>
                                    <td valign="top">Kho hàng:</td>
                                    <td>
                                        

                                        
                                        <span style="background: #eaeaea; color: #555; padding: 2px 10px; white-space: pre-line;"><i class="fas fa-phone fa-flip-horizontal"></i> Liên hệ</span><br>
                                        
                                        
                                    </td>
                                </tr>
                            </tbody></table>
                            <span class="p-price">2.799.000 đ</span>
                        </div>

                        
                        <span class="btn-buy js-select-product sp-het-hang" data-id="54800">
                          	<span class="canh-bao-het-hang">1. Sản phẩm chỉ tạm hết hàng<br>
															2. Quý khách có thể lựa chọn sang sản phẩm khác<br>
															3. Hoặc liên hệ với NV. Kinh Doanh để đặt hàng
                            </span>
                          	</span>

                        
                    </div>
                    
                    <div class="p-item">
                        <a href="/ram-desktop-gigabyte-aorus-rgb-gp-ars16g32" class="p-img">
                            
                            <img src="https://hanoicomputercdn.com/media/product/120_54799_ram_desktop_gigabyte_aorus_rgb__gp_ars16g32__16gb__2x8gb__ddr4_3200mhz.jpg" alt="Ram Desktop Gigabyte AORUS RGB (GP-ARS16G32) 16GB (2x8GB) DDR4 3200Mhz">
                            
                        </a>
                        <div class="info">
                            <a href="/ram-desktop-gigabyte-aorus-rgb-gp-ars16g32" class="p-name">Ram Desktop Gigabyte AORUS RGB (GP-ARS16G32) 16GB (2x8GB) DDR4 3200Mhz</a>

                            <table>
                                <tbody><tr>
                                    <td width="80">Mã SP:</td>
                                    <td>RAGI003</td>
                                </tr>
                                <tr>
                                    <td>Bảo hành:</td>
                                    <td>36 Tháng</td>
                                </tr>
                                <tr>
                                    <td valign="top">Kho hàng:</td>
                                    <td>
                                        
                                        <span class="dongbotonkho">
                                        <span class="detail" style="background: #278c56; color: #fff; padding: 2px 10px; white-space: pre-line;"><i class="far fa-check"></i> Còn hàng</span>
                                      </span>
                                        
                                    </td>
                                </tr>
                            </tbody></table>
                            <span class="p-price">2.599.000 đ</span>
                        </div>

                        
                        <span class="btn-buy js-select-product" data-id="54799"></span>
                        
                    </div>
                    
                    <div class="p-item">
                        <a href="/ram-desktop-axpro-8gb-1x8gb-ddr4-2133mhz" class="p-img">
                            
                            <img src="https://hanoicomputercdn.com/media/product/120_54507_ram_desktop_axpro_8gb__1x8gb__ddr4_2133mhz.jpg" alt="Ram Desktop AXPRO 8GB (1x8GB) DDR4 2133MHz">
                            
                        </a>
                        <div class="info">
                            <a href="/ram-desktop-axpro-8gb-1x8gb-ddr4-2133mhz" class="p-name">Ram Desktop AXPRO 8GB (1x8GB) DDR4 2133MHz</a>

                            <table>
                                <tbody><tr>
                                    <td width="80">Mã SP:</td>
                                    <td>RAAX008</td>
                                </tr>
                                <tr>
                                    <td>Bảo hành:</td>
                                    <td>36 Tháng&nbsp;</td>
                                </tr>
                                <tr>
                                    <td valign="top">Kho hàng:</td>
                                    <td>
                                        
                                        <span class="dongbotonkho">
                                        <span class="detail" style="background: #278c56; color: #fff; padding: 2px 10px; white-space: pre-line;"><i class="far fa-check"></i> Còn hàng</span>
                                      </span>
                                        
                                    </td>
                                </tr>
                            </tbody></table>
                            <span class="p-price">1.149.000 đ</span>
                        </div>

                        
                        <span class="btn-buy js-select-product" data-id="54507"></span>
                        
                    </div>
                    
                    <div class="p-item">
                        <a href="/ram-desktop-avexir-1coy-core-8gb-1x8gb-ddr4-2400mhz" class="p-img">
                            
                            <img src="https://hanoicomputercdn.com/media/product/120_54506_ram_desktop_avexir_1coy_core_8gb__1x8gb__ddr4_2400mhz.jpg" alt="Ram Desktop AVEXIR 1COY-Core 8GB (1x8GB) DDR4 2400MHz">
                            
                        </a>
                        <div class="info">
                            <a href="/ram-desktop-avexir-1coy-core-8gb-1x8gb-ddr4-2400mhz" class="p-name">Ram Desktop AVEXIR 1COY-Core 8GB (1x8GB) DDR4 2400MHz</a>

                            <table>
                                <tbody><tr>
                                    <td width="80">Mã SP:</td>
                                    <td>RAAV125</td>
                                </tr>
                                <tr>
                                    <td>Bảo hành:</td>
                                    <td>36 Tháng&nbsp;</td>
                                </tr>
                                <tr>
                                    <td valign="top">Kho hàng:</td>
                                    <td>
                                        

                                        
                                        <span style="background: #eaeaea; color: #555; padding: 2px 10px; white-space: pre-line;"><i class="fas fa-phone fa-flip-horizontal"></i> Liên hệ</span><br>
                                        
                                        
                                    </td>
                                </tr>
                            </tbody></table>
                            <span class="p-price">839.000 đ</span>
                        </div>

                        
                        <span class="btn-buy js-select-product sp-het-hang" data-id="54506">
                          	<span class="canh-bao-het-hang">1. Sản phẩm chỉ tạm hết hàng<br>
															2. Quý khách có thể lựa chọn sang sản phẩm khác<br>
															3. Hoặc liên hệ với NV. Kinh Doanh để đặt hàng
                            </span>
                          	</span>

                        
                    </div>
                    
                    <div class="p-item">
                        <a href="/ram-desktop-avexir-1bw-budget-8gb-1x8gb-ddr3-1600mhz" class="p-img">
                            
                            <img src="https://hanoicomputercdn.com/media/product/120_54505_ram_desktop_avexir_1bw_budget_8gb.jpg" alt="Ram Desktop AVEXIR 1BW-Budget 8GB (1x8GB)&nbsp; DDR3 1600MHz">
                            
                        </a>
                        <div class="info">
                            <a href="/ram-desktop-avexir-1bw-budget-8gb-1x8gb-ddr3-1600mhz" class="p-name">Ram Desktop AVEXIR 1BW-Budget 8GB (1x8GB)&nbsp; DDR3 1600MHz</a>

                            <table>
                                <tbody><tr>
                                    <td width="80">Mã SP:</td>
                                    <td>RAAV099</td>
                                </tr>
                                <tr>
                                    <td>Bảo hành:</td>
                                    <td>36 Tháng&nbsp;</td>
                                </tr>
                                <tr>
                                    <td valign="top">Kho hàng:</td>
                                    <td>
                                        

                                        
                                        <span style="background: #eaeaea; color: #555; padding: 2px 10px; white-space: pre-line;"><i class="fas fa-phone fa-flip-horizontal"></i> Liên hệ</span><br>
                                        
                                        
                                    </td>
                                </tr>
                            </tbody></table>
                            <span class="p-price">999.000 đ</span>
                        </div>

                        
                        <span class="btn-buy js-select-product sp-het-hang" data-id="54505">
                          	<span class="canh-bao-het-hang">1. Sản phẩm chỉ tạm hết hàng<br>
															2. Quý khách có thể lựa chọn sang sản phẩm khác<br>
															3. Hoặc liên hệ với NV. Kinh Doanh để đặt hàng
                            </span>
                          	</span>

                        
                    </div>
                    
                    <div class="p-item">
                        <a href="/ram-desktop-avexir-1cor-core-4gb-1x4gb-ddr4-2400mhz" class="p-img">
                            
                            <img src="https://hanoicomputercdn.com/media/product/120_54504_ram_desktop_avexir_1cor_core_4gb__1x4gb__ddr4_2400mhz.jpg" alt="Ram Desktop AVEXIR 1COR-Core 4GB (1x4GB) DDR4 2400MHz">
                            
                        </a>
                        <div class="info">
                            <a href="/ram-desktop-avexir-1cor-core-4gb-1x4gb-ddr4-2400mhz" class="p-name">Ram Desktop AVEXIR 1COR-Core 4GB (1x4GB) DDR4 2400MHz</a>

                            <table>
                                <tbody><tr>
                                    <td width="80">Mã SP:</td>
                                    <td>RAAV096</td>
                                </tr>
                                <tr>
                                    <td>Bảo hành:</td>
                                    <td>36 Tháng&nbsp;</td>
                                </tr>
                                <tr>
                                    <td valign="top">Kho hàng:</td>
                                    <td>
                                        

                                        
                                        <span style="background: #eaeaea; color: #555; padding: 2px 10px; white-space: pre-line;"><i class="fas fa-phone fa-flip-horizontal"></i> Liên hệ</span><br>
                                        
                                        
                                    </td>
                                </tr>
                            </tbody></table>
                            <span class="p-price">569.000 đ</span>
                        </div>

                        
                        <span class="btn-buy js-select-product sp-het-hang" data-id="54504">
                          	<span class="canh-bao-het-hang">1. Sản phẩm chỉ tạm hết hàng<br>
															2. Quý khách có thể lựa chọn sang sản phẩm khác<br>
															3. Hoặc liên hệ với NV. Kinh Doanh để đặt hàng
                            </span>
                          	</span>

                        
                    </div>
                    
                    <div class="p-item">
                        <a href="/ram-desktop-avexir-1cob-core-4gb-1x4gb-ddr4-2400mhz" class="p-img">
                            
                            <img src="https://hanoicomputercdn.com/media/product/120_54503_ram_desktop_avexir_1cob_core_4gb__1x4gb__ddr4_2400mhz.jpg" alt="Ram Desktop AVEXIR 1COB-Core 4GB (1x4GB) DDR4 2400MHz">
                            
                        </a>
                        <div class="info">
                            <a href="/ram-desktop-avexir-1cob-core-4gb-1x4gb-ddr4-2400mhz" class="p-name">Ram Desktop AVEXIR 1COB-Core 4GB (1x4GB) DDR4 2400MHz</a>

                            <table>
                                <tbody><tr>
                                    <td width="80">Mã SP:</td>
                                    <td>RAAV095</td>
                                </tr>
                                <tr>
                                    <td>Bảo hành:</td>
                                    <td>36 Tháng&nbsp;</td>
                                </tr>
                                <tr>
                                    <td valign="top">Kho hàng:</td>
                                    <td>
                                        

                                        
                                        <span style="background: #eaeaea; color: #555; padding: 2px 10px; white-space: pre-line;"><i class="fas fa-phone fa-flip-horizontal"></i> Liên hệ</span><br>
                                        
                                        
                                    </td>
                                </tr>
                            </tbody></table>
                            <span class="p-price">569.000 đ</span>
                        </div>

                        
                        <span class="btn-buy js-select-product sp-het-hang" data-id="54503">
                          	<span class="canh-bao-het-hang">1. Sản phẩm chỉ tạm hết hàng<br>
															2. Quý khách có thể lựa chọn sang sản phẩm khác<br>
															3. Hoặc liên hệ với NV. Kinh Doanh để đặt hàng
                            </span>
                          	</span>

                        
                    </div>
                    
                    <div class="p-item">
                        <a href="/ram-desktop-avexir-2ci-blue-core-8gb-2x4gb-ddr4-2133mhz" class="p-img">
                            
                            <img src="https://hanoicomputercdn.com/media/product/120_54502_ram_desktop_avexir_2ci_blue_core_8gb__2x4gb__ddr4_2133mhz.jpg" alt="Ram Desktop AVEXIR 2CI Blue-Core 8GB (2x4GB) DDR4 2133MHz">
                            
                        </a>
                        <div class="info">
                            <a href="/ram-desktop-avexir-2ci-blue-core-8gb-2x4gb-ddr4-2133mhz" class="p-name">Ram Desktop AVEXIR 2CI Blue-Core 8GB (2x4GB) DDR4 2133MHz</a>

                            <table>
                                <tbody><tr>
                                    <td width="80">Mã SP:</td>
                                    <td>RAAV011</td>
                                </tr>
                                <tr>
                                    <td>Bảo hành:</td>
                                    <td>36 Tháng&nbsp;</td>
                                </tr>
                                <tr>
                                    <td valign="top">Kho hàng:</td>
                                    <td>
                                        

                                        
                                        <span style="background: #eaeaea; color: #555; padding: 2px 10px; white-space: pre-line;"><i class="fas fa-phone fa-flip-horizontal"></i> Liên hệ</span><br>
                                        
                                        
                                    </td>
                                </tr>
                            </tbody></table>
                            <span class="p-price">719.000 đ</span>
                        </div>

                        
                        <span class="btn-buy js-select-product sp-het-hang" data-id="54502">
                          	<span class="canh-bao-het-hang">1. Sản phẩm chỉ tạm hết hàng<br>
															2. Quý khách có thể lựa chọn sang sản phẩm khác<br>
															3. Hoặc liên hệ với NV. Kinh Doanh để đặt hàng
                            </span>
                          	</span>

                        
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    jQuery(".icon-menu-filter-mobile").click(function(){
        jQuery(".build-pc .popup-select .popup-main .popup-main_filter").toggle();
    });

    var SEARCH_URL = "https://www.hanoicomputer.vn/ajax/get_json.php?action=pcbuilder&action_type=get-product-category&category_id=32&pc_part_id=55008-30%2C54098-31";

    function loadAjaxContent(holder_id, url){
        objBuildPCVisual.showProductFilter(url);
    }

    function searchKeyword(query) {
        if(query.length < 2) return ;
        objBuildPCVisual.showProductFilter(SEARCH_URL + '&q=' + encodeURIComponent(query));
    }

    jQuery("#buildpc-search-keyword").keypress(function(e) {
        if(e.which == 13) {
            e.preventDefault();
            searchKeyword(this.value);
        }
    });

    jQuery("#js-buildpc-search-btn").on("click", function(){
        searchKeyword(jQuery("#buildpc-search-keyword").val());
    });
</script></div>
</div>

<script>
    //pc config
    var category_config = [
    {
        "id": 31,
        "name": "B\u1ed9 vi x\u1eed l\u00fd"
    },
    {
        "id": 30,
        "name": "Bo m\u1ea1ch ch\u1ee7"
    },
    {
        "id": 32,
        "name": "RAM"
    },
    {
        "id": 33,
        "name": "HDD"
    },
    {
        "id": 164,
        "name": "SSD"
    },
    {
        "id": 34,
        "name": "VGA"
    },
    {
        "id": 36,
        "name": "Ngu\u1ed3n"
    },
    {
        "id": 35,
        "name": "V\u1ecf Case"
    },
    {
        "id": 39,
        "name": "M\u00e0n h\u00ecnh"
    },
    {
        "id": 169,
        "name": "B\u1ed9 b\u00e0n ph\u00edm, chu\u1ed9t"
    },
    {
        "id": 37,
        "name": "B\u00e0n ph\u00edm"
    },
    {
        "id": 38,
        "name": "Chu\u1ed9t"
    },
    {
        "id": 246,
        "name": "Tai nghe"
    },
    {
        "id": 248,
        "name": "Loa"
    },
    {
        "id": 316,
        "name": "Gh\u1ebf Gaming"
    },
    {
        "id": 68,
        "name": "Qu\u1ea1t L\u00e0m M\u00e1t"
    },
    {
        "id": 332,
        "name": "T\u1ea3n nhi\u1ec7t n\u01b0\u1edbc All in One"
    },
    {
        "id": 334,
        "name": "T\u1ea3n nhi\u1ec7t n\u01b0\u1edbc Custom"
    },
    {
        "id": 64,
        "name": "T\u1ea3n Nhi\u1ec7t kh\u00ed"
    },
    {
        "id": 53,
        "name": "Windows b\u1ea3n quy\u1ec1n"
    },
    {
        "id": 52,
        "name": "Ph\u1ea7n m\u1ec1m Antivirus"
    }
];
    var SEARCH_URL = "https://www.hanoicomputer.vn/ajax/get_json.php?action=pcbuilder&action_type=get-product-category&category_id=332&pc_part_id=43026-30%2C43045-31%2C42928-32%2C41833-33";
  
    let SAVE_BUILD_ID = '';
    let objBuildPC;
    let objBuildPCVisual;
  
    //document ready
    jQuery(function () {
        showBuildId(1);
    	runSlider();
    });
  
    function runSlider() {
        jQuery('.banner-custom_config').owlCarousel({
            loop: true,
            margin: 0,
            nav: true,
            navText:['<i class="fa fa-angle-left" aria-hidden="true"></i>','<i class="fa fa-angle-right" aria-hidden="true"></i>'],
            dots: false,
            autoWidth: true,
            autoplay:true,
    autoplayTimeout:5000,
    autoplayHoverPause:true,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 1
                },
                1600: {
                    items: 1
                }
            }
        });
        jQuery('.banner-build').owlCarousel({
            loop: true,
            margin: 0,
            nav: false,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 1
                },
                1000: {
                    items: 1
                }
            }
        });
    }
  	//Hien thi thong bao noi dung khuyen mai neu co
    function showUserBuildPCPromotion(promotion_html,promotion_title){
  		// alert(promotion_html)
        if(promotion_html == '' || promotion_title == '' ) {
			jQuery(".js-buildpc-promotion-content").html('');
  		} else jQuery(".js-buildpc-promotion-content").html('<table><tbody><tr><td>Khuyến mại cho PC trên</td><td> '+promotion_title+'</td></tr></tbody></table>' + promotion_html);
        //$.fancybox.open({
        //                src  : '#js-buildpc-promotion',
                        type : 'inline'
        //            });
  	} 
  
    
    function showBuildId(id){
        
        SAVE_BUILD_ID = 'buildpc-'+id;
        objBuildPC = new BuildPC(SAVE_BUILD_ID);
        objBuildPCVisual = BuildPCVisual(objBuildPC);
        
        //show clean layout
        objBuildPCVisual.showLayout(category_config);
        
		jQuery(".js-buildpc-promotion-content").html('');
  
  
        // get save-config
        Hura.User.getInfo(SAVE_BUILD_ID, function (pc_config) {
            //set config
            objBuildPC.setConfig(pc_config);

            for(let category_id in pc_config) {
                if(pc_config.hasOwnProperty(category_id)) {
                    objBuildPCVisual.displayProductInCategory(category_id, pc_config[category_id].items[0]);
                }
            }
            //show summary 
            objBuildPCVisual.displaySummary();
        } );

        _listener();
        
        function _listener(){
            //listener
            jQuery("#js-buildpc-action").on("click", function (e) {
                var node = e.target;
                if(node.nodeName != 'SPAN') {
                    return ;
                }

                var user_action = node.getAttribute("data-action");
                console.log("user_action = " + user_action);
                console.log("config = " + JSON.stringify(objBuildPC.getConfig(), true, 4).length);

                if(JSON.stringify(objBuildPC.getConfig(), true, 4).length <=2){
                    $.fancybox.open({
                        src  : '#opps',
                        type : 'inline'
                    });
                    return false;
                }

                switch (user_action) {
                    case "save"://luu cau hinh
                        Hura.User.updateInfo(SAVE_BUILD_ID, objBuildPC.getConfig(), function (res) {
                            if(res.status == 'success') {
                                alert("Lưu thành công !");
                            }
                        } );
                        break;

                    case "download-excel": //tai file excel
                        window.location = exportUrl('xls');
                        break;

                    case "view"://xem va in
                        window.location = exportUrl('html');
                        break;

                    case "create-image"://tao anh
                        //alert("Chức năng đang chờ bổ sung!");
                        downloadImage();
                        break;

                    case "share"://chia se
                        //window.location = exportUrl('html');
                        $.fancybox.open({
                            src  : '#popup-share_config',
                            type : 'inline'
                        });
                        break;

                    case "add-cart"://them gio hang
                        //alert("Chức năng đang chờ bổ sung!");
                        addConfigToCart();
                        break;
                }
            });
        }
        
    }
                                                                               
                                                                               
    
    function openPopupRebuild(){
          $.fancybox.open({
            src  : '#popup-rebuild_config',
            type : 'inline'
          });     
    }
                                                                               
    function reBuild(){
        objBuildPCVisual.deleteSelectedConfig();
        Hura.User.updateInfo(SAVE_BUILD_ID, {}, function (res) {
            if(res.status == 'success') {
                //alert("Lưu thành công !");
                location.href='/buildpc';
            }
        });
    }

    function loadAjaxContent(holder_id, url){
        objBuildPCVisual.showProductFilter(url);
    }

    function searchKeyword(query) {
        if(query.length < 2) return ;
        objBuildPCVisual.showProductFilter(SEARCH_URL + '&q=' + encodeURIComponent(query));
    }

    jQuery("#buildpc-search-keyword").keypress(function(e) {
        if(e.which == 13) {
            e.preventDefault();
            searchKeyword(this.value);
        }
    });

    jQuery("#js-buildpc-search-btn").on("click", function(){
        searchKeyword(jQuery("#buildpc-search-keyword").val());
    });
    
    function openSelection(a){
        jQuery(a).click();
    }
    function removeSelection(a){
        jQuery("#js-selected-item-"+a).empty();
    }
    function closePopup(){
        jQuery('.mask-popup').removeClass('active');
        jQuery('body').css('overflow','auto');
    }

    function exportUrl(ftype) {
        var export_url = "/ajax/export_download.php?content_type="+SAVE_BUILD_ID+"&u=" + Hura.User.getUserId() + "&file_type=";
        return  export_url + ftype;
    }

    function downloadImage() {
        var export_url = "/ajax/export_download.php?content_type="+SAVE_BUILD_ID+"&u=" + Hura.User.getUserId() + "&file_type=";
        var url = "https://www.hanoicomputer.vn" + export_url + 'image';
        var tool = "/tools/screenshot/screenshot.php?url=";
        window.open(tool + encodeURIComponent(url),'_blank');
    }

    function addConfigToCart() {
        Hura.User.updateInfo(SAVE_BUILD_ID, objBuildPC.getConfig(), function (res) {
            if(res.status == 'success') { console.log("Lưu thành công !");}
        });

        //get config saved
        Hura.User.getInfo(SAVE_BUILD_ID, function (pc_config) {
            for(var category_id in pc_config) {
                if(pc_config.hasOwnProperty(category_id)) {
                    objBuildPCVisual.displayProductInCategory(category_id, pc_config[category_id].items[0]);
                    var pro = JSON.stringify(pc_config[category_id].items[0], true, 4);
                    pro = JSON.parse(pro);
                    //console.log("config item = " + JSON.stringify(pc_config[category_id].items[0], true, 4));
                    //addToShoppingCart('pro',pro.id,pro.quantity,pro.price);
                    listenBuyPro(pro.id,0,pro.quantity,'','/cart');
                }
            }

        });
    }

    function formatCurrency(a) {
        var b = parseFloat(a).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1.").toString();
        var len = b.length;
        b = b.substring(0, len - 3);
        return b;
    }
    function changeTab(holder){

    jQuery('.list-btn-action li').removeClass('active');
    jQuery(holder).parent().addClass('active')
  }
</script>



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
		wp_enqueue_style( 'woo-product-builder', VI_WPRODUCTBUILDER_F_CSS . 'style_build_pc_v2.css', array(), VI_WPRODUCTBUILDER_F_VERSION );
		wp_enqueue_style( 'woo-product-builder1', VI_WPRODUCTBUILDER_F_CSS . 'otherstyle2020.css', array(), VI_WPRODUCTBUILDER_F_VERSION );

		if ( $this->settings->get_button_icon() ) {
			wp_enqueue_style( 'woocommerce-product-builder-icon', VI_WPRODUCTBUILDER_F_CSS . 'woo-product-builder-icon.css', array(), VI_WPRODUCTBUILDER_F_VERSION );
		}
		wp_enqueue_style( 'woo-product-builder2', VI_WPRODUCTBUILDER_F_CSS . 'woo-product-builder.css', array(), VI_WPRODUCTBUILDER_F_VERSION );

		if ( is_rtl() ) {
			wp_enqueue_style( 'woo-product-builder-rtl', VI_WPRODUCTBUILDER_CSS . 'wooc-product-builder-rtl.css', array(), VI_WPRODUCTBUILDER_F_VERSION );
		}
		/*Add script*/
		wp_enqueue_script( 'woo-product-builder', VI_WPRODUCTBUILDER_F_JS . 'woo-product-builder.js', array( 'jquery' ), VI_WPRODUCTBUILDER_F_VERSION );
		wp_enqueue_script( 'woo-product-builder1', VI_WPRODUCTBUILDER_F_JS . 'BuildPCVisual_v2_2020.js', array( 'jquery' ), VI_WPRODUCTBUILDER_F_VERSION );
		wp_enqueue_script( 'woo-product-builder2', VI_WPRODUCTBUILDER_F_JS . 'BuildPC_v2.js', array( 'jquery' ), VI_WPRODUCTBUILDER_F_VERSION );
		// wp_enqueue_script( 'woo-product-builder3', VI_WPRODUCTBUILDER_F_JS . 'common.js', array( 'jquery' ), VI_WPRODUCTBUILDER_F_VERSION );
		// wp_enqueue_script( 'woo-product-builder4', VI_WPRODUCTBUILDER_F_JS . 'hurasoft.js', array( 'jquery' ), VI_WPRODUCTBUILDER_F_VERSION );
		// wp_enqueue_script( 'woo-product-builder5', VI_WPRODUCTBUILDER_F_JS . 'hurastore.js', array( 'jquery' ), VI_WPRODUCTBUILDER_F_VERSION );
		// wp_enqueue_script( 'woo-product-builder6', VI_WPRODUCTBUILDER_F_JS . 'webworker.js', array( 'jquery' ), VI_WPRODUCTBUILDER_F_VERSION );
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