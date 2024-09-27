<?php

use yii\helpers\Url;

// Get the current module, controller, and action
$module = Yii::$app->controller->module->id;
$controller = Yii::$app->controller->id;
$action = Yii::$app->controller->action->id;

// Define sidebar menu structure with module, controller, and action
$sidebarMenus = [
    [
        'label' => 'Dashboard',
        'url' => Url::to(['/dash']),
        'icon' => 'feather-grid',
        'module' => 'dashboard',  // Specify the module
        'controller' => 'default',
        'action' => 'index',
    ],
    [
        'label' => 'Students',
        'icon' => 'fas fa-graduation-cap',
        'submenu' => true, // Mark it as a submenu
        'active' => $module === 'dashboard' && $controller === 'student', // Check both module and controller
        'items' => [
            [
                'label' => 'Student List',
                'url' => Url::to(['/dashboard/student/index']),
                'module' => 'dashboard',
                'controller' => 'student',
                'action' => 'index',
            ],
            [
                'label' => 'Student Add',
                'url' => Url::to(['/dashboard/student/create']),
                'module' => 'dashboard',
                'controller' => 'student',
                'action' => 'create',
            ],
        ]
    ],
    [
        'label' => 'Staffs',
        'icon' => 'fas fa-chalkboard-teacher',
        'submenu' => true, // Mark it as a submenu
        'active' => $module === 'dashboard' && $controller === 'staff', // Check both module and controller
        'items' => [
            [
                'label' => 'Staff List',
                'url' => Url::to(['/dashboard/staff/index']),
                'module' => 'dashboard',
                'controller' => 'staff',
                'action' => 'index',
            ],
            [
                'label' => 'Student Add',
                'url' => Url::to(['/dashboard/staff/create']),
                'module' => 'dashboard',
                'controller' => 'staff',
                'action' => 'create',
            ],
        ]
    ],
    // You can add more menus/submenus here, possibly with different modules
];
?>
<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="menu-title">
                    <span>Main Menu</span>
                </li>

                <?php foreach ($sidebarMenus as $menu): ?>
                    <?php if (isset($menu['submenu']) && $menu['submenu']): ?>
                        <!-- Submenu -->
                        <li class="submenu <?= $menu['active'] ? 'active' : '' ?>">
                            <a href="#"><i class="<?= $menu['icon'] ?>"></i> <span> <?= $menu['label'] ?> </span> <span class="menu-arrow"></span></a>
                            <ul>
                                <?php foreach ($menu['items'] as $subItem): ?>
                                    <li>
                                        <a href="<?= $subItem['url'] ?>"
                                            class="<?= ($module == $subItem['module'] && $controller == $subItem['controller'] && $action == $subItem['action']) ? 'active' : '' ?>">
                                            <?= $subItem['label'] ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </li>
                    <?php else: ?>
                        <!-- Regular Menu -->
                        <li class="<?= ($module == $menu['module'] && $controller == $menu['controller'] && $action == $menu['action']) ? 'active' : '' ?>">
                            <a href="<?= $menu['url'] ?>"><i class="<?= $menu['icon'] ?>"></i> <span> <?= $menu['label'] ?> </span></a>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>

            </ul>
        </div>
    </div>
</div>