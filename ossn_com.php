<?php
/**
 * HomePagePosts - Tijdlijnfilters voor OSSN Homepagina
 *
 * @package   HomePagePosts
 * @author    Rafael Amorim / aangepast door Eric Redegeld (nlsociaal.nl)
 * @copyright (c) Rafael Amorim & Eric Redegeld
 * @license   GNU General Public License http://www.opensource-socialnetwork.org/licence
 */

// Initialisatie van de component
function homePagePosts_init() {
    if (ossn_isLoggedin()) {
        // ✅ Laad CSS/JS voor filterknoppen
        ossn_extend_view('ossn/site/head', 'js/homepageposts');
        ossn_extend_view('ossn/site/head', 'css/fontawesome');
        ossn_extend_view('ossn/page/footer', 'wall/filterbar');

        // ✅ Registreer paginahandlers voor de filtertypes
        ossn_register_page('public', 'wall_public_page_handler');
        ossn_register_page('friends', 'wall_friends_page_handler');
        ossn_register_page('liked', 'wall_liked_page_handler');

        // De volgende twee zijn uitgefaseerd, maar kunnen later worden heringeschakeld:
        // ossn_register_page('likedmine', 'wall_likedmine_page_handler');
        // ossn_register_page('comments', 'wall_comments_page_handler');
    }
}

// ✅ Haalt standaardfilter van gebruiker op (wordt nu niet meer gebruikt door ons)
function hpage_posts_get_homepage_wall_access() {
    if (!OssnSession::isSession('com_wall_type_access')) {
        $data = ossn_get_entities([
            'type'       => 'component',
            'subtype'    => 'ossnwall_defaultwall',
            'owner_guid' => 2,
        ]);

        if ($data) {
            OssnSession::assign('com_wall_type_access', $data[0]->value);
            return $data[0]->value;
        } else {
            OssnSession::assign('com_wall_type_access', 'public');
            return 'public';
        }
    } else {
        return OssnSession::getSession('com_wall_type_access');
    }
}

// ✅ Backward compatibility fallback
if (!function_exists('ossn_get_homepage_wall_access')) {
    function ossn_get_homepage_wall_access() {
        return hpage_posts_get_homepage_wall_access();
    }
}

// ✅ Paginahandlers die de gekozen filter in de sessie opslaan en terug redirecten naar vorige pagina
function wall_public_page_handler() {
    OssnSession::assign('com_wall_type_access', 'public');
    redirect(REF);
}
function wall_friends_page_handler() {
    OssnSession::assign('com_wall_type_access', 'friends');
    redirect(REF);
}
function wall_liked_page_handler() {
    OssnSession::assign('com_wall_type_access', 'liked');
    redirect(REF);
}
// Deze zijn uitgeschakeld maar kunnen later worden heringeschakeld
/*
function wall_likedmine_page_handler() {
    OssnSession::assign('com_wall_type_access', 'liked_mine');
    redirect(REF);
}
function wall_comments_page_handler() {
    OssnSession::assign('com_wall_type_access', 'comments');
    redirect(REF);
}
*/

// ✅ Registratie van de init-functie
ossn_register_callback('ossn', 'init', 'homePagePosts_init');
