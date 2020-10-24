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
          <div class="list-drive" id="js-buildpc-layout">
          
                        </div>
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
            <li><span data-action="add-carta">
<a href="#" class="click_popup">Thông báo</a>
<i class="fas fa-shopping-cart"></i></span></li>
          </ul>
          <ul class="list-btn-action" id="js-buildpc-action">
<?php 
$query = new WP_Query( array(
    'post_type'      => 'product',
    'post_status'    => 'publish',
    'posts_per_page' => -1,
    'tax_query'      => array( array(
        'taxonomy'   => 'product_cat',
        'field'      => 'term_id',
        'terms'      => '142',
    ) )
) );

while ( $query->have_posts() ) : $query->the_post();
    echo '<li style="color:red" class="list-cat"><a href="'. get_permalink() .'"><div class="product__preview"><img src="' . get_the_post_thumbnail_url() . '"></div><span>' . get_the_title() . '</span></a></li>';
endwhile;

wp_reset_postdata();
 
?>
<li style="color:red" class="list-cat" >
        <?php echo 'aa'; ?>
    </li>
</ul>

<div class="display-post-cat"></div>

<div class="loadpost_result"></div>
<a href="#" class="click_popup">Tải 5 bài mới nhất</a>
<script type="text/javascript">
    (function($){
        $(document).ready(function(){
            $('.click_popup').click(function(){
                $.ajax({
                    type : "post", //Phương thức truyền post hoặc get
                    dataType : "json", //Dạng dữ liệu trả về xml, json, script, or html
                    url : '<?php echo admin_url('admin-ajax.php');?>', //Đường dẫn chứa hàm xử lý dữ liệu. Mặc định của WP như vậy
                    data : {
                        action: "loadpost", //Tên action
                    },
                    context: this,
                    beforeSend: function(){
                        //Làm gì đó trước khi gửi dữ liệu vào xử lý
                    },
                    success: function(response) {
                        //Làm gì đó khi dữ liệu đã được xử lý
                        if(response.success) {
                            $('.loadpost_result').html(response.data);
                            console.log(response.data);
                        }
                        else {
                            alert('Đã có lỗi xảy ra');
                        }
                    },
                    error: function( jqXHR, textStatus, errorThrown ){
                        //Làm gì đó khi có lỗi xảy ra
                        console.log( 'The following error occured: ' + textStatus, errorThrown );
                    }
                })
                return false;
            })
        })

        $('.list-cat').click(function(){ // Khi click vào category bất kỳ
   var cat_id = $(this).data('id'); // lấy id của category đó thông qua data-id
   $.ajax({ // Hàm ajax
      type : "post", //Phương thức truyền post hoặc get
      dataType : "html", //Dạng dữ liệu trả về xml, json, script, or html
      url : '<?php echo admin_url('admin-ajax.php');?>', // Nơi xử lý dữ liệu
      data : {
         action: "getdanhmuc", //Tên action, dữ liệu gởi lên cho server
         cat_id: cat_id, //Gởi id chuyên mục cho server
      },
      beforeSend: function(){
        // Có thể thực hiện công việc load hình ảnh quay quay trước khi đổ dữ liệu ra
      },
      success: function(response) {
         $('.display-post-cat').html(response); // Đổ dữ liệu trả về vào thẻ <div class="display-post"></div>
      },
      error: function( jqXHR, textStatus, errorThrown ){
         //Làm gì đó khi có lỗi xảy ra
         console.log( 'The following error occured: ' + textStatus, errorThrown );
      }
   });
   });
    })(jQuery)
</script>



	</div>
	<div id="js-modal-popup">
</div>

<script>
    jQuery(".icon-menu-filter-mobile").click(function(){
        jQuery(".build-pc .popup-select .popup-main .popup-main_filter").toggle();
    });

    var SEARCH_URL = "https://nghiakhoi.ddns.net:8888/wp-admin/admin-ajax.php";

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

        <?php $args = array( 
 'hide_empty' => 0,
 'taxonomy' => 'product_cat',
 'post_type' => 'product',
 'orderby' => id,
 ); 
 $cates = get_categories( $args ); 
 foreach ( $cates as $cate ) { ?>
    {
        "id": <?php echo $cate->term_id; ?>,
        "name": "<?php echo $cate->name ?>"
    },    
<?php } ?>

    
   
];
    var SEARCH_URL = "https://nghiakhoi.ddns.net:8888/wp-admin/admin-ajax.php";
  
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
		wp_enqueue_style( 'woo-product-builder1', VI_WPRODUCTBUILDER_F_CSS . 'fontawesome.css', array(), VI_WPRODUCTBUILDER_F_VERSION );
		// wp_enqueue_style( 'woo-product-builder1', VI_WPRODUCTBUILDER_F_CSS . 'otherstyle2020.css', array(), VI_WPRODUCTBUILDER_F_VERSION );

		if ( $this->settings->get_button_icon() ) {
			wp_enqueue_style( 'woocommerce-product-builder-icon', VI_WPRODUCTBUILDER_F_CSS . 'woo-product-builder-icon.css', array(), VI_WPRODUCTBUILDER_F_VERSION );
		}
		wp_enqueue_style( 'woo-product-builder2', VI_WPRODUCTBUILDER_F_CSS . 'woo-product-builder.css', array(), VI_WPRODUCTBUILDER_F_VERSION );

		if ( is_rtl() ) {
			wp_enqueue_style( 'woo-product-builder-rtl', VI_WPRODUCTBUILDER_CSS . 'wooc-product-builder-rtl.css', array(), VI_WPRODUCTBUILDER_F_VERSION );
		}
		/*Add script*/
		wp_enqueue_script( 'woo-product-builder', VI_WPRODUCTBUILDER_F_JS . 'woo-product-builder.js', array( 'jquery' ), VI_WPRODUCTBUILDER_F_VERSION );
		wp_enqueue_script( 'woo-product-builder2', VI_WPRODUCTBUILDER_F_JS . 'BuildPC_v2.js', array( 'jquery' ), VI_WPRODUCTBUILDER_F_VERSION );
		wp_enqueue_script( 'woo-product-builder1', VI_WPRODUCTBUILDER_F_JS . 'BuildPCVisual_v2_2020.js', array( 'jquery' ), VI_WPRODUCTBUILDER_F_VERSION );
		
		wp_enqueue_script( 'woo-product-builder3', VI_WPRODUCTBUILDER_F_JS . 'hurastore.js', array( 'jquery' ), VI_WPRODUCTBUILDER_F_VERSION );
		wp_enqueue_script( 'woo-product-builder3', VI_WPRODUCTBUILDER_F_JS . 'hurasoft.js', array( 'jquery' ), VI_WPRODUCTBUILDER_F_VERSION );
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