<?php
/**
 * Open Source Social Network
 *
 * @package   HomePagePosts
 * @author    Rafael Amorim <amorim@rafaelamorim.com.br>
 * @adjustment and tweaking Eric Redegeld nlsociaal.nlsociaal
 * @copyright (c) Rafael Amorim
 * @license   General Public Licence http://www.opensource-socialnetwork.org/licence
 * @link      https://www.rafaelamorim.com.br/
 *
 */
 

function homePagePosts_init() {
    if (ossn_isLoggedin()) {
        // Voeg fontawesome-iconen toe (voor de knoppen)
        ossn_extend_view('ossn/site/head', 'css/fontawesome');

        // Voeg de filterbalk toe aan de footer (mobiele tijdlijnnavigatie)
        ossn_extend_view('ossn/page/footer', 'wall/filterbar');
        
        // altijd zichtbaar
        ossn_extend_view('ossn/site/head', 'js/homepageposts');


        // Verwijder originele comment:load callback (bugfix)
        global $OssnCallbacks;
        if (isset($OssnCallbacks['comment']['load'])) {
            foreach ($OssnCallbacks['comment']['load'] as $index => $cb) {
                if (is_array($cb['callback']) && isset($cb['callback'][0]) && $cb['callback'][0] instanceof OssnComments) {
                    unset($OssnCallbacks['comment']['load'][$index]);
                }
            }
        }

        // Voeg onze eigen veilige callback toe
        ossn_register_callback('comment', 'load', 'home_page_posts_comment_menu_fix', 1);
    }
}

/**
 * Eigen veilige versie van de comment menu callback
 */
function home_page_posts_comment_menu_fix($name, $type, $params) {
    if (!is_array($params)) {
        $params = get_object_vars($params);
    }

    if (empty($params['id'])) {
        return;
    }

    $OssnComment = new OssnComments();
    $comment = $OssnComment->getComment($params['id']);

    if (!$comment || $comment->type !== 'comments:entity') {
        return;
    }

    $user = ossn_loggedin_user();
    $entity = ossn_get_entity($comment->subject_guid);
    $entity_object = false;

    if ($entity && $entity->type == 'object') {
        $entity_object = ossn_get_object($entity->owner_guid);
    }

    if (
        $user->guid == $params['owner_guid'] ||
        ossn_isAdminLoggedin() ||
        ($entity && $entity->type == 'user' && $user->guid == $entity->owner_guid) ||
        ($entity_object && $user->guid == $entity_object->owner_guid)
    ) {
        ossn_unregister_menu('delete', 'comments');
        ossn_register_menu_item('comments', array(
            'name'     => 'delete',
            'href'     => ossn_site_url("action/delete/comment?comment={$params['id']}", true),
            'class'    => 'dropdown-item ossn-delete-comment',
            'text'     => ossn_print('comment:delete'),
            'priority' => 200,
        ));
    }
}

// Init component
ossn_register_callback('ossn', 'init', 'homePagePosts_init');
