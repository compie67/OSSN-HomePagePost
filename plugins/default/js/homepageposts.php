<script>
$(document).ready(function () {
    // Alleen op de homepagina en niet op profielpagina's
    if (!window.location.href.match('/u/')) {
        const urlParams = new URLSearchParams(window.location.search);
        const filter = urlParams.get('filter') || 'public';
        const sort = urlParams.get('sort') || 'desc';

        let WallSelector = '<div class="ossn-wall-access" style="border-bottom-right-radius: 10px;border-bottom-left-radius: 10px;">';
        WallSelector += '    <div class="ossn-widget">';
        WallSelector += '        <div class="widget-heading container-fluid">';
        WallSelector += '            <div class="row">';

        const filters = [
            { key: 'public', label: 'Publiek' },
            { key: 'friends', label: 'Vrienden' },
            { key: 'liked', label: 'Hot' }
        ];

        filters.forEach(f => {
            const active = (filter === f.key) ? ' text-danger' : '';
            WallSelector += `<div class="col text-center">
                <a href="<?php echo ossn_site_url('home'); ?>?filter=${f.key}&sort=${sort}" class="${active}">${f.label}</a>
            </div>`;
        });

        // Sorteerknop
        const nextSort = (sort === 'desc') ? 'asc' : 'desc';
        const sortIcon = (sort === 'desc') ? '↓' : '↑';
        WallSelector += `<div class="col text-center">
            <a href="<?php echo ossn_site_url('home'); ?>?filter=${filter}&sort=${nextSort}" class="text-primary">
                Sortering ${sortIcon}
            </a>
        </div>`;

        WallSelector += '            </div>';
        WallSelector += '        </div>';
        WallSelector += '    </div>';
        WallSelector += '</div>';

        $(WallSelector).insertAfter('.ossn-wall-container');
    }
});
</script>
