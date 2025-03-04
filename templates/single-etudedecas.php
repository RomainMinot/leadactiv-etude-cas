<?php
get_header();

$case_study_id = get_the_ID();
$case_study = get_fields($case_study_id);
$sectors = get_the_terms($case_study_id, 'typeetudedecas');
$fonctions = get_the_terms($case_study_id, 'fonction');
$localisations = get_the_terms($case_study_id, 'localisation');

$logo_bg_head_url = wp_get_attachment_url(2839);
$play_logo_url = wp_get_attachment_url(3787);

$case_color = $case_study['couleur'] && $case_study['couleur'] !== 'tag-white' ? $case_study['couleur'] : 'tag-gray';
?>

<main class="single__etude">
    <!-- Header -->
    <section class="single__etude--header position-relative bg-white">
        <div class="container__lg">
            <div class="py-3 pt-md-3 pb-md-8">
                <div class="row align-items-center justify-content-between">
                    <!-- Tags -->
                    <div class="single__etude__tags mb-4 d-flex align-items-center justify-content-start">
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
                        <div class>
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
                            <p class="single__etude--header--descr f-20 mb-4">
                                <?php echo get_field('accroche', get_the_ID()); ?>
                            </p>
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
                                        <div class="video-embed" >
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
    foreach (is_array(get_field('lames_contenu', get_the_ID())) ? get_field('lames_contenu', get_the_ID()) : [] as $bloc):
        switch ($bloc['acf_fc_layout']):
            case 'lame_chiffres': 
    ?>
        <section class="page__etude--chiffres d-flex overflow-hidden justify-content-center position-relative bg-dark-green">
            <div class="container__lg">                          
                <div class="d-flex h-100">
                    <div class="page__etude--chiffres__left text-white d-flex flex-column">
                        <h2 class="f-32 mt-0 mb-3">La collaboration en quelques chiffres</h2>
                        <p class="w-75">*Rendez-vous qualifié : rendez-vous réalisé avec un prospect respectant les critères de ciblage définis par le client</p>
                    </div>
                    <div class="page__etude--chiffres__right d-flex justify-content-center align-items-center">
                        <?php 
                            foreach (is_array($bloc['chiffres']) ? $bloc['chiffres'] : [] as $index => $chiffre): 
                        ?>
                            <div class="d-flex flex-column align-items-start text-start">
                                <h2 class="page__etude--chiffres--chiffre mt-0 mb-2"><?php echo $chiffre['chiffre']; ?></h2>
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
        </section>
    <!-- Textes -->
    <?php 
            break;
            case 'lame_listes_texte': 
    ?>
        <section class="lame_listes_texte position-relative d-flex align-items-center overflow-hidden bg-light-purple">
            <div class="container__lg">
                <div class="py-3 py-md-8">
                    <div class="row align-items-top">
                        <div class="col-12 col-6 col-md-6 col-lg-6 justify-content-left">
                            <div class="lame_listes_texte__content">
                                <?php if (!empty($bloc["titre"])): ?>
                                    <h3 class="mt-0 f-48"><?php echo $bloc["titre"] ?></h3>
                                <?php endif; ?>
                                <?php if (!empty($bloc["texte"])): ?>
                                    <p class="f-16"><?php echo $bloc["texte"] ?>
                                    <?php endif; ?>
                                    <?php if (!empty($bloc["bouton"])): ?>
                                        <a class="btn color-btn-dark px-5" href="<?php echo $bloc["bouton"]['url'] ?>"
                                            target="<?php echo $bloc["bouton"]['target'] ?>"><?php echo $bloc["bouton"]['title'] ?></a>
                                    <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6 col-md-6 d-flex justify-content-center align-item-center position-relative">
                            <?php if (!empty($bloc["liste"])): ?>
                                <div class="lame_listes_texte__card-container">
                                    <div class="lame_listes_texte__card-content">
                                        <?php if (!empty($bloc["titre_liste"])): ?>
                                            <p class="tag tag-green f-14"><?php echo $bloc["titre_liste"] ?></p>
                                        <?php endif; ?>
                                        <div class="content-text">
                                            <ul class="p-0 m-0 list-unstyled">
                                                <?php foreach ($bloc["liste"] as $item): ?>
                                                    <li class="picto-style  d-flex align-items-center">
                                                        <?php if (!empty($item['picto_item'])): ?>
                                                            <img src="<?php echo $item['picto_item']['url'] ?>" class="me-5">
                                                        <?php endif; ?>
                                                        <?php echo $item['liste_item'] ?>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>    
                </div>
            </div>
        </section>
    <!-- Textes images -->
    <?php 
            break; 
            case 'lame_texte_image': 
    ?>
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
    <!-- Textes images complexes -->
    <?php 
            break; 
            case 'lame_texte_image_complexe': 
    ?>
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
    <!-- Etudes de cas -->
    <?php 
            break; 
            case 'lame_etudes_cas': 
    ?>
        <section class="bg-light-gray justify-content-cente">
            <?php echo get_template_part('template-parts/lame', 'etude-cas', ['bloc' => $bloc]) ?>
        </section>
    <!-- Partie vidéo -->
    <?php 
            break;
            case 'lame_temoignage_video': 
    ?>
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
    <?php 
            break; 
        endswitch;
    endforeach; 
    ?>
</main>

<?php
get_footer();
?>