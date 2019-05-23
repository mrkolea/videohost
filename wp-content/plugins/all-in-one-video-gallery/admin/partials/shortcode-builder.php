<?php

/**
 * Shortcode Builder.
 *
 * @link    https://plugins360.com
 * @since   1.0.0
 *
 * @package All_In_One_Video_Gallery
 */
?>

<div id="aiovg-shortcode-builder" class="aiovg-shortcode-builder mfp-hide">
    <div id="aiovg-shortcode-form" class="aiovg-shortcode-form">
        <p><?php echo __( 'Use the form below to insert "All-in-One Video Gallery" plugin shortcodes.', 'all-in-one-video-gallery' ); ?></p>
        
        <!-- Shortcodes -->
        <div class="aiovg-shortcode-selector">
        	<label class="aiovg-shortcode-label" for="aiovg-shortcode-type"><?php echo __( 'Shortcode Type', 'all-in-one-video-gallery' ); ?></label> 
            <select id="aiovg-shortcode-type" class="widefat aiovg-shortcode-type">
            	<?php
				foreach ( $shortcodes as $value => $label ) {
					printf( '<option value="%s">%s</option>', $value, $label );
				}
				?>
       		</select>
        </div>  
        
        <!-- Fields -->
        <?php foreach ( $shortcodes as $shortcode => $label ) : ?>
            <div id="aiovg-shortcode-type-<?php esc_attr_e( $shortcode ); ?>" class="aiovg-shortcode-type">
                <?php foreach ( $fields[ $shortcode ] as $key => $section ) : ?>
                    <div class="aiovg-shortcode-section aiovg-shortcode-section-<?php esc_attr_e( $key ); ?>">
                        <div class="aiovg-shortcode-section-header"><?php echo wp_kses_post( $section['title'] ); ?></div>
                            
                        <?php foreach ( $section['fields'] as $field ) : ?>
                            <div class="aiovg-shortcode-field aiovg-shortcode-field-<?php esc_attr_e( $field['name'] ); ?>">                           
                                <?php if ( 'category' == $field['type'] ) : ?>                            
                                    <label class="aiovg-shortcode-label"><?php esc_html_e( $field['label'] ); ?></label>
                                    <?php
                                    wp_dropdown_categories( array(
                                        'show_option_none'  => '-- '.__( 'Top Categories', 'all-in-one-video-gallery' ).' --',
                                        'option_none_value' => 0,
                                        'taxonomy'          => 'aiovg_categories',
                                        'name' 			    => $field['name'],
                                        'class'             => "aiovg-shortcode-input widefat",
                                        'orderby'           => 'name',
                                        'hierarchical'      => true,
                                        'depth'             => 10,
                                        'show_count'        => false,
                                        'hide_empty'        => false,
                                    ) );
                                    ?>                            
                                <?php elseif ( 'categories' == $field['type'] ) : ?>                            
                                    <label class="aiovg-shortcode-label"><?php esc_html_e( $field['label'] ); ?></label>
                                    <ul name="<?php esc_attr_e( $field['name'] ); ?>" class="aiovg-shortcode-input aiovg-checklist widefat" data-default="">
                                        <?php
                                        $args = array(
                                        'taxonomy'      => 'aiovg_categories',
                                        'walker'        => null,
                                        'checked_ontop' => false
                                        ); 
                                    
                                        wp_terms_checklist( 0, $args );
                                        ?>
                                    </ul>  
                                <?php elseif ( 'video' == $field['type'] ) : ?>                            
                                    <label class="aiovg-shortcode-label"><?php esc_html_e( $field['label'] ); ?></label> 
                                    <select name="<?php esc_attr_e( $field['name'] ); ?>" class="aiovg-shortcode-input widefat" data-default="<?php esc_attr_e( $field['value'] ); ?>">
                                        <option value="0">-- <?php _e( 'Latest Video', 'all-in-one-video-gallery' ); ?> --</option>
                                        <?php
                                        $query = array(
                                            'post_type'      => 'aiovg_videos', 
                                            'posts_per_page' => -1 ,
                                            'orderby'        => 'title', 
                                            'order'          => 'ASC', 
                                            'post_status'    => 'publish'
                                        );
                                        
                                        $videos = get_posts( $query );
                
                                        foreach ( $videos as $video ) {	
                                            printf(
                                                '<option value="%d"%s>%s</option>', 
                                                $video->ID, 
                                                selected( $video->ID, $field['value'], false ), 
                                                esc_html( $video->post_title )
                                            );
                                        }
                                        ?>
                                    </select>                              
                                <?php elseif ( 'text' == $field['type'] || 'url' == $field['type'] || 'number' == $field['type'] ) : ?>                        
                                    <label class="aiovg-shortcode-label"><?php esc_html_e( $field['label'] ); ?></label>
                                    <input type="text" name="<?php esc_attr_e( $field['name'] ); ?>" class="aiovg-shortcode-input widefat" value="<?php esc_attr_e( $field['value'] ); ?>" data-default="<?php esc_attr_e( $field['value'] ); ?>" />                            
                                <?php elseif ( 'select' == $field['type'] ) : ?>                            
                                    <label class="aiovg-shortcode-label"><?php esc_html_e( $field['label'] ); ?></label> 
                                    <select name="<?php esc_attr_e( $field['name'] ); ?>" class="aiovg-shortcode-input widefat" data-default="<?php esc_attr_e( $field['value'] ); ?>">
                                        <?php
                                        foreach ( $field['options'] as $value => $label ) {
                                            printf( '<option value="%s"%s>%s</option>', esc_attr( $value ), selected( $value, $field['value'], false ), esc_html( $label ) );
                                        }
                                        ?>
                                    </select>                        
                                <?php elseif ( 'checkbox' == $field['type'] ) : ?>                        
                                    <label>				
                                        <input type="checkbox" name="<?php esc_attr_e( $field['name'] ); ?>" class="aiovg-shortcode-input" data-default="<?php esc_attr_e( $field['value'] ); ?>" value="1" <?php checked( $field['value'] ); ?> />
                                        <?php esc_html_e( $field['label'] ); ?>
                                    </label>                            
                                <?php elseif ( 'color' == $field['type'] ) : ?>                        
                                    <label class="aiovg-shortcode-label"><?php esc_html_e( $field['label'] ); ?></label>
                                    <input type="text" name="<?php esc_attr_e( $field['name'] ); ?>" class="aiovg-shortcode-input aiovg-color-picker-field widefat" value="<?php esc_attr_e( $field['value'] ); ?>" data-default="<?php esc_attr_e( $field['value'] ); ?>" />                        
                                <?php endif; ?>

                                <?php if ( ! empty( $field['description'] ) ) : // Description ?>
                                    <div class="aiovg-shortcode-field-description"><?php echo wp_kses_post( $field['description'] ); ?></div>
                                <?php endif; ?>                                            
                            </div>    
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>      
        
        <!-- Action Buttons -->
        <p class="submit">
            <input type="button" id="aiovg-insert-shortcode" class="button-primary" value="<?php echo __( 'Insert Shortcode', 'all-in-one-video-gallery' ); ?>" />
            <a id="aiovg-cancel-shortcode-insert" class="button-secondary"><?php _e( 'Cancel', 'all-in-one-video-gallery' ); ?></a>
        </p>       
    </div>
</div>