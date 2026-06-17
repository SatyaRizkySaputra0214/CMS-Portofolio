<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import {
    LayoutGrid,
    FileText,
    GraduationCap,
    Briefcase,
    FolderGit2,
    Share2,
    Code2
} from '@lucide/vue';
import AppLogo from '@/components/AppLogo.vue';
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
    SidebarRail,
} from '@/components/ui/sidebar';
import { dashboard } from '@/routes';
import { edit as editIdentitas } from '@/routes/identitas';
import { index as indexPendidikan } from '@/routes/pendidikan';
import { index as indexPengalaman } from '@/routes/pengalaman';
import { index as indexPortofolio } from '@/routes/portofolio';
import { index as indexKontak } from '@/routes/kontak';
import { index as indexSkills } from '@/routes/skills';
import type { NavItem } from '@/types';

const mainNavItems: NavItem[] = [
    {
        title: 'Dashboard',
        href: dashboard(),
        icon: LayoutGrid,
    },
    {
        title: 'Identitas Portofolio',
        href: editIdentitas(),
        icon: FileText,
    },
    {
        title: 'Galeri Portofolio',
        href: indexPortofolio(),
        icon: FolderGit2,
    },
    {
        title: 'Riwayat Pendidikan',
        href: indexPendidikan(),
        icon: GraduationCap,
    },
    {
        title: 'Riwayat Pengalaman',
        href: indexPengalaman(),
        icon: Briefcase,
    },
    {
        title: 'Tautan Kontak',
        href: indexKontak(),
        icon: Share2,
    },
    {
        title: 'Skills',
        href: indexSkills(),
        icon: Code2,
    },
];
</script>

<template>
    <Sidebar collapsible="offcanvas" variant="inset">
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
            <NavUser />
        </SidebarFooter>
        <SidebarRail />
    </Sidebar>
    <slot />
</template>
