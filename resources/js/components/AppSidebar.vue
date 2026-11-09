<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import {
    BookOpen,
    Carrot,
    Folder,
    FolderGit2,
    LayoutGrid,
    Package,
    Tags,
} from '@lucide/vue';
import AppLogo from '@/components/AppLogo.vue';
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarHeader,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from '@/components/ui/sidebar';
import { index as dashboard } from '@/routes/admin/dashboard/index';
import { index as categories } from '@/routes/admin/categories/index';
import { index as productGroups } from '@/routes/admin/product-groups/index';
import { index as products } from '@/routes/admin/products/index';
import { index as params } from '@/routes/admin/params/index';
import type { NavItem } from '@/types';

const mainNavItems: NavItem[] = [
    {
        title: 'Dashboard',
        href: dashboard(),
        icon: LayoutGrid,
    },
    {
        title: 'Products',
        href: products(),
        icon: Carrot,
    },
    {
        title: 'Categories',
        href: categories(),
        icon: Folder,
    },
    {
        title: 'Product Groups',
        href: productGroups(),
        icon: Package,
    },
    {
        title: 'Params',
        href: params(),
        icon: Tags,
    },
];

const footerNavItems: NavItem[] = [
    {
        title: 'Repository',
        href: 'https://github.com/laravel/vue-starter-kit',
        icon: FolderGit2,
    },
    {
        title: 'Documentation',
        href: 'https://laravel.com/docs/starter-kits#vue',
        icon: BookOpen,
    },
];
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="dashboard()">
                            <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <NavMain :items="mainNavItems" />
        </SidebarContent>

        <SidebarFooter>
            <NavFooter :items="footerNavItems" />
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
