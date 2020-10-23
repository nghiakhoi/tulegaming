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

                    <?php
                    while ( $query->have_posts() ) : $query->the_post();
                    ?>
                    <div class="p-item">
                        <a href="<?php echo get_permalink(); ?>" class="p-img">
                            
                            <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="<?php echo get_the_title(); ?>">
                            
                        </a>
                        <div class="info">
                            <a href="<?php echo get_permalink(); ?>" class="p-name"><?php echo get_the_title(); ?></a>

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
                            <span class="p-price"><?php $product = wc_get_product( get_the_ID() ); echo number_format( $product->get_price() , 0, '', '.'); ?> đ</span>
                        </div>

                        
                        <span class="btn-buy js-select-product" data-id="55660"></span>
                        
                    </div>
                    <?php
                        endwhile;
                    ?>
                    
                    
                    
                    
                </div>
            </div>
        </div>
    </div>
</div>
    <?php
    wp_reset_postdata();
die();//bắt buộc phải có khi kết thúc

}


add_action( 'wp_ajax_getdanhmuc', 'getdanhmuc_init' );
add_action( 'wp_ajax_nopriv_getdanhmuc', 'getdanhmuc_init' );
function getdanhmuc_init() {
    $cat_id = isset($_POST['cat_id']) ? (int)$_POST['cat_id'] : 0;
    echo '<ul>';

    $args = array(
        'post_type'             => 'product',
        'post_status'           => 'publish',
        'ignore_sticky_posts'   => 1,
        'posts_per_page'        => '12',
        'tax_query'             => array(
            array(
                'taxonomy'      => 'product_cat',
                'field' => 'term_id', //This is optional, as it defaults to 'term_id'
                'terms'         => $cat_id,
                'operator'      => 'IN' // Possible values are 'IN', 'NOT IN', 'AND'.
            ),
            array(
                'taxonomy'      => 'product_visibility',
                'field'         => 'slug',
                'terms'         => 'exclude-from-catalog', // Possibly 'exclude-from-search' too
                'operator'      => 'NOT IN'
            )
        )
    );
       $getposts = new WP_query($args); 
       //$getposts->query('post_status=publish&showposts=-1&terms='.$cat_id);
       global $wp_query; $wp_query->in_the_loop = true;
       while ($getposts->have_posts()) : $getposts->the_post();
          echo '<li>';
          echo '<a href="'.get_the_permalink().'">'.get_the_title().'</a>';
          echo '</li>';
       endwhile; wp_reset_postdata();
    echo '</ul>';
    die(); 

    ?>


    <?php
    //die();//bắt buộc phải có khi kết thúc

    }

add_action( 'wp_ajax_example_ajax_request', 'example_ajax_request' );
add_action( 'wp_ajax_nopriv_example_ajax_request', 'example_ajax_request' );
function example_ajax_request() {
    if ( isset($_GET) ) {
       if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) { 
           $fruit = $_GET['id'];
           //echo $fruit;
           echo '{
            "id": "55894",
            "productId": "55894",
            "isOn": "1",
            "productPath": [
                {
                    "path": [
                        {
                            "id": "6",
                            "url": "\/linh-kien-may-tinh",
                            "name": "Linh Ki\u1ec7n M\u00e1y T\u00ednh"
                        },
                        {
                            "id": "31",
                            "url": "\/cpu-bo-vi-xu-ly",
                            "name": "CPU - B\u1ed9 vi x\u1eed l\u00fd"
                        },
                        {
                            "id": "617",
                            "url": "\/cpu-intel",
                            "name": "CPU Intel"
                        },
                        {
                            "id": "836",
                            "url": "\/cpu-intel-core-i3",
                            "name": "CPU Intel Core i3"
                        }
                    ],
                    "path_url": "<a href=\"\/linh-kien-may-tinh\">Linh Ki\u1ec7n M\u00e1y T\u00ednh<\/a>  &gt;&gt; <a href=\"\/cpu-bo-vi-xu-ly\">CPU - B\u1ed9 vi x\u1eed l\u00fd<\/a>  &gt;&gt; <a href=\"\/cpu-intel\">CPU Intel<\/a>  &gt;&gt; <a href=\"\/cpu-intel-core-i3\">CPU Intel Core i3<\/a> "
                }
            ],
            "productModel": "CPUI407",
            "productSKU": "CPUI407",
            "productUrl": "\/cpu-intel-core-i3-10100f",
            "productName": "CPU Intel Core i3-10100F (3.6GHz turbo up to 4.3Ghz, 4 nh\u00e2n 8 lu\u1ed3ng, 6MB Cache, 65W) - Socket Intel LGA 1200",
            "productImage": {
                "thum": "https:\/\/hanoicomputercdn.com\/media\/product\/50_55894_cpu_intel_core_i3_10100f.jpg",
                "small": "https:\/\/hanoicomputercdn.com\/media\/product\/75_55894_cpu_intel_core_i3_10100f.jpg",
                "medium": "https:\/\/hanoicomputercdn.com\/media\/product\/120_55894_cpu_intel_core_i3_10100f.jpg",
                "large": "https:\/\/hanoicomputercdn.com\/media\/product\/250_55894_cpu_intel_core_i3_10100f.jpg",
                "original": "https:\/\/hanoicomputercdn.com\/media\/product\/55894_cpu_intel_core_i3_10100f.jpg"
            },
            "price": "2399000",
            "currency": "vnd",
            "promotion_price": "0",
            "priceUnit": "chi\u1ebfc",
            "marketPrice": "0",
            "brand": {
                "id": "21",
                "brand_index": "intel",
                "name": "INTEL",
                "summary": "",
                "image": "https:\/\/hanoicomputercdn.com\/media\/brand\/intel.jpg",
                "product": "0",
                "status": "1",
                "is_featured": "0",
                "ordering": "0",
                "letter": "I",
                "lastUpdate": "2020-04-11 15:28:54",
                "brand_page_view": "0",
                "meta_title": "INTEL, Th\u00f4ng Tin V\u00e0 S\u1ea3n Ph\u1ea9m C\u1ee7a H\u00e3ng INTEL - HANOICOMPUTER",
                "meta_keywords": "",
                "meta_description": "INTEL | Linh ki\u1ec7n, Mainboard, CPU, M\u00e1y t\u00ednh v\u0103n ph\u00f2ng mini v.v. Gi\u00e1 r\u1ebb \u2713 Ch\u1ea5t l\u01b0\u1ee3ng \u2713 Ch\u00ednh h\u00e3ng \u2713 \u01afu \u0111\u00e3i h\u1ea5p d\u1eabn \u2713 Ch\u00ednh s\u00e1ch chu \u0111\u00e1o t\u1ea1i HANOICOMPUTER",
                "sellerId": "0",
                "description": ""
            },
            "productSummary": "D\u00f2ng Core i3 th\u1ebf h\u1ec7 th\u1ee9 10 d\u00e0nh cho m\u00e1y b\u00e0n c\u1ee7a Intel\r\n4 nh\u00e2n & 8 lu\u1ed3ng\r\nXung nh\u1ecbp: 3.6GHz (C\u01a1 b\u1ea3n) \/ 4.3GHz (Boost)\r\nSocket: LGA1200\r\n\u0110\u00e3 k\u00e8m s\u1eb5n t\u1ea3n nhi\u1ec7t t\u1eeb h\u00e3ng\r\nKh\u00f4ng k\u00e8m s\u1eb5n iGPU, c\u1ea7n s\u1eed d\u1ee5ng c\u00f9ng VGA r\u1eddi",
            "package_accessory": "0",
            "productImageGallery": [
                {
                    "folder": "standard",
                    "size": {
                        "thum": "https:\/\/hanoicomputercdn.com\/media\/product\/50_55894_cpu_intel_core_i3_10100f_11.jpg",
                        "small": "https:\/\/hanoicomputercdn.com\/media\/product\/75_55894_cpu_intel_core_i3_10100f_11.jpg",
                        "medium": "https:\/\/hanoicomputercdn.com\/media\/product\/120_55894_cpu_intel_core_i3_10100f_11.jpg",
                        "large": "https:\/\/hanoicomputercdn.com\/media\/product\/250_55894_cpu_intel_core_i3_10100f_11.jpg",
                        "original": "https:\/\/hanoicomputercdn.com\/media\/product\/55894_cpu_intel_core_i3_10100f_11.jpg"
                    },
                    "alt": "CPU Intel Core i3-10100F"
                },
                {
                    "folder": "standard",
                    "size": {
                        "thum": "https:\/\/hanoicomputercdn.com\/media\/product\/50_55894_cpu_intel_core_i3_10100f_22.jpg",
                        "small": "https:\/\/hanoicomputercdn.com\/media\/product\/75_55894_cpu_intel_core_i3_10100f_22.jpg",
                        "medium": "https:\/\/hanoicomputercdn.com\/media\/product\/120_55894_cpu_intel_core_i3_10100f_22.jpg",
                        "large": "https:\/\/hanoicomputercdn.com\/media\/product\/250_55894_cpu_intel_core_i3_10100f_22.jpg",
                        "original": "https:\/\/hanoicomputercdn.com\/media\/product\/55894_cpu_intel_core_i3_10100f_22.jpg"
                    },
                    "alt": "CPU Intel Core i3-10100F"
                },
                {
                    "folder": "standard",
                    "size": {
                        "thum": "https:\/\/hanoicomputercdn.com\/media\/product\/50_55894_cpu_intel_core_i3_10100f_33.jpg",
                        "small": "https:\/\/hanoicomputercdn.com\/media\/product\/75_55894_cpu_intel_core_i3_10100f_33.jpg",
                        "medium": "https:\/\/hanoicomputercdn.com\/media\/product\/120_55894_cpu_intel_core_i3_10100f_33.jpg",
                        "large": "https:\/\/hanoicomputercdn.com\/media\/product\/250_55894_cpu_intel_core_i3_10100f_33.jpg",
                        "original": "https:\/\/hanoicomputercdn.com\/media\/product\/55894_cpu_intel_core_i3_10100f_33.jpg"
                    },
                    "alt": "CPU Intel Core i3-10100F"
                },
                {
                    "folder": "standard",
                    "size": {
                        "thum": "https:\/\/hanoicomputercdn.com\/media\/product\/50_55894_cpu_intel_core_i3_10100f.jpg",
                        "small": "https:\/\/hanoicomputercdn.com\/media\/product\/75_55894_cpu_intel_core_i3_10100f.jpg",
                        "medium": "https:\/\/hanoicomputercdn.com\/media\/product\/120_55894_cpu_intel_core_i3_10100f.jpg",
                        "large": "https:\/\/hanoicomputercdn.com\/media\/product\/250_55894_cpu_intel_core_i3_10100f.jpg",
                        "original": "https:\/\/hanoicomputercdn.com\/media\/product\/55894_cpu_intel_core_i3_10100f.jpg"
                    },
                    "alt": "CPU Intel Core i3-10100F"
                }
            ],
            "productImageCount": "4",
            "warranty": "36 Th\u00e1ng",
            "specialOffer": {
                "all": []
            },
            "specialOfferGroup": [],
            "shipping": "0",
            "quantity": "23",
            "visit": "4046",
            "status": "1",
            "configCount": "0",
            "configList": "",
            "comboCount": "0",
            "buy_count": "0",
            "has_video": "0",
            "manual_url": "",
            "hasVAT": "1",
            "productType": {
                "isNew": 0,
                "isHot": 0,
                "isBestSale": 0,
                "isSaleOff": 0,
                "online-only": 0
            },
            "condition": "",
            "config_count": "0",
            "extend": {
                "product_name_h1": "",
                "more_price_1": "0",
                "more_price_2": "0",
                "more_price_3": "0"
            },
            "meta_title": "CPU Intel Core i3-10100F (3.6GHz turbo up to 4.3Ghz, 4 nh\u00e2n 8 lu\u1ed3ng, 6MB Cache, 65W) - Socket Intel LGA 1200",
            "meta_keyword": "",
            "meta_description": "Mua CPU Intel Core i3-10100F ch\u00ednh h\u00e3ng t\u1ea1i HANOICOMPUTER! Build PC gi\u00e1 t\u1ed1t, khuy\u1ebfn m\u00e3i h\u1ea5p d\u1eabn t\u1ea1i HANOICOMPUTER! D\u1ecbch v\u1ee5 uy t\u00edn. Ph\u1ee5c v\u1ee5 t\u1eadn t\u00e2m. Mua ngay!",
            "last_update": "2020-10-14T08:14:06+0700",
            "supplier": false,
            "bulk_price": [],
            "thum_poster": "0",
            "thum_poster_type": "",
            "sale_rules": {
                "price": "2399000",
                "normal_price": "2399000",
                "min_purchase": 1,
                "max_purchase": "23",
                "remain_quantity": "23",
                "from_time": 0,
                "to_time": 0,
                "type": ""
            },
            "deal_list": [],
            "related": {
                "product": [],
                "article-article": []
            },
            "categoryInfo": [
                {
                    "id": "836",
                    "name": "CPU Intel Core i3",
                    "summary": "<p>C&aacute;c con chip Core I5, I7 hay th\u1eadm ch&iacute; l&agrave; Core I9 hi\u1ec7n nay \u0111\u01b0\u1ee3c coi l&agrave; c\u1ea5u h&igrave;nh ti&ecirc;u chu\u1ea9n cho c&aacute;c b\u1ed9 m&aacute;y t\u1ea7m trung tr\u1edf n&ecirc;n. Nh\u01b0ng v\u1edbi s\u1ef1 ph&aacute;t tri\u1ec3n c\u1ee7a m&igrave;nh, CPU Intel Core I3 th\u1ebf h\u1ec7 th\u1ee9 10 c\u0169ng c&oacute; s\u1ee9c m\u1ea1nh kh&ocirc;ng k&eacute;m g&igrave; nh\u1eefng con chip I7 \u0111\u1eddi c\u0169. B\u1edfi v\u1eady, ch\u1eb3ng c&oacute; l\u1ebd g&igrave; b\u1ea1n kh&ocirc;ng mua m\u1ed9t con chip I3 \u0111\u1ec3 s\u1eed d\u1ee5ng k",
                    "is_featured": "0",
                    "isParent": "0",
                    "url": "\/cpu-intel-core-i3",
                    "parentId": "617",
                    "thumnail": ""
                }
            ],
            "tag_list": [],
            "addon": []
        }';
           wp_die();
       }
       die();
    }
   }