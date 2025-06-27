<?php
/**
 * HomePagePosts - Filterbalk voor tijdlijnweergave
 * Toon icoon-gebaseerde filterknoppen (altijd zichtbaar)
 * Gebruikt de URL-parameter `?filter=` om filtertype te bepalen
 * 
 * /**
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

error_log(" filterbar geladen op: " . $_SERVER['REQUEST_URI']);

$filter = input('filter') ?: 'public';
$sort   = input('sort') ?: 'desc'; // default aflopend (nieuwste bovenaan)

$base_url = ossn_site_url('home');
?>

<style>
.wall-filter-mobile {
    display: flex;
    background: #f9f9f9;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 0 4px rgba(0,0,0,0.1);
    margin: 10px 0;
}
.wall-filter-mobile a {
    flex: 1;
    padding: 10px 5px;
    font-size: 0.9rem;
    color: #444;
    text-decoration: none;
    text-align: center;
}
.wall-filter-mobile a.active {
    background: #e9ecef;
    color: #d9534f;
    font-weight: bold;
}
.wall-filter-mobile i {
    display: block;
    font-size: 1.4rem;
    margin-bottom: 3px;
}
</style>

<div class="wall-filter-mobile">
    <a href="<?= "{$base_url}?filter=public&sort={$sort}" ?>" class="<?= $filter === 'public' ? 'active' : ''; ?>">
        <i class="fas fa-globe"></i>
        <span>Publiek</span>
    </a>
    <a href="<?= "{$base_url}?filter=friends&sort={$sort}" ?>" class="<?= $filter === 'friends' ? 'active' : ''; ?>">
        <i class="fas fa-user-friends"></i>
        <span>Vrienden</span>
    </a>
    <a href="<?= "{$base_url}?filter=liked&sort={$sort}" ?>" class="<?= $filter === 'liked' ? 'active' : ''; ?>">
        <i class="fas fa-fire"></i>
        <span>Hot</span>
    </a>
</div>

<!-- Sorteerknop -->
<div style="text-align:right; margin: 5px 10px;">
    <a class="btn btn-light btn-sm" href="<?= "{$base_url}?filter={$filter}&sort=" . ($sort === 'asc' ? 'desc' : 'asc'); ?>">
        Sortering: <?= $sort === 'asc' ? 'Oudste eerst ↑' : 'Nieuwste eerst ↓'; ?>
    </a>
</div>
