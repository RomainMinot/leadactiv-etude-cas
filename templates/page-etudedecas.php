<?php
/*
    Template Name: Listing études de cas
*/

get_header();

// Récupération des champs ACF pour l'entête
$group_64be5a65a1927 = acf_get_fields('group_64be5a65a1927');
$entete = [];
$blocs = [];

foreach (is_array($group_64be5a65a1927) ? $group_64be5a65a1927 : [] as $field) {
    if (trim($field['name']) != '')
        $entete[$field['name']] = get_field($field['key']);
}

// Récupération des études de cas pour le carrousel
$etudes_cas_carousel = get_field('etudes_cas'); // Champ ACF de type relation pour les études de cas du carrousel

// Récupération de toutes les études de cas pour le reste de la page
$all_etudes_de_cas = \Genesii\PostType\EtudeDeCas::findAll();

?>

<main class="page__etude">
    <section class="page__etude--header py-3 py-md-8 bg-light-gray">
        <div class="container__lg">
            <div class="col-12 text-center">
                <?php if ($entete["etiquette"]): ?>
                    <h1 class="sub-head"><?php echo esc_html($entete["etiquette"]); ?></h1>
                <?php endif; ?>
                <?php if ($entete["titre"]): ?>
                    <h2 class="big-title mt-0 mb-5 f-48 text-darck-green"><?php echo esc_html($entete["titre"]); ?></h2>
                <?php endif; ?>
            </div>

            <div class="col-12">
                <div id="carouselEtudesDeCas" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <?php
                        // Initialisation du compteur
                        $cptloop = 0;

                        // Vérification que des études de cas ont été récupérées
                        if (!empty($etudes_cas_carousel)) {
                            // Boucle sur chaque étude de cas pour le carrousel
                            foreach ($etudes_cas_carousel as $etude):
                                $etude_fields = get_fields($etude->ID); // Récupération des champs ACF pour chaque étude
                                ?>
                                <div class="carousel-item <?php echo ($cptloop == 0) ? 'active' : ''; ?>">
                                    <div class="row justify-content-center">
                                        <div class="col-md-12">
                                            <a href="<?php echo esc_url(get_permalink($etude->ID)); ?>"
                                                class="card-link w-100 text-decoration-none">
                                                <div class="card h-100 p-4 w-100 d-flex ">
                                                    <div class="col-12 col-lg-6 col-md-6 d-flex flex-column">
                                                        <div class="card-logo-container mb-4">
                                                            <?php if (!empty($etude_fields["logo_client"])): ?>
                                                                <img class="card-logo lazyload"
                                                                    src="<?php echo esc_url($etude_fields["logo_client"]["url"]); ?>"
                                                                    alt="<?php echo esc_attr($etude_fields["logo_client"]["alt"]); ?>">
                                                            <?php endif; ?>
                                                        </div>
                                                        <?php if (!empty(get_field('phrase_accroche', $etude->ID))): ?>
                                                            <h3 class="f-36 mt-0 mb-4">
                                                                <?php
                                                                $phrase_accroche = get_field('phrase_accroche', $etude->ID);
                                                                echo esc_html(strip_tags($phrase_accroche));
                                                                ?>
                                                            </h3>
                                                        <?php endif; ?>

                                                        <div class="f-16 card--description mb-4 mt-auto">
                                                            <?php
                                                            $text = get_field('accroche', $etude->ID);
                                                            echo esc_html(strip_tags($text)); // Affiche la description complète sans limitation de mots
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <div
                                                        class="col-12 col-lg-6 col-md-6 d-flex align-items-center justify-content-center me-5">
                                                        <figure class="card--img">
                                                            <img class="img-fluid lazyload"
                                                                src="<?php echo esc_url(get_the_post_thumbnail_url($etude->ID, 'medium')); ?>"
                                                                alt="<?php echo esc_attr(get_the_title($etude->ID)); ?>">
                                                        </figure>
                                                    </div>
                                                    <div class="background-overlay"></div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                $cptloop++;
                            endforeach;
                        } else {
                            echo '<div class="alert alert-warning">Aucune étude de cas sélectionnée pour le carrousel.</div>';
                        }
                        ?>
                    </div>
                    <ul class="carousel-indicators">
                        <?php for ($i = 0; $i < $cptloop; $i++): ?>
                            <li data-bs-target="#carouselEtudesDeCas" data-bs-slide-to="<?php echo $i; ?>"
                                class="<?php echo ($i === 0) ? 'active' : ''; ?>"></li>
                        <?php endfor; ?>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section class="page__etude--content position-relative " id="decouvrir">
        <div class="container__lg">
            <div class="py-3 py-md-8">
                <div class="row">
                    <div class="col-12">
                        <?php
                        $filtres = get_terms(array('taxonomy' => 'typeetudedecas'));
                        if (count($filtres) > 0): ?>
                            <div class="page__etude--content--top">
                                <div class="page__etude--content--top--filtres-container">
                                    <div
                                        class="page__etude--content--top--filtres d-md-flex align-items-center justify-content-start grid--actus--filters flex-wrap">
                                        <a class="filter-link f-14 grid--actus--filter all active"
                                            data-filter="*"><?php _e('Tous') ?></a>
                                        <?php $cpt = 0;
                                        foreach ($filtres as $filtre):
                                            $cpt++; ?>
                                            <div class="page__etude--content--top--filtres--item">
                                                <a class="filter-link f-14 d-block grid--actus--filter"
                                                    data-filter=".<?php echo $filtre->slug; ?>"><?php echo $filtre->name; ?></a>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="row g-4 pt-4 pb-4 pb-md-5 page__etude--content--grid grid--actus">
                    <?php
                    $cptloop = 0;
                    if ($all_etudes_de_cas->have_posts()):
                        while ($all_etudes_de_cas->have_posts()):
                            $all_etudes_de_cas->the_post(); ?>
                            <div
                                class="col-12 col-md-6 col-lg-6 page__etude--content--grid--item grid--actus--items <?php if (get_the_terms(get_the_ID(), 'typeetudedecas')) {
                                    $cpt = 1;
                                    foreach (get_the_terms(get_the_ID(), 'typeetudedecas') as $term):
                                        echo $term->slug . ' '; endforeach;
                                } ?>">
                                <?php echo do_shortcode('[leadactiv-content-etude id=' . get_the_ID() . ']'); ?>
                            </div>

                            <?php $cptloop++; ?>

                        <?php endwhile;
                        wp_reset_postdata(); else: ?>
                        <div class="col-12"><?php esc_html_e('Désolé, aucune études de cas disponibles.'); ?></div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <section class="cta-section">
        <div class="container__lg">
            <div class="py-3 py-md-8">
                <h2 class="cta-title">
                    <span class="light-text">Nous prospectons,</span>
                    <br>
                    <strong>vous vendez</strong>
                </h2>
                <div class="cta-buttons">
                    <a href="<?php echo home_url('/prendre-rendez-vous/'); ?>" class="btn color-btn-dark">Prendre
                        rendez-vous</a>
                    <a href="<?php echo home_url('/contact/'); ?>" class="btn btn-purple-black">Nous contacter</a>
                </div>
            </div>
        </div>
    </section>
</main>

<?php
get_footer();
