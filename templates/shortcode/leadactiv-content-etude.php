<?php
$id = get_the_ID();

if (isset($args) && array_key_exists('id', $args)) {
    $id = $args['id'];
}

$etude_fields = get_fields($id);
?>
<div class="card h-100 w-100 bg-light-gray">
    <a href="<?php echo esc_url(get_permalink($id)); ?>" class="card-link w-100">
        <div class="card-body d-flex flex-column">
            <!-- Card Header for Logo and Tag -->
            <div class="card-header-etude d-flex justify-content-between align-items-start m-0 p-0">
                <div class="card-logo-container">
                    <?php if ($etude_fields["logo_client"]): ?>
                        <img class="card-logo" src="<?php echo esc_url($etude_fields["logo_client"]["url"]); ?>" alt="<?php echo esc_attr($etude_fields["logo_client"]["alt"]); ?>">
                    <?php endif; ?>
                </div>
                <div class="tag-container m-0 p-0">
                    <?php
                    $terms = get_the_terms($id, 'typeetudedecas');
                    if ($terms):
                        foreach ($terms as $term): ?>
                            <span class="tag mb-1 tag-<?php echo esc_attr($etude_fields["couleur"]); ?>">
                                <?php echo esc_html($term->name); ?>
                            </span>
                        <?php endforeach; endif; ?>
                </div>
            </div>
            <!-- Title and Description -->
            
            <?php if (get_field('phrase_accroche', get_the_ID())): ?>
                        <h3 class="f-22 card--title mt-4 mb-4">
                            <?php echo get_field('phrase_accroche', get_the_ID()); ?>
                        </h3>
                    <?php endif; ?>
            <div class="f-16 card--description mb-3 col-12 col-md-9">
                <?php
                $text = strip_tags(get_field('accroche', $id));
                $words = preg_split("/[\s,]+/", $text);
                $word_limit = 15;
                $excerpt = implode(' ', array_slice($words, 0, $word_limit));

                if (count($words) > $word_limit) {
                    $excerpt .= '...';
                }

                echo esc_html($excerpt);
                ?>
            </div>
        </div>
    </a>
</div>
