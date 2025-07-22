<div class="mod_iso_list_products_variants size100 brushes block" id="brushes">
	<div class="product_list">

        <?php foreach($this->variants as $variant) { ?>	

    	    <div class="product product_<?= $variant['count'] ?>">
    		
    		    <?php $first_character = substr($variant['image'][0]['src'], 0, 1); ?>
                <figure class="image_container">
                    <img src="/isotope/<?= $first_character ?>/<?= $variant['image'][0]['src'] ?>" width="2000" height="auto" alt="<?= $variant['image'][0]['alt'] ?>">
                </figure>
    		    
    		    <div class="product_info_wrapper">
    				<div class="product_info">
    					<h3 itemprop="name"><?= $variant['name'] ?></h3>
    					<div class="bristle" itemprop="sku">&nbsp;&nbsp;•&nbsp;&nbsp;<?= $variant['bristle'] ?></div>
    					<div class="sizes">Sizes: <?= $variant['sizes'] ?></div>
    				</div>
    			</div>
    			
    			
    			<div class="toggles">
					<!--
						<div class="variant_toggle_wrapper variant_toggle_<?= $variant['id'] ?>" onClick="variant_toggle('prices', <?= $variant['id'] ?>); ">
						<button>Prices <i class="fa-solid fa-chevron-down"></i></button>
						</div>
						-->
					<div class="variant_toggle_wrapper variant_toggle_<?= $variant['id'] ?>" onclick="variant_toggle('dimentions', <?= $variant['id'] ?>); ">
						<button>
							Dimensions 
							<svg class="svg-inline--fa fa-chevron-down" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-down" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
								<path fill="currentColor" d="M233.4 406.6c12.5 12.5 32.8 12.5 45.3 0l192-192c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L256 338.7 86.6 169.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l192 192z"></path>
							</svg>
							<!-- <i class="fa-solid fa-chevron-down"></i> -->
						</button>
					</div>
				</div>
				
				
				<div class="dimentions_wrapper dimentions_wrapper_<?= $variant['id'] ?> flex_wrapper">
                	<div class="dimentions">
                		<div class="inches">
                            <h4>Inches</h4>
                            <div class="variant variant_label">
                                <div class="size">
                                    Size
                                </div>
                                <div class="length">
                                    Length
                                </div>
                                <div class="width">
                                    Width
                                </div>
                            </div>
                            
                            <?php foreach($variant['children'] as $child) { ?>
                            
                                <div class="variant variant_<?= $child['id'] ?>">
                                    <div class="size">
                                        <?= $child['size'] ?>
                                    </div>
                                    <div class="length">
                                        <?= $child['length'] ?>
                                    </div>
                                    <div class="width">
                                        <?= $child['width'] ?>
                                    </div>
                                </div>
                            
                            <?php } ?>
                        </div>
                		
                        
                	</div>
                </div>
				
    			
    
    		</div>
    		
    		
    		
    		
    		
    		
    		
    		
		
		<?php } ?>
		
		
	</div>
</div>
