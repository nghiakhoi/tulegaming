<?php
/**
 * Flatsome functions and definitions
 *
 * @package flatsome
 */

require get_template_directory() . '/inc/init.php';

/**
 * Note: It's not recommended to add any custom code here. Please use a child theme so that your customizations aren't lost during updates.
 * Learn more here: http://codex.wordpress.org/Child_Themes
 */
add_action( 'wp_ajax_loadpost', 'loadpost_init' );
add_action( 'wp_ajax_nopriv_loadpost', 'loadpost_init' );
function loadpost_init() {
 
    ob_start(); //bắt đầu bộ nhớ đệm
 
    // $post_new = new WP_Query(array(
    //     'post_type' =>  'post',
    //     'posts_per_page'    =>  '5'
    // ));
 
    // if($post_new->have_posts()):
    //     echo '<ul>';
    //         while($post_new->have_posts()):$post_new->the_post();
    //             echo '<li>'.get_the_title().'</li>';
    //         endwhile;
    //     echo '</ul>';
    // endif; wp_reset_query();
 
    $result = ob_get_clean(); //cho hết bộ nhớ đệm vào biến $result
 
    //wp_send_json_success($result); // trả về giá trị dạng json
 
    


    ?>
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
    <?php
die();//bắt buộc phải có khi kết thúc

}