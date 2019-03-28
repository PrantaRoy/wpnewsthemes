<?php
/**
 * NewsAnchor Theme Customizer
 *
 * @package NewsAnchor
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function newsanchor_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
    $wp_customize->get_section( 'title_tagline' )->priority = '9';
    $wp_customize->get_section( 'title_tagline' )->title = __('Site title/tagline/logo', 'newsanchor');


    class NewsAnchor_Info extends WP_Customize_Control {
        public $type = 'info';
        public $label = '';
        public function render_content() {
        ?>
            <h3 style="margin-top:30px;border:1px solid;padding:5px;color:#16a1e7;text-transform:uppercase;"><?php echo esc_html( $this->label ); ?></h3>
        <?php
        }
    }

    //Categories dropdown control.
    class NewsAnchor_Categories_Dropdown extends WP_Customize_Control {
        public function render_content() {
            $dropdown = wp_dropdown_categories(
                array(
                    'name'              => '_customize-dropdown-categories-' . $this->id,
                    'echo'              => 0,
                    'show_option_none'  => __( '&mdash; Select &mdash;', 'newsanchor' ),
                    'option_none_value' => '0',
                    'selected'          => $this->value(),
                )
            );
 
            $dropdown = str_replace( '<select', '<select ' . $this->get_link(), $dropdown );
 
            printf(
                '<label class="customize-control-select"><span class="customize-control-title">%s</span> %s</label>',
                $this->label,
                $dropdown
            );
        }
    }

    //Logo Upload
    $wp_customize->add_setting(
        'site_logo',
        array(
            'default-image' => '',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'esc_url_raw',
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'site_logo',
            array(
               'label'          => __( 'Upload your logo', 'newsanchor' ),
               'type'           => 'image',
               'section'        => 'title_tagline',
                'description' => __('Displayed instead of the site title and description', 'newsanchor'),
               'priority'       => 12,
            )
        )
    );

    //___Carousel___//
    $wp_customize->add_section(
        'newsanchor_carousel',
        array(
            'title' => __('Carousel', 'newsanchor'),
            'priority' => 13,
        )
    );
    //Display: Front page
    $wp_customize->add_setting(
        'carousel_display_front',
        array(
            'sanitize_callback' => 'newsanchor_sanitize_checkbox',
            'capability'        => 'edit_theme_options',
            'default' => 1,         
        )       
    );
    $wp_customize->add_control(
        'carousel_display_front',
        array(
            'type' => 'checkbox',
            'label' => __('Show carousel on front page?', 'newsanchor'),
            'section' => 'newsanchor_carousel',
            'priority' => 8,           
        )
    );
    //Display: Home and archives
    $wp_customize->add_setting(
        'carousel_display_archives',
        array(
            'sanitize_callback' => 'newsanchor_sanitize_checkbox',
            'capability'        => 'edit_theme_options',
            'default' => 1,         
        )       
    );
    $wp_customize->add_control(
        'carousel_display_archives',
        array(
            'type' => 'checkbox',
            'label' => __('Show carousel on blog index/archives/etc?', 'newsanchor'),
            'section' => 'newsanchor_carousel',
            'priority' => 9,           
        )
    );
    //Display: Singular
    $wp_customize->add_setting(
        'carousel_display_singular',
        array(
            'sanitize_callback' => 'newsanchor_sanitize_checkbox',
            'capability'        => 'edit_theme_options',
            'default' => 0,         
        )       
    );
    $wp_customize->add_control(
        'carousel_display_singular',
        array(
            'type' => 'checkbox',
            'label' => __('Show carousel on single posts and pages?', 'newsanchor'),
            'section' => 'newsanchor_carousel',
            'priority' => 10,           
        )
    );    
    //Category
    $wp_customize->add_setting( 'carousel_cat', array(
        'default'           => '',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'absint',
    ) );
    
    $wp_customize->add_control( new NewsAnchor_Categories_Dropdown( $wp_customize, 'carousel_cat', array(
        'label'     => __('Select which category to show in the carousel', 'newsanchor'),
        'section'   => 'newsanchor_carousel',
        'settings'  => 'carousel_cat',
        'priority'  => 11
    ) ) );
    //Autoplay speed
    $wp_customize->add_setting(
        'carousel_speed',
        array(
            'default'           => '4000',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'newsanchor_sanitize_int',
        )
    );
    $wp_customize->add_control(
        'carousel_speed',
        array(
            'label'     => __('Enter the carousel speed in miliseconds [Default: 4000]', 'newsanchor'),
            'section'   => 'newsanchor_carousel',
            'type'      => 'text',
            'priority'  => 13
        )
    );         
    //Number of posts
    $wp_customize->add_setting(
        'carousel_number',
        array(
            'default'           => '6',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'newsanchor_sanitize_int',
        )
    );
    $wp_customize->add_control(
        'carousel_number',
        array(
            'label'     => __('Enter the number of posts you want to show', 'newsanchor'),
            'section'   => 'newsanchor_carousel',
            'type'      => 'text',
            'priority'  => 12
        )
    );


    //___Blog options___//
    $wp_customize->add_section(
        'blog_options',
        array(
            'title' => __('Blog options', 'newsanchor'),
            'priority' => 13,
        )
    );  
    // Blog layout
    $wp_customize->add_setting('newsanchor_options[info]', array(
            'type'              => 'info_control',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'esc_attr',            
        )
    );
    $wp_customize->add_control( new newsanchor_Info( $wp_customize, 'layout', array(
        'label' => __('Layout', 'newsanchor'),
        'section' => 'blog_options',
        'settings' => 'newsanchor_options[info]',
        'priority' => 10
        ) )
    );    
    $wp_customize->add_setting(
        'blog_layout',
        array(
            'default'           => 'classic',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'newsanchor_sanitize_blog',
        )
    );
    $wp_customize->add_control(
        'blog_layout',
        array(
            'type'      => 'radio',
            'label'     => __('Blog layout', 'newsanchor'),
            'section'   => 'blog_options',
            'priority'  => 11,
            'choices'   => array(
                'classic'           => __( 'Classic', 'newsanchor' ),
                'fullwidth'         => __( 'Full width (no sidebar)', 'newsanchor' ),
                'masonry-layout'    => __( 'Masonry (grid style)', 'newsanchor' )
            ),
        )
    ); 
    //Full width singles
    $wp_customize->add_setting(
        'fullwidth_single',
        array(
            'sanitize_callback' => 'newsanchor_sanitize_checkbox',
            'capability'        => 'edit_theme_options',
        )       
    );
    $wp_customize->add_control(
        'fullwidth_single',
        array(
            'type'      => 'checkbox',
            'label'     => __('Full width single posts?', 'newsanchor'),
            'section'   => 'blog_options',
            'priority'  => 12,
        )
    );

    //Meta
    $wp_customize->add_setting('newsanchor_options[info]', array(
            'type'              => 'info_control',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'esc_attr',            
        )
    );
    $wp_customize->add_control( new newsanchor_Info( $wp_customize, 'meta', array(
        'label' => __('Meta', 'newsanchor'),
        'section' => 'blog_options',
        'settings' => 'newsanchor_options[info]',
        'priority' => 17
        ) )
    ); 
    //Hide meta index
    $wp_customize->add_setting(
      'hide_meta_index',
      array(
        'sanitize_callback' => 'newsanchor_sanitize_checkbox',
        'capability'        => 'edit_theme_options',
        'default' => 0,     
      )   
    );
    $wp_customize->add_control(
      'hide_meta_index',
      array(
        'type' => 'checkbox',
        'label' => __('Hide post meta on index, archives?', 'newsanchor'),
        'section' => 'blog_options',
        'priority' => 18,
      )
    );
    //Hide meta single
    $wp_customize->add_setting(
      'hide_meta_single',
      array(
        'sanitize_callback' => 'newsanchor_sanitize_checkbox',
        'capability'        => 'edit_theme_options',
        'default' => 0,     
      )   
    );
    $wp_customize->add_control(
      'hide_meta_single',
      array(
        'type' => 'checkbox',
        'label' => __('Hide post meta on singles?', 'newsanchor'),
        'section' => 'blog_options',
        'priority' => 19,
      )
    );
    //Featured images
    $wp_customize->add_setting('newsanchor_options[info]', array(
            'type'              => 'info_control',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'esc_attr',            
        )
    );
    $wp_customize->add_control( new NewsAnchor_Info( $wp_customize, 'images', array(
        'label' => __('Featured images', 'newsanchor'),
        'section' => 'blog_options',
        'settings' => 'newsanchor_options[info]',
        'priority' => 21
        ) )
    );     
    //Index images
    $wp_customize->add_setting(
        'index_feat_image',
        array(
            'sanitize_callback' => 'newsanchor_sanitize_checkbox',
            'capability'        => 'edit_theme_options',
        )       
    );
    $wp_customize->add_control(
        'index_feat_image',
        array(
            'type' => 'checkbox',
            'label' => __('Check this box to hide featured images on index, archives etc.', 'newsanchor'),
            'section' => 'blog_options',
            'priority' => 22,
        )
    );
    //Post images
    $wp_customize->add_setting(
        'post_feat_image',
        array(
            'sanitize_callback' => 'newsanchor_sanitize_checkbox',
            'capability'        => 'edit_theme_options',
        )       
    );
    $wp_customize->add_control(
        'post_feat_image',
        array(
            'type' => 'checkbox',
            'label' => __('Check this box to hide featured images on single posts', 'newsanchor'),
            'section' => 'blog_options',
            'priority' => 23,
        )
    );

    //___Footer___//
    $wp_customize->add_section(
        'newsanchor_footer',
        array(
            'title'         => __('Footer', 'newsanchor'),
            'priority'      => 18,
        )
    );
    //Front page
    $wp_customize->add_setting(
        'footer_widget_areas',
        array(
            'default'           => '3',
            'sanitize_callback' => 'newsanchor_sanitize_fw',
            'capability'        => 'edit_theme_options',
        )
    );
    $wp_customize->add_control(
        'footer_widget_areas',
        array(
            'type'        => 'radio',
            'label'       => __('Footer widget area', 'newsanchor'),
            'section'     => 'newsanchor_footer',
            'description' => __('Select the number of widget areas you want in the footer. After that, go to Appearance > Widgets and add your widgets.', 'newsanchor'),
            'choices' => array(
                '1'     => __('One', 'newsanchor'),
                '2'     => __('Two', 'newsanchor'),
                '3'     => __('Three', 'newsanchor'),
                '4'     => __('Four', 'newsanchor')
            ),
        )
    );

    //___Fonts___//
    $wp_customize->add_section(
        'newsanchor_fonts',
        array(
            'title' => __('Fonts', 'newsanchor'),
            'priority' => 15,
            'description' => __('Google Fonts can be found here: google.com/fonts. See the documentation if you need help in selecting Google Fonts: athemes.com/documentation/newsanchor', 'newsanchor'),
        )
    );
    //Body fonts title
    $wp_customize->add_setting('newsanchor_options[info]', array(
            'type'              => 'info_control',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'esc_attr',            
        )
    );
    $wp_customize->add_control( new newsanchor_Info( $wp_customize, 'body_fonts', array(
        'label' => __('Body fonts', 'newsanchor'),
        'section' => 'newsanchor_fonts',
        'settings' => 'newsanchor_options[info]',
        'priority' => 10
        ) )
    );    
    //Body fonts
    $wp_customize->add_setting(
        'body_font_name',
        array(
            'default' => 'PT+Sans:400,700',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'newsanchor_sanitize_text',
        )
    );
    $wp_customize->add_control(
        'body_font_name',
        array(
            'label' => __( 'Font name/style/sets', 'newsanchor' ),
            'section' => 'newsanchor_fonts',
            'type' => 'text',
            'priority' => 11
        )
    );
    //Body fonts family
    $wp_customize->add_setting(
        'body_font_family',
        array(
            'default' => '\'PT Sans\', sans-serif',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'newsanchor_sanitize_text',
        )
    );
    $wp_customize->add_control(
        'body_font_family',
        array(
            'label' => __( 'Font family', 'newsanchor' ),
            'section' => 'newsanchor_fonts',
            'type' => 'text',
            'priority' => 12
        )
    );
    //Headings fonts title
    $wp_customize->add_setting('newsanchor_options[info]', array(
            'type'              => 'info_control',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'esc_attr',            
        )
    );
    $wp_customize->add_control( new newsanchor_Info( $wp_customize, 'headings_fonts', array(
        'label' => __('Headings fonts', 'newsanchor'),
        'section' => 'newsanchor_fonts',
        'settings' => 'newsanchor_options[info]',
        'priority' => 13
        ) )
    );      
    //Headings fonts
    $wp_customize->add_setting(
        'headings_font_name',
        array(
            'default' => 'Droid+Serif:400,700',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'newsanchor_sanitize_text',
        )
    );
    $wp_customize->add_control(
        'headings_font_name',
        array(
            'label' => __( 'Font name/style/sets', 'newsanchor' ),
            'section' => 'newsanchor_fonts',
            'type' => 'text',
            'priority' => 14
        )
    );
    //Headings fonts family
    $wp_customize->add_setting(
        'headings_font_family',
        array(
            'default' => '\'Droid Serif\', serif',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'newsanchor_sanitize_text',
        )
    );
    $wp_customize->add_control(
        'headings_font_family',
        array(
            'label' => __( 'Font family', 'newsanchor' ),
            'section' => 'newsanchor_fonts',
            'type' => 'text',
            'priority' => 15
        )
    );
    //Font sizes title
    $wp_customize->add_setting('newsanchor_options[info]', array(
            'type'              => 'info_control',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'esc_attr',            
        )
    );
    $wp_customize->add_control( new newsanchor_Info( $wp_customize, 'font_sizes', array(
        'label' => __('Font sizes', 'newsanchor'),
        'section' => 'newsanchor_fonts',
        'settings' => 'newsanchor_options[info]',
        'priority' => 16
        ) )
    );
    // Site title
    $wp_customize->add_setting(
        'site_title_size',
        array(
            'sanitize_callback' => 'absint',
            'capability'        => 'edit_theme_options',
            'default'           => '26',
        )       
    );
    $wp_customize->add_control( 'site_title_size', array(
        'type'        => 'number',
        'priority'    => 17,
        'section'     => 'newsanchor_fonts',
        'label'       => __('Site title', 'newsanchor'),
        'input_attrs' => array(
            'min'   => 10,
            'max'   => 90,
            'step'  => 1,
            'style' => 'margin-bottom: 15px; padding: 10px;',
        ),
    ) ); 
    // Site description
    $wp_customize->add_setting(
        'site_desc_size',
        array(
            'sanitize_callback' => 'absint',
            'capability'        => 'edit_theme_options',
            'default'           => '16',
        )       
    );
    $wp_customize->add_control( 'site_desc_size', array(
        'type'        => 'number',
        'priority'    => 17,
        'section'     => 'newsanchor_fonts',
        'label'       => __('Site description', 'newsanchor'),
        'input_attrs' => array(
            'min'   => 10,
            'max'   => 50,
            'step'  => 1,
            'style' => 'margin-bottom: 15px; padding: 10px;',
        ),
    ) );         
    //H1 size
    $wp_customize->add_setting(
        'h1_size',
        array(
            'sanitize_callback' => 'absint',
            'capability'        => 'edit_theme_options',
            'default'           => '52',
        )       
    );
    $wp_customize->add_control( 'h1_size', array(
        'type'        => 'number',
        'priority'    => 17,
        'section'     => 'newsanchor_fonts',
        'label'       => __('H1 font size', 'newsanchor'),
        'input_attrs' => array(
            'min'   => 10,
            'max'   => 60,
            'step'  => 1,
            'style' => 'margin-bottom: 15px; padding: 10px;',
        ),
    ) );
    //H2 size
    $wp_customize->add_setting(
        'h2_size',
        array(
            'sanitize_callback' => 'absint',
            'capability'        => 'edit_theme_options',
            'default'           => '42',
        )       
    );
    $wp_customize->add_control( 'h2_size', array(
        'type'        => 'number',
        'priority'    => 18,
        'section'     => 'newsanchor_fonts',
        'label'       => __('H2 font size', 'newsanchor'),
        'input_attrs' => array(
            'min'   => 10,
            'max'   => 60,
            'step'  => 1,
            'style' => 'margin-bottom: 15px; padding: 10px;',
        ),
    ) );
    //H3 size
    $wp_customize->add_setting(
        'h3_size',
        array(
            'sanitize_callback' => 'absint',
            'capability'        => 'edit_theme_options',
            'default'           => '32',
        )       
    );
    $wp_customize->add_control( 'h3_size', array(
        'type'        => 'number',
        'priority'    => 19,
        'section'     => 'newsanchor_fonts',
        'label'       => __('H3 font size', 'newsanchor'),
        'input_attrs' => array(
            'min'   => 10,
            'max'   => 60,
            'step'  => 1,
            'style' => 'margin-bottom: 15px; padding: 10px;',
        ),
    ) );
    //H4 size
    $wp_customize->add_setting(
        'h4_size',
        array(
            'sanitize_callback' => 'absint',
            'capability'        => 'edit_theme_options',
            'default'           => '25',
        )       
    );
    $wp_customize->add_control( 'h4_size', array(
        'type'        => 'number',
        'priority'    => 20,
        'section'     => 'newsanchor_fonts',
        'label'       => __('H4 font size', 'newsanchor'),
        'input_attrs' => array(
            'min'   => 10,
            'max'   => 60,
            'step'  => 1,
            'style' => 'margin-bottom: 15px; padding: 10px;',
        ),
    ) );
    //H5 size
    $wp_customize->add_setting(
        'h5_size',
        array(
            'sanitize_callback' => 'absint',
            'capability'        => 'edit_theme_options',
            'default'           => '20',
        )       
    );
    $wp_customize->add_control( 'h5_size', array(
        'type'        => 'number',
        'priority'    => 21,
        'section'     => 'newsanchor_fonts',
        'label'       => __('H5 font size', 'newsanchor'),
        'input_attrs' => array(
            'min'   => 10,
            'max'   => 60,
            'step'  => 1,
            'style' => 'margin-bottom: 15px; padding: 10px;',
        ),
    ) );
    //H6 size
    $wp_customize->add_setting(
        'h6_size',
        array(
            'sanitize_callback' => 'absint',
            'capability'        => 'edit_theme_options',
            'default'           => '18',
        )       
    );
    $wp_customize->add_control( 'h6_size', array(
        'type'        => 'number',
        'priority'    => 22,
        'section'     => 'newsanchor_fonts',
        'label'       => __('H6 font size', 'newsanchor'),
        'input_attrs' => array(
            'min'   => 10,
            'max'   => 60,
            'step'  => 1,
            'style' => 'margin-bottom: 15px; padding: 10px;',
        ),
    ) );
    //Body
    $wp_customize->add_setting(
        'body_size',
        array(
            'sanitize_callback' => 'absint',
            'capability'        => 'edit_theme_options',
            'default'           => '14',
        )       
    );
    $wp_customize->add_control( 'body_size', array(
        'type'        => 'number',
        'priority'    => 23,
        'section'     => 'newsanchor_fonts',
        'label'       => __('Body font size', 'newsanchor'),
        'input_attrs' => array(
            'min'   => 10,
            'max'   => 24,
            'step'  => 1,
            'style' => 'margin-bottom: 15px; padding: 10px;',
        ),
    ) );

    //___Colors___//
    $wp_customize->add_setting(
        'primary_color',
        array(
            'default'           => '#16a1e7',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_hex_color',
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'primary_color',
            array(
                'label'         => __('Primary color', 'newsanchor'),
                'section'       => 'colors',
                'settings'      => 'primary_color',
                'priority'      => 11
            )
        )
    );
    //Site desc
    $wp_customize->add_setting(
        'site_desc_color',
        array(
            'default'           => '#424347',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'site_desc_color',
            array(
                'label' => __('Site description', 'newsanchor'),
                'section' => 'colors',
                'priority' => 14
            )
        )
    ); 
    //Header bg
    $wp_customize->add_setting(
        'site_header_bg',
        array(
            'default'           => '#ffffff',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'site_header_bg',
            array(
                'label' => __('Header background', 'newsanchor'),
                'section' => 'colors',
                'priority' => 15
            )
        )
    );  
    //Menu bg
    $wp_customize->add_setting(
        'menu_bg_color',
        array(
            'default'           => '#222',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage'            
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'menu_bg_color',
            array(
                'label' => __('Menu background', 'newsanchor'),
                'section' => 'colors',
                'priority' => 16
            )
        )
    );
    //Menu color scheme
    $wp_customize->add_setting(
        'menu_color_1',
        array(
            'default'           => '#fe2d18',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_hex_color',
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'menu_color_1',
            array(
                'label' => __('Menu color scheme (on item hover)', 'newsanchor'),
                'section' => 'colors',
                'priority' => 17
            )
        )
    );
    $wp_customize->add_setting(
        'menu_color_2',
        array(
            'default'           => '#91ce29',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_hex_color',
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'menu_color_2',
            array(
                'section' => 'colors',
                'priority' => 17
            )
        )
    );
    $wp_customize->add_setting(
        'menu_color_3',
        array(
            'default'           => '#ff9600',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_hex_color',
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'menu_color_3',
            array(
                'section' => 'colors',
                'priority' => 18
            )
        )
    );
    $wp_customize->add_setting(
        'menu_color_4',
        array(
            'default'           => '#b22234',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_hex_color',
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'menu_color_4',
            array(
                'section' => 'colors',
                'priority' => 19
            )
        )
    ); 
    $wp_customize->add_setting(
        'menu_color_5',
        array(
            'default'           => '#c71c77',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_hex_color',
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'menu_color_5',
            array(
                'section' => 'colors',
                'priority' => 20
            )
        )
    );   
    //Body
    $wp_customize->add_setting(
        'body_text_color',
        array(
            'default'           => '#767676',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'body_text_color',
            array(
                'label' => __('Body text', 'newsanchor'),
                'section' => 'colors',
                'priority' => 21
            )
        )
    );  
    //Footer widget area
    $wp_customize->add_setting(
        'footer_widgets_background',
        array(
            'default'           => '#222',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'footer_widgets_background',
            array(
                'label' => __('Footer widget area background', 'newsanchor'),
                'section' => 'colors',
                'priority' => 22
            )
        )
    );
    //Footer widget color
    $wp_customize->add_setting(
        'footer_widgets_color',
        array(
            'default'           => '#949494',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'footer_widgets_color',
            array(
                'label' => __('Footer widgets color', 'newsanchor'),
                'section' => 'colors',
                'priority' => 23
            )
        )
    ); 
    //Footer background
    $wp_customize->add_setting(
        'footer_background',
        array(
            'default'           => '#1e1e1e',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'footer_background',
            array(
                'label' => __('Credits background', 'newsanchor'),
                'section' => 'colors',
                'priority' => 24
            )
        )
    );       
}
add_action( 'customize_register', 'newsanchor_customize_register' );

/**
 * Sanitize
 */
//Text
function newsanchor_sanitize_text( $input ) {
    return wp_kses_post( force_balance_tags( $input ) );
}
//Checkboxes
function newsanchor_sanitize_checkbox( $input ) {
    if ( $input == 1 ) {
        return 1;
    } else {
        return '';
    }
}
//Integers
function newsanchor_sanitize_int( $input ) {
    if( is_numeric( $input ) ) {
        return intval( $input );
    }
}

//Footer widget areas
function newsanchor_sanitize_fw( $input ) {
    $valid = array(
        '1'     => __('One', 'newsanchor'),
        '2'     => __('Two', 'newsanchor'),
        '3'     => __('Three', 'newsanchor'),
        '4'     => __('Four', 'newsanchor')
    );
    if ( array_key_exists( $input, $valid ) ) {
        return $input;
    } else {
        return '';
    }
}

//Blog Layout
function newsanchor_sanitize_blog( $input ) {
    $valid = array(
        'classic'           => __( 'Classic', 'newsanchor' ),
        'fullwidth'         => __( 'Full width (no sidebar)', 'newsanchor' ),
        'masonry-layout'    => __( 'Masonry (grid style)', 'newsanchor' )

    );
    if ( array_key_exists( $input, $valid ) ) {
        return $input;
    } else {
        return '';
    }
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function newsanchor_customize_preview_js() {
	wp_enqueue_script( 'newsanchor_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20130508', true );
}
add_action( 'customize_preview_init', 'newsanchor_customize_preview_js' );
