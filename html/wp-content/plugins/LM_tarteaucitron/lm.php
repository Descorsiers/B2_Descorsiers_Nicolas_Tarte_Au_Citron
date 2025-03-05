<?php 
/**
 * @package LM_tarteaucitron
 * @version 1.0.0
 */
/*
Plugin Name: LM tarteaucitron
Description: Lancement du script tarteaucitron à l'ouverture du site
Author: Nicolas Descorsiers
Version: 1.0.0
*/
function lmRegistersSettings(){
    if (isset($_POST['submit'])) {
        var_dump($_POST);
    }
    // if (get_option('lmSettings')) {
    //     var_dump(get_option('lmSettings'));
    // }
    register_setting('lmOptionsGroup', 'lmSettings');
    add_settings_section(
        'lmFormField',
        'Tarteaucitron.js parameters',
        function (){
            echo "<h3>Modifier vos paramètres ici</h3>";
        },
        'tarte_au_citron'
    );
    add_settings_field(
        'hashtagField',
        'Hashtag',
        function(){
            $option = get_option('lmSettings');
            // var_dump($option);
            $value = isset($option['hashtag']) ? $option['hashtag'] : '';
            echo "<input type=\"text\" name=\"lmSettings[hashtag]\" value=\"" .esc_attr($value) . "\">";
        },
        'tarte_au_citron',
        'lmFormField'
    );
    add_settings_field(
        'privacyField',
        'HighPrivacy',
        function(){
            $option = get_option('lmSettings');
            echo  
                '
                    <select name="lmSettings[highPrivacy]" id="">
                        <option value="true" ' .(isset($option['highPrivacy']) && ($option['highPrivacy'] == 'true') ? "selected" : ""). '>
                            true
                        </option>
                        <option value="false" ' .(isset($option['highPrivacy']) && ($option['highPrivacy'] == 'false') ? "selected" : "").'>
                            false
                        </option>
                    </select>
                ';
        },
        'tarte_au_citron',
        'lmFormField'
    );
    add_settings_field(
        'acceptAllCtaField',
        'AcceptAllCta',
        function(){
            echo  
                '
                    <select name="lmSettings[acceptAllCta]" id="">
                        <option value="true ' .(isset($option['acceptAllCta']) && ($option['acceptAllCta'] == 'true') ? "selected" : ""). '">
                            true
                        </option>
                        <option value="false" ' .(isset($option['acceptAllCta']) && ($option['acceptAllCta'] == 'false') ? "selected" : ""). '>
                            false
                        </option>
                    </select>
                ';
        },
        'tarte_au_citron',
        'lmFormField'
    );
    add_settings_field(
        'orientationField',
        'orientation',
        function(){
            echo  
                '
                    <select name="lmSettings[orientation]" id="">
                        <option value="top ' .(isset($option['orientation']) && ($option['orientation'] == 'top') ? "selected" : ""). '">
                            top
                        </option>
                        <option value="bottom" ' .(isset($option['orientation']) && ($option['orientation'] == 'bottom') ? "selected" : ""). '>
                            bottom
                        </option>
                        <option value="popup" ' .(isset($option['orientation']) && ($option['orientation'] == 'popup') ? "selected" : ""). '>
                            popup
                        </option>
                        <option value="banner" ' .(isset($option['orientation']) && ($option['orientation'] == 'banner') ? "selected" : ""). '>
                            banner
                        </option>
                    </select>
                ';
        },
        'tarte_au_citron',
        'lmFormField'
    );
    add_settings_field(
        'adblockerField',
        'adblocker',
        function(){
            echo  
                '
                    <select name="lmSettings[adblocker]" id="">
                        <option value="true ' .(isset($option['adblocker']) && ($option['adblocker'] == 'true') ? "selected" : ""). '">
                            true
                        </option>
                        <option value="false" ' .(isset($option['adblocker']) && ($option['adblocker'] == 'false') ? "selected" : ""). '>
                            false
                        </option>
                    </select>
                ';
        },
        'tarte_au_citron',
        'lmFormField'
    );
    add_settings_field(
        'showAlertSmallField',
        'showAlertSmall',
        function(){
            echo  
                '
                    <select name="lmSettings[showAlertSmall]" id="">
                        <option value="true ' .(isset($option['showAlertSmall']) && ($option['showAlertSmall'] == 'true') ? "selected" : ""). '">
                            true
                        </option>
                        <option value="false" ' .(isset($option['showAlertSmall']) && ($option['showAlertSmall'] == 'false') ? "selected" : ""). '>
                            false
                        </option>
                    </select>
                ';
        },
        'tarte_au_citron',
        'lmFormField'
    );
    add_settings_field(
        'cookielistField',
        'cookielist',
        function(){
            echo  
                '
                    <select name="lmSettings[cookielist]" id="">
                        <option value="true ' .(isset($option['cookielist']) && ($option['cookielist'] == 'true') ? "selected" : ""). '">
                            true
                        </option>
                        <option value="false" ' .(isset($option['cookielist']) && ($option['cookielist'] == 'false') ? "selected" : ""). '>
                            false
                        </option>
                    </select>
                ';
        },
        'tarte_au_citron',
        'lmFormField'
    );
}

add_action('admin_init', 'lmRegistersSettings');

function addScript(){
    wp_enqueue_script(
        'tarteaucitron',
        plugin_dir_url(__FILE__) . 'tarteaucitron.js-1.19.0/tarteaucitron.min.js');
}

function addScript2(){
    $option = get_option("lmSettings") ?>
    <script type="text/javascript">
        tarteaucitron.init({
    	  "privacyUrl": "", /* Url de la politique de confidentialité */
          "bodyPosition": "top", /* top place le bandeau de consentement au début du code html, mieux pour l'accessibilité */

    	  "hashtag": "<?php echo isset($option['hashtag']) ? $option['hashtag'] : "#tarteaucitron"; ?>", /* Hashtag qui permet d'ouvrir le panneau de contrôle  */
    	  "cookieName": "tarteaucitron", /* Nom du cookie (uniquement lettres et chiffres) */
    
    	  "orientation": "<?php echo isset($option['orientation']) ? $option['orientation'] : "middle"; ?>", /* Position de la bannière (top - bottom - popup - banner) */
       
          "groupServices": true, /* Grouper les services par catégorie */
          "showDetailsOnClick": true, /* Cliquer pour ouvrir la description */
          "serviceDefaultState": "wait", /* Statut par défaut (true - wait - false) */
                           
    	  "showAlertSmall": <?php echo isset($option['showAlertSmall']) ? $option['showAlertSmall'] : false; ?>, /* Afficher la petite bannière en bas à droite */
    	  "cookieslist": <?php echo isset($option['cookielist']) ? $option['cookielist'] : false; ?>, /* Afficher la liste des cookies */
                           
          "closePopup": true, /* Afficher un X pour fermer la bannière */

          "showIcon": true, /* Afficher un cookie pour ouvrir le panneau */
          //"iconSrc": "", /* Optionnel: URL ou image en base64 */
          "iconPosition": "BottomRight", /* Position de l'icons: (BottomRight - BottomLeft - TopRight - TopLeft) */

    	  "adblocker": <?php echo isset($option['adblocker']) ? $option['adblocker'] : false; ?>, /* Afficher un message si un Adblocker est détecté */
                           
          "DenyAllCta" : true, /* Afficher le bouton Tout refuser */
          "AcceptAllCta" : <?php echo isset($option['acceptAllCta']) ? $option['acceptAllCta'] : true; ?>, /* Afficher le bouton Tout accepter */
          "highPrivacy": <?php echo isset($option['highPrivacy']) ? $option['highPrivacy'] : true; ?>, /* Attendre le consentement */
          "alwaysNeedConsent": false, /* Demander le consentement même pour les services "Privacy by design" */
                           
    	  "handleBrowserDNTRequest": false, /* Refuser tout par défaut si Do Not Track est activé sur le navigateur */

    	  "removeCredit": false, /* Retirer le lien de crédit vers tarteaucitron.io */
    	  "moreInfoLink": true, /* Afficher le lien En savoir plus */

          "useExternalCss": false, /* Mode expert : désactiver le chargement des fichiers .css tarteaucitron */
          "useExternalJs": false, /* Mode expert : désactiver le chargement des fichiers .js tarteaucitron */

    	  //"cookieDomain": ".my-multisite-domaine.fr", /* Optionnel: domaine principal pour partager le consentement avec des sous domaines */
                          
          "readmoreLink": "", /* Changer le lien En savoir plus par défaut */

          "mandatory": true, /* Afficher un message pour l'utilisation de cookies obligatoires */
          "mandatoryCta": false, /* Afficher un bouton pour les cookies obligatoires (déconseillé) */
    
          //"customCloserId": "", /* Optionnel a11y: ID personnalisé pour ouvrir le panel */
          
          "googleConsentMode": true, /* Activer le Google Consent Mode v2 pour Google ads & GA4 */
          "bingConsentMode": true, /* Activer le Bing Consent Mode pour Clarity & Bing Ads */
          
          "partnersList": true /* Afficher le détail du nombre de partenaires sur la bandeau */
        });

        (tarteaucitron.job = tarteaucitron.job || []).push('twitterwidgetsapi');

        tarteaucitron.user.abtastyID = 'id';
        (tarteaucitron.job = tarteaucitron.job || []).push('abtasty');

        tarteaucitron.user.arcId = 'arcId';
        (tarteaucitron.job = tarteaucitron.job || []).push('arcio');
    </script><?php
}


function menuContent(){ ?>
    <div>
        <form action="options.php" method="post"><?php
            settings_fields('lmOptionsGroup');
            do_settings_sections('tarte_au_citron');
            submit_button();
    ?>  </form>
    </div>
<?php }

function addMenu(){
    add_menu_page(
        'Tarte au citron',
        'Tarte au citron',
        'manage_options',
        'tarte_au_citron',
        'menuContent'
    );
}

add_action('admin_menu', 'addMenu');
add_action('wp_enqueue_scripts', 'addScript');
add_action('wp_head', 'addScript2');
?>