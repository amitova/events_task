<?php
/**
 * The template used to display archive content
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <header class="entry-header">
        <h2 class="entry-title">ALL Events</h2>
    </header><!-- .entry-header -->

    <div class="entry-content">
        <?php the_content(); ?>

        <div style="clear: both; margin-bottom: 30px;"></div><!-- clears the floating -->

        <?php
        $args = array(
            'post_type' => 'events',
            'meta_key' => 'event_date',
            'orderby' => 'meta_value_num',
            'order' => 'DESC',
        );
        $my_query = new WP_Query($args);

        //echo "<pre>".print_r($my_query,true)."</pre>"; die();
        if ($my_query->have_posts()) {


            $counter = 1;
            ?>

            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Date</th>
                        <th>Location</th>
                        <th>URL</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($my_query->have_posts()) {
                        $my_query->the_post();
                        $myfields = get_post_custom($post_id)
                        ?>
                        <tr>  
                            <td><?= the_title(); ?></td>
                            <td><?= $myfields['event_location'][0] ?></td>
                            <td><?= $myfields['event_date'][0] ?></td>
                            <td><?= $myfields['event_url'][0] ?></td>
                        </tr>
                        <?php //echo "<pre>". print_r(get_post_custom($post_id),true)."</pre>";?>
                        <?php
                        $counter++;
                    }
                    ?>
                </tbody>
            </table>
            <?php
            wp_reset_postdata();
        }
        ?>

    </div><!-- .entry-content -->

</article><!-- #post-## -->
