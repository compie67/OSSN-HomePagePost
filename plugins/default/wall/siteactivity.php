<?php
/**
 * HomePagePosts - Tijdlijnweergave met filters en sorteeroptie
 * Open Source Social Network
 *
 * @package   HomePagePosts
 * @author    Rafael Amorim
 * @adjustment Eric Redegeld (nlsociaal.nl)
 * @license   General Public Licence http://www.opensource-socialnetwork.org/licence
 * @link      https://www.rafaelamorim.com.br/
 */

$wall         = new OssnWall;
$loggedinuser = ossn_loggedin_user();
$debug        = true;

function hpp_log($msg) {
    global $debug;
    if ($debug) {
        error_log("[HomePagePosts] " . $msg);
    }
}

// Haal filter en sorteeroptie op uit de URL
$filter = input('filter') ?: 'public';
$sort   = strtolower(input('sort')) === 'asc' ? 'ASC' : 'DESC';

$options = [
    'type' => 'user',
    'distinct' => true,
    'order_by' => "o.time_created {$sort}"
];

$count_options = [
    'type' => 'user',
    'count' => true,
    'distinct' => true,
    'order_by' => "o.time_created {$sort}"
];

$posts = [];
$count = 0;

if ($loggedinuser && $loggedinuser->canModerate()) {
    hpp_log("Admin modus: alle berichten tonen");
    $posts = $wall->getAllPosts($options);
    $count = $wall->getAllPosts($count_options);

} elseif ($filter === 'public') {
    hpp_log("Publieke berichten tonen");
    $posts = $wall->getPublicPosts($options);
    $count = $wall->getPublicPosts($count_options);

} elseif ($filter === 'friends') {
    hpp_log("Vriendenberichten tonen");
    $posts = $wall->getFriendsPosts($options);
    $count = $wall->getFriendsPosts($count_options);

} elseif ($filter === 'liked') {
    hpp_log("Meest gelikete berichten tonen");
    $options['joins'] = [
        "LEFT JOIN ossn_annotations AS a ON a.subject_guid = o.guid AND a.type = 'like'"
    ];
    $options['group_by'] = 'o.guid';
    $options['order_by'] = $sort === 'asc' ? 'COUNT(a.id) ASC' : 'COUNT(a.id) DESC';

    $count_options = $options;
    $count_options['count'] = true;

    $posts = $wall->getAllPosts($options);
    $count = $wall->getAllPosts($count_options);

    if (!is_numeric($count)) {
        hpp_log(" Liked: count is ongeldig, fallback naar 0");
        $count = 0;
    }

} else {
    hpp_log("❓ Onbekend filtertype: {$filter}");
}

// Weergave
if (!empty($posts)) {
    foreach ($posts as $post) {
        if ($post instanceof OssnObject && $post->subtype === 'wall') {
            $item = ossn_wallpost_to_item($post);
            if ($item) {
                echo ossn_wall_view_template($item);
            } else {
                hpp_log(" Lege wall-item voor post: {$post->guid}");
            }
        } else {
            hpp_log("Ongeldige post in lijst (geen OssnObject of subtype ≠ wall)");
        }
    }
} else {
    echo '<div class="ossn-no-posts">Geen berichten gevonden.</div>';
}

echo ossn_view_pagination($count);
