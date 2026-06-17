<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import Heading from '@/components/Heading.vue';
import { Button } from '@/components/ui/button';
import { Separator } from '@/components/ui/separator';
import { useCurrentUrl } from '@/composables/useCurrentUrl';
import { toUrl } from '@/lib/utils';
import { edit as editAppearance } from '@/routes/appearance';
import { edit as editProfile } from '@/routes/profile';
import { edit as editSecurity } from '@/routes/security';
import { edit as editIdentitas } from '@/routes/identitas';
import { index as indexPendidikan } from '@/routes/pendidikan';
import { index as indexPengalaman } from '@/routes/pengalaman';
import { index as indexPortofolio } from '@/routes/portofolio';
import { index as indexKontak } from '@/routes/kontak';
import { index as indexSkills } from '@/routes/skills';
import { User, Shield, Palette, FileText, GraduationCap, Briefcase, FolderGit2, Share2, Code2 } from '@lucide/vue';
import type { NavItem } from '@/types';

const sidebarNavItems: NavItem[] = [
    {
        title: 'Profile',
        href: editProfile(),
        icon: User,
    },
    {
        title: 'Security',
        href: editSecurity(),
        icon: Shield,
    },
    {
        title: 'Appearance',
        href: editAppearance(),
        icon: Palette,
    },
    {
        title: 'Identitas Portofolio',
        href: editIdentitas(),
        icon: FileText,
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
        title: 'Galeri Portofolio',
        href: indexPortofolio(),
        icon: FolderGit2,
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

const { isCurrentOrParentUrl } = useCurrentUrl();
</script>

<template>
    <div class="px-6 py-8 sm:px-8">
        <Heading
            title="Settings"
            description="Manage your profile and account settings"
        />

        <div class="flex flex-col lg:flex-row lg:space-x-12">
            <aside class="w-full shrink-0 lg:w-56">
                <nav
                    class="flex flex-row flex-wrap gap-1 lg:flex-col lg:space-y-0.5"
                    aria-label="Settings"
                >
                    <Button
                        v-for="item in sidebarNavItems"
                        :key="toUrl(item.href)"
                        variant="ghost"
                        :class="[
                            'w-full justify-start text-left gap-2.5 px-3 py-2 h-auto text-sm font-normal',
                            { 'bg-muted font-medium text-foreground': isCurrentOrParentUrl(item.href),
                              'text-muted-foreground hover:text-foreground': !isCurrentOrParentUrl(item.href) },
                        ]"
                        as-child
                    >
                        <Link :href="item.href">
                            <component :is="item.icon" class="h-4 w-4 shrink-0" />
                            <span>{{ item.title }}</span>
                        </Link>
                    </Button>
                </nav>
            </aside>

            <Separator class="my-6 lg:hidden" />

            <div class="flex-1 min-w-0 md:max-w-2xl">
                <section class="max-w-xl space-y-12">
                    <slot />
                </section>
            </div>
        </div>
    </div>
</template>
