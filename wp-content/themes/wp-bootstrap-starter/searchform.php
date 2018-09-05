<?php /*?><form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <label>
        <input type="search" class="search-field form-control" placeholder="<?php echo esc_attr_x( 'Search &hellip;', 'placeholder', 'wp-bootstrap-starter' ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>" name="s" title="<?php _ex( 'Search for:', 'label', 'wp-bootstrap-starter' ); ?>">
    </label>
    <button type="submit" class="search-submit btn"><i class="fal fa-search"></i></button>
</form><?php */?>


<section id="search_filter_register_widget-2" class="widget_search_filter_register_widget">
    <form data-sf-form-id='532' data-is-rtl='0' data-maintain-state='1' data-results-url=<?php echo get_site_url(); ?>/recherche' data-ajax-url='<?php echo get_site_url(); ?>/recherche&amp;sf_data=results' data-ajax-form-url=<?php echo get_site_url(); ?>/?sfid=532&amp;sf_action=get_data&amp;sf_data=form' data-display-result-method='archive' data-use-history-api='1' data-template-loaded='0' data-lang-code='' data-ajax='1' data-ajax-data-type='html' data-ajax-target='#main' data-ajax-pagination-type='normal' data-ajax-links-selector='.pagination a' data-update-ajax-url='1' data-only-results-ajax='1' data-scroll-to-pos='0' data-init-paged='1' data-auto-update='' action='<?php echo get_site_url(); ?>/recherche' method='post' class='searchandfilter' id='search-filter-form-532' autocomplete='off' data-instance-count='1'>
        <ul class="m-0 p-0">
            <li class="sf-field-search m-0 p-0" data-sf-field-name="search" data-sf-field-type="search" data-sf-field-input-type="">		 <label>
           
        <input type="search" class="search-field form-control" placeholder="<?php echo esc_attr_x( 'Search &hellip;', 'placeholder', 'wp-bootstrap-starter' ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>"  name="_sf_search[]" title="<?php _ex( 'Search for:', 'label', 'wp-bootstrap-starter' ); ?>"  title="Rechercher">
        </label>
            </li>
            <li class="m-0 p-0">
            <button type="submit" class="search-submit btn" data-sf-field-name="submit" data-sf-field-type="submit" data-sf-field-input-type="" name="_sf_submit" value="Submit"><i class="fal fa-search"></i></button>
            </li>
         </ul></form>
</section>


