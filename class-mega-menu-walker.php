<?php
class Mega_Menu_Walker extends Walker_Nav_Menu {
    private $mega_menu_item;

    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $indent = ($depth) ? str_repeat("\t", $depth) : '';
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;

        $is_mega_menu = get_post_meta($item->ID, '_menu_item_is_mega_menu', true);
        if ($depth === 0 && $is_mega_menu === 'yes') {
            $classes[] = 'mega-menu-item';
            $this->mega_menu_item = $item;
        }

        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args, $depth));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

        $id = apply_filters('nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args, $depth);
        $id = $id ? ' id="' . esc_attr($id) . '"' : '';

        $output .= $indent . '<li' . $id . $class_names .'>';

        $atts = array();
        $atts['title']  = !empty($item->attr_title) ? $item->attr_title : '';
        $atts['target'] = !empty($item->target)     ? $item->target     : '';
        $atts['rel']    = !empty($item->xfn)        ? $item->xfn        : '';
        $atts['href']   = !empty($item->url)        ? $item->url        : '';

        $atts = apply_filters('nav_menu_link_attributes', $atts, $item, $args, $depth);

        $attributes = '';
        foreach ($atts as $attr => $value) {
            if (!empty($value)) {
                $value = ('href' === $attr) ? esc_url($value) : esc_attr($value);
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }

        $item_output = $args->before;
        $item_output .= '<a'. $attributes .'>';
        $item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
        if ($depth === 0 && $is_mega_menu === 'yes') {
            $item_output .= '<span class="mega-menu-arrow">▼</span>';
        }
        $item_output .= '</a>';
        $item_output .= $args->after;

        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);

        // Generate mega menu content for top-level items
        if ($depth === 0 && $is_mega_menu === 'yes') {
            $output .= $this->generate_mega_menu_content();
        }
    }

    private function generate_mega_menu_content() {
        $output = '<div class="mega-menu"><div class="mega-menu-content">';
        
        for ($i = 1; $i <= 3; $i++) {
            $column_title = get_theme_mod("mega_menu_column_{$i}_title");
            $column_menu_id = get_theme_mod("mega_menu_column_{$i}_menu");
            
            if (!empty($column_menu_id)) {
                $output .= '<div class="mega-column">';
              
                
                $column_menu_items = wp_get_nav_menu_items($column_menu_id);
                if ($column_menu_items) {
                    $output .= '<ul class="column-menu">';
                if (!empty($column_title)) {
                    $output .= '<h3>' . esc_html($column_title) . '</h3>';
                }
                    foreach ($column_menu_items as $menu_item) {
                        $output .= '<li class="mega-li"><a href="' . esc_url($menu_item->url) . '">' . esc_html($menu_item->title) . '</a></li>';
                    }
                    $output .= '</ul>';
                }
                $output .= '</div>';
            }
        }
        
        $output .= '</div></div>';
        return $output;
    }

    public function end_el(&$output, $item, $depth = 0, $args = null) {
        $output .= "</li>\n";
    }

    public function start_lvl(&$output, $depth = 0, $args = null) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class=\"sub-menu\">\n";
    }

    public function end_lvl(&$output, $depth = 0, $args = null) {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul>\n";
    }
}