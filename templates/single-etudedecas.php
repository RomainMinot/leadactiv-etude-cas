<?php
get_header();

$case_study_id = get_the_ID();
$case_study = get_fields($case_study_id);
$sectors = get_the_terms($case_study_id, 'typeetudedecas');
$fonctions = get_the_terms($case_study_id, 'fonction');
$localisations = get_the_terms($case_study_id, 'localisation');

$logo_bg_head_url = wp_get_attachment_url(2839);
$play_logo_url = wp_get_attachment_url(3787);
$logo_bg_about_url = wp_get_attachment_url(3788);
$quote_icon_url = wp_get_attachment_url(3796);
$quote_icon_url_alt = wp_get_attachment_url(3797);

$case_color = $case_study['couleur'] && $case_study['couleur'] !== 'tag-white' ? $case_study['couleur'] : 'tag-gray';
?>

<main class="single__etude">
    <!-- Header -->
    <section class="single__etude--header position-relative bg-white">
        <div class="container__lg">
            <div class="py-6 py-md-8">
                <div class="row align-items-center justify-content-between">
                    <!-- Tags -->
                    <div class="single__etude__tags mb-5 mb-md-4 d-flex align-items-center flex-wrap flex-md-nowrap justify-content-start">
                        <div>
                            <span class="label f-14 mb-1">Secteur</span>
                            <div>
                                <?php 
                                    if ($sectors):
                                        foreach ($sectors as $sector): 
                                ?>
                                    <span class="tag mb-1 tag-<?php echo $case_color ?>">
                                        <?php echo $sector->name; ?>
                                    </span>
                                <?php       
                                        endforeach; 
                                    endif; 
                                ?>
                            </div>
                        </div>
                        <div>
                            <span class="label f-14 mb-1">Fonction ciblée</span>
                            <div class="d-flex gap-2">
                                <?php 
                                    if ($fonctions):
                                        foreach ($fonctions as $fonction): 
                                ?>
                                    <span class="tag mb-1 tag-gray">
                                        <?php echo $fonction->name; ?>
                                    </span>
                                <?php 
                                        endforeach; 
                                    endif; 
                                ?>
                            </div>
                        </div>
                        <div>
                            <span class="label f-14 mb-1">Localisation</span>
                            <div class="d-flex gap-2">
                                <?php 
                                    if ($localisations):
                                        foreach ($localisations as $localisation): 
                                ?>
                                    <span class="tag mb-1 tag-gray">
                                        <?php echo $localisation->name; ?>
                                    </span>
                                <?php 
                                        endforeach; 
                                    endif; 
                                ?>
                            </div>
                        </div>
                    </div>
                    <!-- Texts -->
                    <div class="col-12 col-md-6 d-flex flex-column align-items-start position-relative pe-4">
                        <?php
                        $etude_fields = get_fields(get_the_ID());
                        if ($etude_fields["logo_client"]): ?>
                            <div class="header-logo">
                                <img src="<?php echo $etude_fields["logo_client"]["url"] ?>"
                                    alt="<?php echo $etude_fields["logo_client"]["alt"] ?>">
                            </div>
                        <?php endif; ?>

                        <?php if (get_field('phrase_accroche', get_the_ID())): ?>
                            <h1 class="f-48 my-1">
                                <?php echo get_field('phrase_accroche', get_the_ID()); ?>
                            </h1>
                        <?php endif; ?>

                        <?php if (get_field('accroche', get_the_ID())): ?>
                            <div class="single__etude--header--descr f-16 mt-3 mb-4">
                                <?php echo get_field('accroche', get_the_ID()); ?>
                            </div>
                        <?php endif; ?>
                        
                    </div>
                    <!-- Video -->
                    <div class="col-12 col-md-6 d-flex justify-content-center align-items-center">
                        <?php if ($media = get_field('media')): ?>
                            <div class="header-media border-radius">
                                <?php if ($media['type_de_media'] == 'Youtube' && $media['url_youtube']): ?>
                                    <div class="video-container">
                                        <div class="video-thumbnail" style="position: relative;">
                                            <img src="<?php echo esc_url($media['miniature']['url']); ?>"
                                                alt="<?php echo esc_attr($media['miniature']['alt']); ?>"
                                                >
                                            <div class="video-overlay" >
                                                <img src="<?php echo $play_logo_url ?>">
                                            </div>
                                        </div>
                                        <div class="video-embed">
                                            <?php echo $media['url_youtube']; // This will output the oEmbed content ?>
                                        </div>
                                    </div>
                                <?php elseif ($media['type_de_media'] == 'Vidéo' && $media['fichier_video']): ?>
                                    <video width="100%" height="100%" showinfo=0 controls=0
                                        poster="<?php echo esc_url($media['miniature']['url']); ?>">
                                        <source src="<?php echo esc_url($media['fichier_video']['url']); ?>" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                <?php elseif ($media['type_de_media'] == 'Image' && $media['image']): ?>
                                    <img src="<?php echo esc_url($media['image']['url']); ?>"
                                        alt="<?php echo esc_attr($media['image']['alt']); ?>">
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                        
                    </div>
                </div>
            </div>
        </div>
        <img src="<?php echo $logo_bg_head_url ?>" alt="Logo back" class="img-fluid position-absolute background-image-left">
    </section>
    <!-- Chiffres -->                        
    <?php 
        $lames = get_field('lames_contenu', get_the_ID());
        $filtered_chiffres = array_filter($lames, function($bloc) {
            return $bloc['acf_fc_layout'] == 'lame_chiffres';
        }) ?: [];
        $lames_loop = array_filter($lames, function($bloc) {
            return $bloc['acf_fc_layout'] != 'lame_chiffres' && $bloc['acf_fc_layout'] != 'lame_etudes_cas';
        }) ?: [];
        $filtered_etudes_cas = array_filter($lames, function($bloc) {
            return $bloc['acf_fc_layout'] == 'lame_etudes_cas';
        }) ?: [];
        foreach (is_array($filtered_chiffres) ? $filtered_chiffres : [] as $bloc):
    ?>
        <section class="page__etude--chiffres d-flex overflow-hidden justify-content-center position-relative bg-dark-green">
            <div class="container__lg">                          
                <div class="d-flex flex-column flex-md-row h-100">
                    <div class="page__etude--chiffres__left text-white d-flex flex-column">
                        <h2 class="f-32 mt-0 mb-3">La collaboration en quelques chiffres</h2>
                        <p class="w-75">*Rendez-vous qualifié : rendez-vous réalisé avec un prospect respectant les critères de ciblage définis par le client</p>
                    </div>
                    <div class="page__etude--chiffres__right d-flex flex-column flex-md-row justify-content-center align-items-center">
                        <?php 
                            foreach (is_array($bloc['chiffres']) ? $bloc['chiffres'] : [] as $index => $chiffre): 
                        ?>
                            <div class="d-flex flex-column align-items-start text-start">
                                <h3 class="page__etude--chiffres--chiffre mt-0 mb-2"><?php echo $chiffre['chiffre']; ?></h3>
                                <?php if ($chiffre['legende']): ?>
                                    <p class="page__etude--chiffres--legend mb-0"><?php echo $chiffre['legende']; ?></p>
                                <?php endif; ?>
                            </div>
                        <?php 
                            if ($index !== count($bloc['chiffres']) -1):
                            echo '<div class="vr"></div>';
                            endif;
                        ?>
                        <?php 
                            endforeach; 
                        ?>
                    </div>
                </div>
            </div>
        </section>
    <?php 
        endforeach; 
    ?>
    <!-- Content -->
    <div class="position-relative d-flex align-items-center overflow-hidden">
        <div class="container__lg">
            <div class="py-3 py-md-8">
                <div class="position-relative row align-items-top justify-content-end">
                    <!-- Sticky nav -->
                    <div class="col-12 col-md-6 col-lg-4 px-auto pr-md-4">
                        <div class="single__etude__sticky bg-light-gray d-flex flex-column gap-5">
                            <div>
                                <?php
                                if ($etude_fields["logo_client"]): 
                                ?>
                                <div class="header-logo">
                                    <img src="<?php echo $etude_fields["logo_client"]["url"] ?>" alt="<?php echo $etude_fields["logo_client"]["alt"] ?>">
                                </div>
                                <?php 
                                endif; 
                                ?>
                                <div class="single__etude__sticky__specs">
                                    <div>
                                        <span class="label f-14 mb-1">Secteur</span>
                                        <div>
                                            <?php 
                                                if ($sectors):
                                                    foreach ($sectors as $sector): 
                                            ?>
                                                <span class="tag mb-1 tag-<?php echo $case_color ?>">
                                                    <?php echo $sector->name; ?>
                                                </span>
                                            <?php       
                                                    endforeach; 
                                                endif; 
                                            ?>
                                        </div>
                                    </div>
                                    <div>
                                        <span class="label f-14 mb-1">Création</span>
                                        <div>
                                            <span class="tag mb-1 tag-white">
                                                <?php echo $etude_fields["date_de_creation"]; ?>
                                            </span>
                                        </div>
                                    </div>
                                    <div>
                                        <span class="label f-14 mb-1">Basé à</span>
                                        <div>
                                            <span class="tag mb-1 tag-white">
                                                <?php echo $etude_fields["base_a"]; ?>
                                            </span>
                                        </div>
                                    </div>
                                    <div>
                                        <span class="label f-14 mb-1">Employés</span>
                                        <div>
                                            <span class="tag mb-1 tag-white">
                                                <?php echo $etude_fields["nombre_demployes"]; ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div>
                                <ul class="single__etude__sticky__sections">
                                    <li class="single__etude__sticky__item single__etude__sticky__item--active" data-anchor="a_propos">01. À propos de Geotrend</li>
                                    <li class="single__etude__sticky__item" data-anchor="problematique">02. La problématique</li>
                                    <li class="single__etude__sticky__item" data-anchor="accompagnement">03. L'accompagnement</li>
                                    <li class="single__etude__sticky__item" data-anchor="pourquoi">04. Pourquoi <?php echo get_the_title(); ?> recommande Leadactiv</li>
                                </ul>
                            </div>
                        </div>
                        <div class="landmark__sticky w-100"></div>
                    </div>
                    <!-- Right part -->
                    <div class="col-12 col-md-6 col-lg-8 justify-content-left px-auto pl-md-4">
                        <!-- À propos -->
                        <?php 
                        foreach (is_array($lames_loop) ? $lames_loop : [] as $bloc):
                            switch ($bloc['acf_fc_layout']):
                                case 'lame_a_propos': 
                        ?>
                        <section id="a_propos" class="single__etude__section lame_listes_texte">
                            <div class="lame_listes_texte__content bg-light-purple">
                                <?php if (!empty($bloc["titre"])): ?>
                                    <h2 class="m-0 f-48"><?php echo $bloc["titre"] ?></h2>
                                <?php endif; ?>
                                <?php if (!empty($bloc["texte"])): ?>
                                    <div class="lame_listes_texte__content--texts f-16"><?php echo $bloc["texte"] ?></div>
                                <?php endif; ?>
                                <?php if (!empty($bloc["bouton"])): ?>
                                    <a class="btn color-btn-dark" href="<?php echo $bloc["bouton"]['url'] ?>"
                                        target="<?php echo $bloc["bouton"]['target'] ?>"><?php echo $bloc["bouton"]['title'] ?></a>
                                <?php endif; ?>
                                <?php 
                                    if ($logo_bg_about_url):
                                        echo '<img src="' . esc_url($logo_bg_about_url) . '" alt="Background logo" class="lame_listes_texte__content--logo"/>';
                                    endif; 
                                ?>
                            </div>
                        </section>
                        <!-- Problématique -->
                        <?php 
                                break; 
                                case 'lame_problematique': 
                        ?>
                        <section id="problematique" class="single__etude__section pb-6 border-bottom">
                            <!-- Problématique -->
                            <article class="px-0 px-md-6 pt-4 pb-5 pt-md-6">   
                                <h3 class="m-0 mb-4 f-48">La problématique</h3>
                                <div class="lame_listes_texte__content--texts f-16 mt-3"><?php echo $bloc["problematique"] ?></div>
                            </article>
                            <!-- Témoignage -->
                            <?php get_template_part('template-parts/card-quote-etude-cas', null, array(
                                'colorType' => 'peach',
                                'auteur' => $bloc["auteur"],
                                'citation' => $bloc["citation"],
                                'quote_icon_url' => $quote_icon_url
                            )); ?>
                        </section>
                        <!-- Accompagnement -->
                        <?php 
                                break; 
                                case 'lame_accompagnement': 
                                    $citation_haut = $bloc["citation_haut"];
                                    $citation_bas = $bloc["citation_bas"];
                        ?>
                        <section id="accompagnement" class="single__etude__section pb-6 border-bottom">
                            <!-- Problématique -->
                            <article class="px-0 px-md-6 pt-5 pb-3 pt-md-6">   
                                <h3 class="m-0 mb-4 f-48">L'accompagnement</h3>
                            </article>
                            <!-- Témoignage haut -->
                            <?php get_template_part('template-parts/card-quote-etude-cas', null, array(
                                'colorType' => 'green',
                                'auteur' => $citation_haut["auteur"],
                                'citation' => $citation_haut["citation"],
                                'quote_icon_url' => $quote_icon_url_alt
                            )); ?>
                            <!-- Liste de services -->
                            <article>   
                                <h3 class="m-0 f-32 px-0 px-md-6 py-5 pt-md-6 lh-sm"><?php echo $bloc["titre_intermediaire"] ?></h3>
                                <?php 
                                    $campaigns = $bloc["campagnes"];
                                    if (is_array($campaigns)):
                                ?>
                                <div class="d-flex flex-column gap-3 mb-5 mb-md-0">
                                    <?php 
                                    foreach ($campaigns as $index =>$campaign):
                                        get_template_part('template-parts/card-campaign-etude-cas', null, array(
                                            'campaign' => $campaign["campagne"],
                                            'index' => $index + 1
                                        )); 
                                    endforeach;
                                    ?>
                                </div>
                                <?php 
                                    endif;
                                ?>
                            </article>
                            
                            <!-- Témoignage bas -->
                            <?php get_template_part('template-parts/card-quote-etude-cas', null, array(
                                'colorType' => 'peach',
                                'auteur' => $citation_bas["auteur"],
                                'citation' => $citation_bas["citation"],
                                'quote_icon_url' => $quote_icon_url
                            )); ?>
                        </section>
                        <!-- Pourquoi -->
                        <?php 
                                break; 
                                case 'lame_pourquoi': 
                        ?>
                        <section id="pourquoi" class="single__etude__section pb-4 pb-md-6">
                            <article class="px-0 px-md-6 pt-5 pb-4 pt-md-6">   
                                <h3 class="m-0 mb-4 f-48">Pourquoi <?php echo get_the_title(); ?> recommande Leadactiv</h3>
                            </article>
                            <!-- Témoignage -->
                            <?php get_template_part('template-parts/card-quote-etude-cas', null, array(
                                'colorType' => 'peach',
                                'auteur' => $citation_bas["auteur"],
                                'citation' => $citation_bas["citation"],
                                'quote_icon_url' => $quote_icon_url,
                                'has_bottom' => true
                            )); ?>
                            <!-- More -->
                            <div class="lame_listes_texte__content bg-light-purple mt-6">
                                <div class="z-2 w-100 gap-5 d-flex flex-column align-items-center justify-content-center">
                                    <h3 class="text-center text-md-start m-0 f-36">Envie d’en voir plus ?</h3>
                                    <?php if (!empty($bloc["bouton"])): ?>
                                        <a class="btn color-btn-dark" href="<?php echo $bloc["bouton"]['url'] ?>"
                                            target="<?php echo $bloc["bouton"]['target'] ?>"><?php echo $bloc["bouton"]['title'] ?></a>
                                    <?php endif; ?>
                                </div>
                                <?php 
                                    if ($logo_bg_about_url):
                                        echo '<img src="' . esc_url($logo_bg_about_url) . '" alt="Background logo" class="lame_listes_texte__content--logo"/>';
                                    endif; 
                                ?>
                            </div>
                        </section>
                        <?php 
                                break; 
                            endswitch;
                        endforeach; 
                        ?>
                    </div>
                </div>    
            </div>
        </div>
    </div>
    <!-- 'lame_texte_image': 
        <section class="lame_texte_image position-relative d-flex align-items-center justify-content-center overflow-hidden bg-white">
            <div class="container__lg">
                <div class="py-3 py-md-8">
                    <div class="text-center">
                        <?php if (!empty($bloc["titre_lame"])): ?>
                            <h3 class="position-relative mt-0 mb-4 f-56"><?php echo $bloc["titre_lame"] ?></h3>
                        <?php endif; ?>
                    </div>
                    <div class="text-center container__sm">
                        <?php if ($bloc["mention_dessous_titre"]): ?>
                            <div class="f-20 rustica content-text mb-6"><?php echo $bloc["mention_dessous_titre"] ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="row justify-content-center align-items-center">
                        <?php $cpt = 0 ?>
                        <?php foreach (is_array($bloc["lame_imagetexte"]) ? $bloc["lame_imagetexte"] : [] as $lame): ?>
                            <div class="col-md-4 d-flex">
                                <div class="lame_texte_image__card text-start bg-light-gray">
                                    <div class="lame_texte_image__card--inner w-100">
                                        <?php if ($lame["image"]): ?>
                                            <figure class="mb-3 align-self-center">
                                                <img src="<?php echo $lame["image"]["url"]; ?>" width="30" height="30" alt="<?php echo $lame["image"]["alt"]; ?>">
                                            </figure>
                                        <?php endif; ?>
                                        <h4 class="f-30 mt-0 mb-5"><?php echo $lame["titre"]; ?></h4>
                                        <?php if ($lame["texte"]): ?>
                                            <div class="w-100 align-self-start f-16 rustica text-left"><?php echo $lame["texte"]; ?></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <?php $cpt++ ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </section>
    -->
    <!-- Textes images complexes -->
    <!-- 'lame_texte_image_complexe': 
        <section class="position-relative overflow-hidden">
            <div class="container__lg">
                <div class="py-3 py-md-8">
                    <div class="position-relative text-center">
                        <div class="container__lg pb-md-4">
                            <?php if ($bloc["etiquette"]): ?>
                                <h3 class="sub-head tag-purple mb-3"><?php echo $bloc["etiquette"] ?></h3>
                            <?php endif; ?>

                            <?php if ($bloc["titre"]): ?>
                                <h2 class="pt-3 pb-4 "><?php echo $bloc["titre"] ?></h2>
                            <?php endif; ?>

                            <?php if ($bloc["texte"]): ?>
                                <div class="pb-3 content-mb-0"><?php echo $bloc["texte"] ?></div>
                            <?php endif; ?>

                        </div>
                    </div>
                    <?php if ($bloc["lame_de_contenu"] && count($bloc["lame_de_contenu"]) > 0): ?>
                        <?php foreach ($bloc["lame_de_contenu"] as $lame): ?>
                            <div class="page__home--50--50 py-3 py-md-5">
                                <div class="container__lg">
                                    <div
                                        class="row align-items-center <?php echo ($lame["disposition"] != "gauche") ? "flex-md-row-reverse" : "" ?>">
                                        <div class="col-md-6 pb-3 pb-md-0 d-flex justify-content-center">
                                            <figure>
                                                <img src="<?php echo $lame["image"]["url"] ?>" width="100%" height="100%"
                                                    alt="<?php echo $lame["image"]["alt"] ?>">
                                            </figure>
                                        </div>
                                        <div class="col-md-6">
                                            <h2 class="text-<?php echo $lame["couleur_titre"] ?> mb-3"><?php echo $lame["titre"] ?></h2>

                                            <?php if ($lame["contenu_texte"]): ?>
                                                <div class="content-text ul-<?php echo $lame["couleur_titre"] ?>">
                                                    <?php echo $lame["contenu_texte"] ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

        </section>
    -->
    <!-- Etudes de cas -->
    <?php
        foreach (is_array($filtered_etudes_cas) ? $filtered_etudes_cas : [] as $bloc):
    ?>
        <section class="bg-light-gray justify-content-cente">
            <?php echo get_template_part('template-parts/lame', 'etude-cas', ['bloc' => $bloc]) ?>
        </section>
    <?php 
        endforeach; 
    ?>
    <!-- Partie vidéo -->
    <!-- 'lame_temoignage_video': 
        <section class="single__etude--temoignage position-relative d-flex align-items-center overflow-hidden bg-dark-green">
            <div class="container__lg">
                <div class="row align-content-center">
                    <div class="col-md-6 single__etude--temoignage--left-container">
                        <div class="pe-2 single__etude--temoignage--left d-flex align-content-center justify-content-center">
                            <?php if ($bloc["photo"]): ?>
                                <figure class="mb-0">
                                    <img src="<?php echo $bloc["photo"]['url'] ?>" class="img-fluid" />
                                </figure>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-md-6 align-content-center">
                        <div class="ps-2 single__etude--temoignage--right d-flex flex-column  justify-content-between text-white">
                        <?php
                            $etude_fields = get_fields(get_the_ID());
                            if ($etude_fields["logo_client_blanc"]): ?>
                                <div class="mb-3 header-logo">
                                    <img src="<?php echo $etude_fields["logo_client_blanc"]["url"] ?>"
                                        alt="<?php echo $etude_fields["logo_client_blanc"]["alt"] ?>">
                                </div>
                            <?php endif; ?>
                            <div class="single__etude--temoignage--right--info">
                                <?php if ($bloc["nom_prenom"]): ?>
                                    <div class="single__etude--temoignage--right--nom mb-1">
                                        <?php echo $bloc["nom_prenom"] ?>
                                    </div>
                                <?php endif; ?>
                                <?php if ($bloc["fonction_entreprise"]): ?>
                                    <div class="single__etude--temoignage--right--fonction mb-3">
                                        <?php echo $bloc["fonction_entreprise"] ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="single__etude--temoignage--right--citation-container">
                                <?php if ($bloc["citation"]): ?>
                                    <div class="f-20 single__etude--temoignage--right--citation mb-0">
                                        <?php echo $bloc["citation"] ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section> 
    -->
</main>

<?php
get_footer();
?>