<?php use App\Utilities\Lang; use App\Utilities\Session; ?>

<!DOCTYPE html>
<html lang="<?= Lang::get('lang') ?> " dir="<?= Lang::get('dir') ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= Lang::get('panel-title') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet" />
    <link href="<?= Lang::get('font') ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?= assetUrl(Lang::get('maincss')) ?>">
    <link rel="stylesheet" href="<?= assetUrl(Lang::get('resonsecss')) ?>">
    <script src="<?= assetUrl('js/sweetalert2@11.js') ?>"></script>

</head>

<body>
    <div class="panel-container">
        <header class="header">
            <div class="<?= Lang::get('direction-1') ?>-header">
                <div class="<?= Lang::get('direction-1') ?>-header__profile">
                    <div class="<?= Lang::get('direction-1') ?>-header__profile-div">
                        <span class="<?= Lang::get('direction-1') ?>-header__icons">
                            <i class="ri-user-6-line <?= Lang::get('direction-1') ?>-header__icons-icon"></i>
                        </span>
                        <a class="<?= Lang::get('direction-1') ?>-header__user-email">
                            <?= str_replace(['@outlook.com', '@yahoo.com', '@gmail.com'], '', $data->userName) ?>
                        </a>
                    </div>


                    <div class="burger-menu">
                        <div class="burger-menu__div">
                            <button class="burger-menu__btn">
                                <i class="ri-menu-fill burger-menu__icon"></i>
                            </button>
                        </div>
                    </div>
                </div>

            </div>

            <div class="<?= Lang::get('direction-2') ?>-header">

                <div class="<?= Lang::get('direction-2') ?>-header__brand">
                    <h2 class="<?= Lang::get('direction-2') ?>-header__brand-title"><?= Lang::get('panel-h1') ?></h2>
                </div>

                <div class="<?= Lang::get('direction-2') ?>-header__list">
                    <a href="./" class="<?= Lang::get('direction-2') ?>-header__list-item">
                        <i class="ri-home-4-line <?= Lang::get('direction-2') ?>-header__list-icons"></i>
                    </a>
                    <a href="./panel/logout" class="<?= Lang::get('direction-2') ?>-header__list-item">
                        <i class="ri-shut-down-line <?= Lang::get('direction-2') ?>-header__list-icons"></i>
                    </a>
                </div>
            </div>
        </header>

        <main class="main">

            <button class="close-menu__btn d-none">
                <i class="ri-close-large-fill close-menu__icon"></i>
            </button>
            <div class="<?= Lang::get('direction-1') ?>-main">
                <div class="<?= Lang::get('direction-1') ?>-main__list">
                    <div class="<?= Lang::get('direction-1') ?>-main__list-container">
                        <div class="<?= Lang::get('direction-1') ?>-main__list-title">
                            <a href="#" class="<?= Lang::get('direction-1') ?>-main__list-item">
                                <i class="ri-dashboard-horizontal-line <?= Lang::get('direction-1') ?>-main__list-icon"></i>
                                <p class="<?= Lang::get('direction-1') ?>-main__list-text"><?= Lang::get('dash') ?></p>
                            </a>
                            <i class="ri-arrow-down-s-line <?= Lang::get('direction-1') ?>-main__list-dropdown-icon"></i>
                        </div>
                        <div class="<?= Lang::get('direction-1') ?>-main__list-item-dropdown">
                            <a href="#" class="<?= Lang::get('direction-1') ?>-main__list-item">
                                <i class="ri-line-chart-line <?= Lang::get('direction-1') ?>-main__list-icon"></i>
                                <p class="<?= Lang::get('direction-1') ?>-main__list-text"><?= Lang::get('stats') ?></p>
                            </a>
                            <a href="#" class="<?= Lang::get('direction-1') ?>-main__list-item">
                                <i class="ri-user-line <?= Lang::get('direction-1') ?>-main__list-icon"></i>
                                <p class="<?= Lang::get('direction-1') ?>-main__list-text"><?= Lang::get('profile') ?></p>
                            </a>
                            <a href="#" class="<?= Lang::get('direction-1') ?>-main__list-item">
                                <i class="ri-settings-5-line <?= Lang::get('direction-1') ?>-main__list-icon"></i>
                                <p class="<?= Lang::get('direction-1') ?>-main__list-text"><?= Lang::get('settings') ?></p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="<?= Lang::get('direction-1') ?>-main-dropdown d-none">
                <div class="<?= Lang::get('direction-1') ?>-main-dropdown__list">
                    <div class="<?= Lang::get('direction-1') ?>-main__list-title">
                        <a href="#" class="<?= Lang::get('direction-1') ?>-main__list-item">
                            <i class="ri-line-chart-line <?= Lang::get('direction-1') ?>-main__list-icon"></i>
                            <p class="<?= Lang::get('direction-1') ?>-main__list-text"><?= Lang::get('stats') ?></p>
                        </a>
                        <i class="ri-arrow-down-s-line <?= Lang::get('direction-1') ?>-main__list-dropdown-icon"></i>
                    </div>
                    <div class="<?= Lang::get('direction-1') ?>-main__list-item-dropdown">
                        <a href="#" class="<?= Lang::get('direction-1') ?>-main__list-item">
                            <i class="ri-user-line <?= Lang::get('direction-1') ?>-main__list-icon"></i>
                            <p class="<?= Lang::get('direction-1') ?>-main__list-text"><?= Lang::get('profile') ?></p>
                        </a>
                        <a href="#" class="<?= Lang::get('direction-1') ?>-main__list-item">
                            <i class="ri-car-line <?= Lang::get('direction-1') ?>-main__list-icon"></i>
                            <p class="<?= Lang::get('direction-1') ?>-main__list-text"><?= Lang::get('settings') ?></p>
                        </a>
                    </div>
                </div>
            </div>

            <div class="<?= Lang::get('direction-2') ?>-main">
                <table class="stats-table">
                    <thead class="stats-table__head">
                        <tr class="stats-table__head-row">
                            <th class="stats-table__head-col">#</th>
                            <th class="stats-table__head-col"><?= Lang::get('desturl') ?></th>
                            <th class="stats-table__head-col"><?= Lang::get('shorturl') ?></th>
                            <th class="stats-table__head-col"><?= Lang::get('view') ?></th>
                            <th class="stats-table__head-col"><?= Lang::get('qr') ?></th>
                            <th class="stats-table__head-col"><?= Lang::get('edit') ?></th>
                            <th class="stats-table__head-col"><?= Lang::get('copy') ?></th>
                            <th class="stats-table__head-col"><?= Lang::get('delete') ?></th>
                        </tr>
                    </thead>

                    <tbody class="stats-table__body">
                        <?php
                        foreach ($data->urls as $url): ?>
                            <tr class="stats-table__body-row">
                                <td class="stats-table__body-col"><?= ++$data->startPaginate ?></td>
                                <td class="stats-table__body-col"><?= substr(str_replace(['https://', 'http://', 'www.', 'Https', 'Http', 'WWW.'], '', $url->url), 0, 25) . ' ...' ?></td>
                                <td class="stats-table__body-col" id="testcopy"><?= str_replace(['https://', 'http://', 'www.', 'Https', 'Http', 'WWW.'], '', $url->shortUrl) ?></td>
                                <td class="stats-table__body-col"><?= $url->views ?></td>
                                <td class="stats-table__body-col">
                                    <a href="<?= $url->QrCode ?>" class="QR-code-span" download><i class="ri-qr-code-line QR-code-icon"></i></a>
                                </td>
                                <td class="stats-table__body-col">
                                    <a href="./panel/edit/<?= $url->id ?>" class="stats-table__body-icons"><i class="ri-edit-line stats-table-edit-icon"></i></a>
                                </td>
                                <td class="stats-table__body-col">
                                    <button class="stats-table__body-icons stats-table__copy-btn" data-clipboard-demo="" data-clipboard-target="#testcopy" data-clipboard-action="copy" data-bs-toggle="popover" data-bs-trigger="focus" data-bs-placement="bottom" data-bs-custom-class="custom-popover" data-bs-content="copied!">
                                        <i class="ri-file-copy-2-line stats-table-copy-icon"></i>
                                    </button>
                                </td>
                                <td class="stats-table__body-col">
                                    <a href="./panel/delete/<?= $url->id ?>"><button class="stats-table__body-icons"><i class="ri-delete-bin-line stats-table-delete-icon"></i></button></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php if ($data->totalPage > 1) : ?>
                    <div class="user-panel-pagination">
                        <div class="user-panel-pagination__container cursorDefult">
                            <!-- Back Pagination -->
                            <a href="./panel?page=<?= ($data->page - 1) ?>" class="<?= ($data->page) == 1 ? 'user-panel__pagination-link disabled' : 'user-panel__pagination-link' ?>"><i class="ri-arrow-left-s-line"></i></a>
                            <a href="#" class="user-panel__pagination-link user-panel__pagination-link-active" style="pointer-events: none"><?= $data->page ?></a>
                            <a href="./panel?page=<?= $data->page + 1 ?>" class="<?= ($data->page) == $data->totalPage ? 'user-panel__pagination-link disabled' : 'user-panel__pagination-link' ?>"><i class="ri-arrow-right-s-line"></i></a>
                        </div>
                    </div>
                <?php endif ?>
            </div>
        </main>

        <div class="bg-blur"></div>
    </div>

    <!--App script-->
    <script src="<?= assetUrl('js/popper.min.js') ?>"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.min.js"></script>
    <script src="<?= assetUrl('js/clipboard.min.js') ?>"></script>
    <script src="<?= assetUrl(Lang::get('indexjs')) ?>"></script>
</body>

</html>

<?php
if (Session::has('error') && !Session::empty('error')) {
    echo alarm('error', Session::get('error'), '22em', Lang::get('position-alarm'));
    Session::delete('error');
} elseif (Session::has('message') && !Session::empty('message')) {
    echo alarm('success', Session::get('message'), '22em', Lang::get('position-alarm'));
    Session::delete('message');
}
?>