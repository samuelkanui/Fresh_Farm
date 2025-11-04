<script setup lang="ts">
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
import { dashboard } from '@/routes';
import { type NavItem } from '@/types';
import { Link, usePage } from '@inertiajs/vue3';
import { 
    BookOpen, 
    Folder, 
    LayoutGrid, 
    ShoppingCart, 
    Clock, 
    DollarSign, 
    Users, 
    Package, 
    Calendar 
} from 'lucide-vue-next';
import AppLogo from './AppLogo.vue';
import { computed } from 'vue';

const page = usePage();
const isAdmin = computed(() => page.props.auth?.user?.role === 'admin');

const mainNavItems: NavItem[] = [
    {
        title: 'Dashboard',
        href: dashboard(),
        icon: LayoutGrid,
    },
];

const adminNavItems: NavItem[] = [
    {
        title: 'Total Orders',
        href: '/admin/orders',
        icon: ShoppingCart,
        description: 'All time orders',
    },
    {
        title: 'Pending Orders',
        href: '/admin/orders/pending',
        icon: Clock,
        description: 'Awaiting approval',
    },
    {
        title: 'Total Revenue',
        href: '/admin/revenue',
        icon: DollarSign,
        description: 'Lifetime earnings',
    },
    {
        title: 'Total Customers',
        href: '/admin/customers',
        icon: Users,
        description: 'Registered users',
    },
    {
        title: 'Total Products',
        href: '/admin/products',
        icon: Package,
        description: 'Product catalog',
    },
    {
        title: 'Pending Bookings',
        href: '/admin/bookings/pending',
        icon: Calendar,
        description: 'Awaiting confirmation',
    },
];

const footerNavItems: NavItem[] = [
    {
        title: 'Github Repo',
        href: 'https://github.com/laravel/vue-starter-kit',
        icon: Folder,
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
            <NavMain v-if="isAdmin" :items="adminNavItems" title="Admin Stats" />
        </SidebarContent>

        <SidebarFooter>
            <NavFooter :items="footerNavItems" />
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
